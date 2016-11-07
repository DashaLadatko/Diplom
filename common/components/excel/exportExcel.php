<?php

namespace common\components\excel;

use Yii;

use PHPExcel;
use PHPExcel_Cell;
use PHPExcel_Style_Border;
use PHPExcel_Writer_Excel5;

use yii\base\Object;
use yii\helpers\FileHelper;

/**
 * Class import
 * @package common\components\excel
 *
 * @property string $path
 * @property string $name
 * @property PHPExcel $phpExcel
 */
class exportExcel extends Object
{
    protected $path;

    protected $name;

    protected $phpExcel;

    public function generate($models)
    {
        if ($models) {

            $xls = $this->getPhpExcel();
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
            $sheet->setTitle('Worksheet');

            $xls = $this->conclusionTable($xls, $models, [
                'headerStyle' => [
                    'borders' => [
                        'allborders' => [
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ]
                    ]
                ],
                'bodyTableStyle' => [
                    'borders' => [
                        'allborders' => [
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ]
                    ]]
            ]);
            return $this->saveFile($xls);
        }
        return false;
    }

    public function saveFile(PHPExcel $xls)
    {
        $this->name = $this->name ?: $this->getDefaultName();
        $this->path = $this->path ?: $this->getDefaultPath();

        $filePath = Yii::getAlias('@' . $this->path);

        FileHelper::createDirectory($filePath, 0777, true);

        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter->save($filePath . $this->name);

        return file_exists($filePath . $this->name) ? $this->path . $this->name : false;
    }

    public function conclusionTable(PHPExcel $xls, array $array, $config = null)
    {
        $y = $config['row'] ?: 1;
        $x = $config['column'] ?: 0;

        if (!is_int($y) && !is_int($x)) {
            throw new \InvalidArgumentException('Row and Column must be in format');
        }

        $attributes = [];

        $styleBeginX = $x;
        $styleBeginY = $y;

        $styleEndCountX = 0;
        $styleEndCountY = 0;

        if ($array) {
            foreach ($array as $k => $v) {

                if ($k === 0) {
                    $headerCount = $x;
                    foreach ($v as $item => $value) {
                        $attributes[$item] = $headerCount++;
                    }
                    $styleEndCountX = $headerCount;
                }

                foreach ($v as $key => $value) {
                    $xls->getActiveSheet()->setCellValueByColumnAndRow($attributes[$key], $y, $value);
                }
                $styleEndCountY = $y++;
            }

            $beginLetter = PHPExcel_Cell::stringFromColumnIndex($styleBeginX);
            $endLetter = PHPExcel_Cell::stringFromColumnIndex(--$styleEndCountX);

            // body style
            if ($config['bodyTableStyle']) {
                $xls->getActiveSheet()->getStyle($beginLetter . $styleBeginY . ':' . $endLetter . $styleEndCountY)->applyFromArray($config['bodyTableStyle']);
            }


//            // header style
//            if ($config['headerStyle']) {
//                $styleEndCountY = count($array) - 1;
//                $xls->getActiveSheet()->getStyle($beginLetter . $styleBeginY . ':' . $endLetter . $styleEndCountY)->applyFromArray($config['headerStyle']);
//            }

            // size
            for ($i = $styleBeginX; $i <= $styleEndCountX; $i++) {
                $xls->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setAutoSize(true);
            }
        }
        return $xls;
    }


    # Getters

    public function getPhpExcel()
    {
        if (!$this->phpExcel) {
            $this->phpExcel = new PHPExcel();
        }

        return $this->phpExcel;
    }

    public function setPhpExcel(PHPExcel $param)
    {
        $this->phpExcel = $param;

        return $this;
    }


    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    # default

    protected function getDefaultName()
    {
        return uniqid(2, true) . '.xls';
    }

    protected function getDefaultPath()
    {
        return Yii::$app->configAttachment->attachment_module . '/web/import/';
    }

}