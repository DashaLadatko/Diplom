<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Workshop */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Workshops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workshop-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php

        if ($model->isActive()) {
            echo Html::a('Видалити', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Ви впевнені, що хочете видалити??',
                    'method' => 'post',
                ],
            ]);
        } else {
            echo Html::a('Відновити', ['restore', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'topic_id',
            'name',
            'description:ntext',
            'type',
//            'status',
//            'created_at',
//            'created_by',
//            'updated_at',
//            'updated_by',
            [
                'attribute' => 'status',
                'value' => $model->getStatusLabel(),
                'visible' => (Yii::$app->user->identity->role === User::$roles[0]),
            ],
            [
                'attribute' => 'created_at',
                'value' => $model->updated_at ? date('Y-m-d H:i:s', $model->updated_at) : '',
            ],
            [
                'attribute' => 'created_by',
                'value' => $model->created_by ? User::getById($model->created_by)->getFullName() : '',
            ], [
                'attribute' => 'updated_at',
                'value' => $model->updated_at ? date('Y-m-d H:i:s', $model->updated_at) : '',
            ],
            [
                'attribute' => 'updated_by',
                'value' => $model->updated_by ? User::getById($model->updated_by)->getFullName() : '',
            ],
        ],

    ]) ?>


    <?php

    echo '<h1>Файлы</h1>';
    /**
     * @var \common\models\Attachment $file
     */
    foreach ($model->getAttachments() as $file) { ?>
        <div class='detail-view-files'>
            <img src='<?= $file->miniature ?>' width='100' height='100' alt='<?= $file->real_name ?>'>
            <p><?= $file->getBaseName(15) ?>
<!--                --><?//= $file->type !== \common\components\upload\uploader::TYPE_UNKNOWN ? "<p><a href='$file->url' target=\"_blank\" ><i class=\"glyphicon glyphicon-eye-open\"></i>Open</a>" : ''; ?>
            <p><a class="btn-download" style="cursor: pointer;" data-key="<?= $file->id ?>"><i class="glyphicon glyphicon-download"></i>Download</a>
        </div>
    <? }
    ?>

    <?php
    $this->registerJs("
         $('.btn-download').click(function () {
             window.open('" . Url::toRoute('attachment/download') . "?id='+$(this).attr('data-key'));
        });"
    ); ?>


</div>
