<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Mark */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mark-form">

    <?php $form = ActiveForm::begin(); ?>

    <? if (isset($model->user_id)) {
        echo \common\models\User::getById($model->user_id)->getFullName();
    } ?>


    <?= $form->field($model, 'workshop_id')->textInput() ?>

    <?= $form->field($model, 'text')->textarea(); ?>

    <? if (\common\models\User::isRole(['Staff', 'Admin'])) {
        echo $form->field($model, 'evaluation')->dropDownList(['1' => '1', '2' => '2', '3' => '3', '4' => '4',], ['prompt'=>'Choose...']);

        echo $form->field($model, 'type')->dropDownList([\common\models\Mark::TYPE_ACCEPT => 'ACCEPT', \common\models\Mark::TYPE_NO_ACCEPT => 'NO_ACCEPT'], ['prompt'=>'Choose...']);
    } ?>


    <?php
    $initialPreview = [];
    $initialPreviewConfig = [];

    if ($model->attachments) {
        foreach ($model->attachments as $item) {
            $initialPreview[] = Html::img($item->miniature, [
                'class' => 'file-preview-image',
                'alt' => $item->name,
                'title' => $item->name,
                'head' => '100px',
                'width' => '100px'
            ]);

            $initialPreviewConfig[] = [
                'width' => '120px',
                'url' => Url::to(['attachment/delete']),
                'key' => "$item->id\" name=\"$item->type",
                'caption' => $item->name
            ];
        }
    }
    $config = [
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'uploadAsync' => false,
            'showRemove' => true,
            'showUpload' => false,
            'overwriteInitial' => false,
            'initialPreviewShowDelete' => true,
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
        ],
        'pluginEvents' => [
            'filepredelete' => "function(event, key) { return (!confirm('Вы уверены, что хотите удалить?')); }",
            'filedelete' => 'function(event, key) { console.log(\'File is delete\'); }',
        ]
    ];

    if (!$model->isNewRecord) {
        $config['pluginOptions']['otherActionButtons'] = '
            <button type="button" class="btn-download  btn btn-xs btn-default" id="Download" title="Download"  {dataKey} ><i class="glyphicon glyphicon-download"></i></button>';
    }

    echo $form->field($model, 'files[]')->widget(\kartik\file\FileInput::classname(), $config);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end();

    $this->registerJs("
    var index;
    var elements = document.getElementsByName(\"unknown\");

    for (index = 0; index < elements.length; index++) {

    if ($(elements[index]).attr(\"id\") == 'Print') {
    elements[index].remove();
    }
    if ($(elements[index]).attr(\"id\") == 'View') {
    elements[index].setAttribute(\"disabled\",\"disabled\");
    }
    }
    var ind;
    var doc = document.getElementsByName(\"document\");

    for (ind = 0; ind < doc.length; ind++) {

    if ($(doc[ind]).attr(\"id\") == 'Print') {
    doc[ind].remove();
    }
    }

    $('.btn-download').click(function () {
    window.open('" . Url::toRoute('attachment/download') . "?id='+$(this).attr('data-key'));
    });

    $('.btn-print').click(function () {
    window.open('" . Url::toRoute('attachment/print') . "?id='+$(this).attr('data-key'));
    });

    $('.btn-view').click(function () {
    $.ajax({
    url: \"" . Url::toRoute('attachment/view') . "\",
    type: \"POST\",
    data: {'key': $(this).attr('data-key')},
    success: function (response) {

    var data = JSON.parse(response);
    if(data.open){
    document.getElementById(\"pop-up-image\").src = data.url;
    document.getElementById('modalHeader').innerHTML = ' <h4>' + data.name + '</h4> ';

    $('#modal').data('bs.modal').isShown ?
    $('#modal').find('#modalContent').load($(this).attr('value'))
    :
    $('#modal').modal('show').find('#modalContent').load($(this).attr('value'));

    } else if (data && !data.open) {
    window.open(data.url);
    }
    }
    })});");
    ?>
</div>

