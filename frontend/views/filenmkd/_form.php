<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Filenmkd */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="filenmkd-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <?= $form->field($model, 'disciplineName')->textInput(['readonly'=>'readonly'])->label('Дисципліна') ?>

    <?= $form->field($model, 'componentnmkdName')->textInput(['readonly'=>'readonly'])->label('Компонент НМКД') ?>


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

    <?= $form->field($model, 'fullName')->textInput(['readonly'=>'readonly'])->label('Викладач') ?>


    <?= $form->field($model, 'signature')->dropDownList([ 'не завантажено' => 'не завантажено', 'на розгляді' => 'на розгляді',  'затверджено' => 'затверджено' ] ) ?>

    <?= $form->field($model, 'protocol_chair')->checkbox(['label' => 'Протокол кафедри' ]) ?>

    <?= $form->field($model, 'protocol_fuculty')->checkbox(['label' => 'Протокол факультету' ]) ?>

    <?= $form->field($model, 'protocol_university')->checkbox(['label' => 'Протокол університету' ]) ?>

    <?= $form->field($model, 'total')->checkbox() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true, 'readonly' => (Yii::$app->user->identity->role !==  common\models\User::ROLE_CHIEF) ? true : false]) ?>






    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Оновити', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
