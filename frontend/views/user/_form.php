<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Department;
use common\models\Group;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'second_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'role')->dropDownList(User::$roles, ['prompt' => 'Виберіть роль...']) ?>
    <div id="field-create-student">
        <?= $form->field($model, 'department_id')->dropDownList(ArrayHelper::map(Department::find()->all(), 'id', 'name'),
            ['prompt' => 'Виберіть кафедру...']
        ) ?>
        <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(Group::find()->all(), 'id', 'name'),
        ['prompt'=> 'Виберіть групу...']
        ) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Створити' : 'Зберегти', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <script>
        document.getElementById('user-role').onchange = function () {

            if (document.getElementById('user-role').value == 2) {
                document.getElementById('field-create-student').style.display = "block";
            } else {
                document.getElementById('field-create-student').style.display = "none";
            }
        };

        document.getElementById('field-create-student').style.display = "none";
    </script>

</div>


