<?php

namespace common\components\traits;


trait soft
{
    /**
     * Get Class name
     *
     * @return mixed
     */
    public static function lastNameClass()
    {
        $array = explode('\\', static::className());
        return array_pop($array);
    }

    /**
     * @param array $data
     * @param null|string $formName
     * @return bool
     */
    public function load($data, $formName = null)
    {
        if (!$data) {
            return false;
        }

        $className = $this::lastNameClass();

        if (array_key_exists($className, $data)) {
            return parent::load($data, $formName);
        }

        return parent::load([$className => $data], $formName);
    }

}