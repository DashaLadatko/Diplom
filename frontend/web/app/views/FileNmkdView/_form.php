<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FileNmkd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-nmkd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'discipline_id')->textInput() ?>

    <?= $form->field($model, 'component_nmkd_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'signature')->dropDownList([ 'not loaded' => 'Not loaded', 'out for approval' => 'Out for approval', 'rejected' => 'Rejected', 'approved' => 'Approved', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'protocol_chair')->textInput() ?>

    <?= $form->field($model, 'protocol_fuculty')->textInput() ?>

    <?= $form->field($model, 'protocol_university')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
