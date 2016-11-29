<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Filenmkd */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filenmkd-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($up_file, 'imageFile')->fileInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Звантажаити', ['class' =>  'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>