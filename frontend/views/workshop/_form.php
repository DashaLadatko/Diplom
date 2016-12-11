<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use common\models\Topic;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Workshop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="workshop-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'topic_id')->dropDownList(ArrayHelper::map(Topic::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'practical' => 'Практична робота',  'laboratory' => 'Лабораторна робота', 'lecture' => 'Лекція', ], ['prompt' => 'Виберіть тип роботи...']) ?>


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
        <?= Html::submitButton($model->isNewRecord ? 'Створити' : 'Редагувати', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
