<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Faculty */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Faculties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php

        if ($model->isActive()) {
            echo Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить?',
                    'method' => 'post',
                ],
            ]);
        } else {
            echo Html::a('Восстановить', ['restore', 'id' => $model->id], [
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
//            'id',
            'name',
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
                'value' => $model->created_by ? User::getById($model->created_by)->username : '',
            ], [
                'attribute' => 'updated_at',
                'value' => $model->updated_at ? date('Y-m-d H:i:s', $model->updated_at) : '',
            ],
            [
                'attribute' => 'updated_by',
                'value' => $model->updated_by ? User::getById($model->updated_by)->username : '',
            ],
        ],
    ]) ?>

</div>
