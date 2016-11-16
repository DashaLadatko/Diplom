<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;
use kartik\tabs\TabsX;
use common\models\User;


/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Теми', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-view">

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
//            'id',
            'name',
//            'time_of_passage:datetime',
            [
                'attribute'=> 'time_of_passage',
                'format'=>'raw',
                'value'=>  date('d-m-Y', $model->time_of_passage),
            ],
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

    <?php $active = Yii::$app->getRequest()->get('active');?>
    <?php
    $tabs[0] = [
        'label' => 'Групи',
        'content' => $this->render('/group\index', [
            'group_id' => $model->id,
//            'searchModel' => $ModelCourseGroupUser,
//            'searchModelGroup' => $searchModelGroup,
        ]),
//        'options' => ['group_id' => 'id'],
//        'active' => (!$active || $active == 'personal-groups')
    ];
    $tabs[1] = [
        'label' => 'Групи',
        'content' => 'text',
        'active' => true
    ];

    ?>
    <?= TabsX::widget([
        'position' => TabsX::POS_ABOVE,
        'align' => TabsX::ALIGN_LEFT,
        'bordered'=>true,
        'items' => $tabs
    ]);

    $this->title = $model->name;
    ?>

</div>
