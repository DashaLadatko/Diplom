<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use common\models\Message;
use common\models\User;

if (Yii::$app->user->can('teacher')) {
    $this->title = 'Повідомлення';
    $this->params['breadcrumbs'][] = ['label' => 'Повідомлення', 'url' => ['messages/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Студенти групи ' . $group->name, 'url' => ['messages/view?id=' . $group->id_group]];
    $this->title = $user->last_name;
    $this->params['breadcrumbs'][] = $this->title;
} elseif (Yii::$app->user->can('student')) {
    $this->title = 'Повідомлення';
    $this->params['breadcrumbs'][] = ['label' => 'Повідомлення', 'url' => ['messages/index']];
    $this->title = $user->last_name . " " . $user->first_name . " " . $user->second_name;
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="message-box">
    <?php
    if ($modelMessage)
        foreach ($modelMessage as $messOne) {
            ?>
            <div class="messInfo">
                <?
                $from = User::find()->where(['id' => $messOne->from_user_id])->one();
                echo $from->fullName . "<br>";
                echo "<small>" . date("d-m-Y H:m:s", $messOne->created_at) . "</small>"; ?>
            </div>
            <?php if ($messOne->from_user_id != Yii::$app->user->id) {
                echo "<div class=\"bubble\"> ";
                echo $messOne->text;
                echo "</div>";
            } else {
                echo "<div class=\"bubble-another\"> ";
                echo $messOne->text;
                echo "</div>";
            }
            echo "<br>";
        }
    ?>
    <div class="message-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'text')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Надіслати', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>