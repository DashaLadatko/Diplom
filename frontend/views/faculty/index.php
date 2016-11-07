<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\FacultySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Faculties';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Faculty', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return $data->getStatusLabel();
                },
//                'visible' => (Yii::$app->user->identity->role === User::$roles[0]),
                'filter' => Html::activeDropDownList($searchModel, 'status', User::getArrayStatus(), ['prompt' => '', 'class' => 'form-control']),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {restore}',
                'buttons' => [

                    'view' => function ($url) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'Посмотреть')
                        ]);
                    },

                    'update' => function ($url, $model, $key) {
                        $options = ['title' => Yii::t('yii', 'Обновить'), 'aria-label' => Yii::t('yii', 'Обновить'), 'data-pjax' => '0'];
                        return ($model->status === User::STATUS_ACTIVE) ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options) : '';
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Удалить'),
                            'aria-label' => Yii::t('yii', 'Удалить'),
                            'data-confirm' => Yii::t('yii', 'Вы уверены, что хотите удалить?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return ($model->status === User::STATUS_ACTIVE && (Yii::$app->user->identity->role === User::$roles[0])) ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options) : "";
                    },
                    'restore' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Восстановить'),
                            'aria-label' => Yii::t('yii', 'Восстановить'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return ($model->status === User::STATUS_IN_ACTIVE) ? Html::a('<span class="glyphicon glyphicon-hand-up"></span>', $url, $options) : '';
                    },
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
