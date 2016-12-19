<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Filenmkd */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Файли НМКД', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filenmkd-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Оновити', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if($model->user_id === Yii::$app->user->identity->getId()){
            echo Html::a('Видалити', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Ви впевнені, що хочете видалити файл?',
                    'method' => 'post',
                ],
            ]);

        }?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['label'=>'Дисципліна',
                'attribute'=>'disciplineName',],
            ['label'=>'Викладач',
                'attribute'=>'fullName',],
            ['label'=>'Компонент НМКД',
                'attribute'=>'componentnmkdName'],
            'name',

            'signature',
            [
                'attribute' => 'protocol_chair',
                'value' => $model->protocol_chair? 'Так' : 'Ні'

            ],
            [
                'attribute' => 'protocol_fuculty',
                'value' => $model->protocol_fuculty? 'Так' : 'Ні'

            ],
            [
                'attribute' => 'protocol_university',
                'value' => $model->protocol_university? 'Так' : 'Ні'

            ],
            [
                'attribute' => 'total',
                'value' => $model->total? 'Так' : 'Ні'

            ],
            //'protocol_chair',
            //'protocol_fuculty',
            //'protocol_university',
            'comment',
            //'total',
            [
                'attribute' => 'created_at',
                'value' => $model->updated_at ? date('Y-m-d H:i:s', $model->updated_at) : '',
            ],[
                'attribute' => 'updated_at',
                'value' => $model->updated_at ? date('Y-m-d H:i:s', $model->updated_at) : '',
            ],
            [
                'attribute' => 'created_by',
                'value' => $model->created_by ? User::getById($model->created_by)->email : '',
            ],
            [
                'attribute' => 'updated_by',
                'value' => $model->updated_by ? User::getById($model->updated_by)->email : '',
            ],
        ],
    ]) ?>

</div>
