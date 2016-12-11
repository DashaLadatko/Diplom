<?php
/**
 * Created by PhpStorm.
 * User: Dasha
 * Date: 028 28.11.16
 * Time: 22:23
 */
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Alert;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Зміна паролю користувача: ' . $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Користувачі', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->email, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Зміна паролю', 'url' => ['changepassword']];
?>



<h1><?= Html::encode($this->title) ?></h1>

<div class="user-changepassword">

    <?php $form = ActiveForm::begin(['id' => 'form-changepassword']); ?>

    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true])  ?>
    <?= $form->field($model, 'new_password')->passwordInput()  ?>
    <?= $form->field($model, 'confirm_new_password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти зміни', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>