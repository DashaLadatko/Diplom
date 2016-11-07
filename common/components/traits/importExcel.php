<?php

namespace common\components\traits;

trait importExcel
{
    /**
     * @param array $config
     * @return \common\components\excel\importExcel
     */
    public static function getImport(array $config = [])
    {
        return new \common\components\excel\importExcel($config);
    }

    /**
     * @param $path
     * @param $attributes
     * @param int $begin
     * @return array|bool
     */
    public static function import($path, $attributes, $begin = 1)
    {
        return self::getImport()->setBegin($begin)->setAttributes($attributes)->generate($path, static::class);
    }
}