<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FileNmkdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-nmkd-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'discipline_id') ?>

    <?= $form->field($model, 'component_nmkd_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'signature') ?>

    <?php // echo $form->field($model, 'protocol_chair') ?>

    <?php // echo $form->field($model, 'protocol_fuculty') ?>

    <?php // echo $form->field($model, 'protocol_university') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
