<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Filenmkd */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Filenmkds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filenmkd-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Оновити', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ви впевнені, що хочете видалити файл?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'disciplineName',
            'componentnmkdName',
            'name',
            'fullName',
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
