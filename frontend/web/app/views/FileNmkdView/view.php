<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FileNmkd */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'File Nmkds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-nmkd-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'discipline_id',
            'component_nmkd_id',
            'name',
            'user_id',
            'signature',
            'protocol_chair',
            'protocol_fuculty',
            'protocol_university',
            'comment',
            'total',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
