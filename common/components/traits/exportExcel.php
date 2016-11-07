<?php

namespace common\components\traits;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

trait exportExcel
{
    /**
     * @param array $config
     * @return \common\components\excel\exportExcel
     */
    public static function getExport(array $config = [])
    {
        return new \common\components\excel\exportExcel($config);
    }

    /**
     * @param array $models
     * @param array $header
     * @return bool|string
     * @throws \yii\base\InvalidConfigException
     */
    public static function export(array $models, array $header = [])
    {
        if ($models) {

            if ($header) {
                $count = count($header) - 1;
                for (; $count >= 0; $count--) {
                    array_unshift($models, $header[$count]);
                }
            }

            $link = self::getExport()
                ->setPath(Yii::$app->uploader->module . '/web/import/' . self::lastNameClass() . '/')
                ->generate($models);

            return Yii::$app->urlManager->getHostInfo() . Yii::$app->uploader->folder . '/' . $link;
        }
        return false;
    }
}