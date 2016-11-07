<?php

namespace common\components\traits;


trait errors
{
    # Error

    public function getErrors($attribute = null)
    {
        $errors = parent::getErrors($attribute);
        return \Yii::t('app', $this->errorRecursive($errors));
    }

    protected function errorRecursive($error)
    {
        if (is_array($error)) {
            return $this->errorRecursive(array_shift($error));
        }
        return $error;
    }
}