<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Discipline */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Дисципліни', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discipline-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Курси дисципліни', Url::toRoute(['/course/index']), ['class' => 'btn btn-primary']); ?>

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
            //'id',
            [
                'label'=>'Кафедра',
                'value'=> $model->department->name,

            ],
            'name',
           // 'status',
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
