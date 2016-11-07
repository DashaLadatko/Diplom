<?php

namespace common\components\language;

use yii\web\UrlManager;
use common\components\language\Lang;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if (isset($params['lang_id'])) {
            //Если указан идентификатор языка, то делаем попытку найти язык в БД,
            //иначе работаем с языком по умолчанию
            $lang = Lang::findOne($params['lang_id']);
            if ($lang === null) {
                $lang = Lang::getDefaultLang();
            }
            unset($params['lang_id']);
        } else {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = Lang::getCurrent();
        }

        //Получаем сформированный URL(без префикса идентификатора языка)
        $url = parent::createUrl($params);

        //Добавляем к URL префикс - буквенный идентификатор языка
        if ($url == '/') {
            return '/' . $lang->url .'/';
        } else {
            $baseUrl = $this->getBaseUrl();
            if (strlen($baseUrl) > 0 && strpos($url, $baseUrl) !== false) {
                return $baseUrl . '/' . $lang->url . substr($url, strlen($baseUrl));
            }
            return '/' . $lang->url . $url;
        }
    }
}