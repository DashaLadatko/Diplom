<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Filenmkd */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="filenmkd-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <?= $form->field($model, 'disciplineName')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'componentnmkdName')->textInput(['readonly'=>'readonly']) ?>

    <?php if($model->name === '' || $model->name === NULL ){ if(  $model->user_id === Yii::$app->user->identity->getId()){?>
        <?=  Html::a('Завантажити файл на сервер', ['file', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    <?php }} else { ?>
        <?=  Html::a('Завантажити файл на пк '.$model->name, ['download', 'id' => $model->id], ['class' => 'profile-link']) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly'=>'readonly']) ?>
        <?php if(  $model->user_id === Yii::$app->user->identity->getId()){?>
            <?=  Html::a('Видалити файл', ['deletefile', 'id' => $model->id], ['class' => 'profile-link','data' => [
                'confirm' => 'Ви дійсно хочете видалити файл?',
                'method' => 'post',
            ]]) ?>
        <?php } } ?>

    <?= $form->field($model, 'fullName')->textInput(['readonly'=>'readonly']) ?>


    <?= $form->field($model, 'signature')->dropDownList([ 'not loaded' => 'Не завантажено', 'out for approval' => 'На розгляді', 'rejected' => 'Відхилено', 'approved' => 'Затверджено', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'protocol_chair')->checkbox(['label' => 'Протокол кафедри' ]) ?>

    <?= $form->field($model, 'protocol_fuculty')->checkbox(['label' => 'Протокол факультету' ]) ?>

    <?= $form->field($model, 'protocol_university')->checkbox(['label' => 'Протокол університету' ]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->checkbox([
        'labelOptions' => [
            'style' => 'padding-left:20px;'
        ],
        'disabled' => false]) ?>

    <?= $form->field($model, 'created_at')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'created_by')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'updated_at')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'updated_by')->textInput(['readonly'=>'readonly']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Оновити', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
