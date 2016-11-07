<?php

namespace common\components\excel;

use \PHPExcel_IOFactory;
use yii\base\Object;
use common\models\Excel;
use common\models\ExportExcelLog;

/**
 * Class export
 * @package common\components\excel
 *
 * @property array $params
 * @property integer $idKey
 */
class importExcel extends Object
{
    const SAVE_UPDATE_EVENT = 'update';
    const SAVE_INSERT_EVENT = 'insert';
    const SAVE_ERROR_EVENT = 'error';
    const SAVE_ERROR_EXCEPTION = 'exception';

    protected $path;

    protected $begin = 1;

    protected $idKey;

    protected $params = [];

    protected $_attributes = [];

    protected $_logs = [];


    public function generate($path, $ns)
    {
        $array = $this->readerCreate($path)->getActiveSheet()->toArray(null, true, true, false);


        if ($array && $this->_attributes) {
            $models = $this->prepere($array, $this->_attributes);

            $c = 0;
            $u = 0;
            $e = 0;

            foreach ($models as $key => $item) {

                $model = $ns::findOne($item[$this->idKey]) ?: new $ns();
                $params = $this->getValidAttribute($item);

                $isNew = $model->isNewRecord;
                $isLoad = $model->load($params);

                $diff = array_diff_assoc($model->attributes, $model->oldAttributes);

                try {
                    if ($isLoad && $diff && $model->save(false)) {

                        $this->pushLog([
                            'primary' => $item[$this->idKey],
                            'type' => $isNew ? ExportExcelLog::TYPE_INSERT : ExportExcelLog::TYPE_UPDATE,
                            'diff' => $diff,
                            'message' => null
                        ]);

                        $isNew ? $c++ : $u++;

                    } elseif ($diff) {
                        $this->pushLog(['primary' => $item[$this->idKey], 'type' => ExportExcelLog::TYPE_ERROR, 'message' => $model->errors() ?: "Load error. (is $isLoad)."]);
                        $e++;
                    }
                } catch (\Exception $e) {
                    $this->pushLog(['primary' => $item[$this->idKey], 'type' => ExportExcelLog::TYPE_EXCEPTION, 'message' => $e->getMessage()]);
                }
            }
            return [
                'log' => $this->_logs,
                'count' => [
                    'create' => $c,
                    'update' => $u,
                    'error' => $e
                ]
            ];
        }
        return false;
    }

    public function pushLog(array $array)
    {
        $this->_logs[] = $array;
    }

    public function prepere($array, $attr)
    {
        $this->params = array_intersect($array[0], $attr);
        $this->idKey = array_search('id', $this->params, false);

        return array_slice($array, $this->begin);
    }

    public function getValidAttribute($item)
    {
        $array = [];
        foreach ($this->params as $k => $name) {
            $array[$name] = $item[$k];
        }
        return $array;
    }

    public function readerCreate($filePath, $sheetName = 0)
    {
        $objReader = PHPExcel_IOFactory::createReader(PHPExcel_IOFactory::identify($filePath));
        $sheetNames = $objReader->listWorksheetNames($filePath);
        $objReader->setLoadSheetsOnly($sheetNames[$sheetName]);

        return $objReader->load($filePath);
    }


    # Getter

    public function getBegin()
    {
        return $this->begin;
    }

    public function setBegin($value)
    {
        $this->begin = $value;

        return $this;
    }


    public function getAttributes()
    {
        return $this->_attributes;
    }

    public function setAttributes(array $attributes)
    {
        $this->_attributes = $attributes;

        return $this;
    }
}