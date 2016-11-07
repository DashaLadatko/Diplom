<?php

namespace frontend\widgets;

use common\components\language\Lang;

class Langwidget extends \yii\bootstrap\Widget
{

    public function init()
    {
    }

    public function run()
    {
        return $this->render('langwidget/view', [
            'current' => Lang::getCurrent(),
//            'langs' => Lang::find()->where('id != :current_id', [':current_id' => Lang::getCurrent()->id])->all(),
            'langs' => Lang::find()->all(),
        ]);
    }
}