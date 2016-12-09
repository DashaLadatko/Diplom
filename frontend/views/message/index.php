<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Alert;
//use kartik\icons\Icon;
use common\models\Message;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Повідомлення';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php

echo  GridView::widget([
    'dataProvider' => $dataProvider,
    'options' =>  ['class' => 'grid-view table-responsive'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'last_name',
        'first_name',
        'second_name',
//        [
//            'label' => 'Курс',
//            'attribute'=> 'name',
//            'format'=>'raw',
//            'value'=>function($model){
//                return $model->сourses;
//            }
//        ],
//        [
//            'label' => 'Всього',
//            'format'=>'raw',
//            'value'=>function($model){
//                return Message::find()
//                    ->where(['id_to' => Yii::$app->user->id, 'id_from' => $model->id])
//                    ->orWhere(['id_to' => $model->id, 'id_from' => Yii::$app->user->id])
//                    ->count();
//            },
//        ],
//        [
//            'label' => 'Непрочитано',
//            'format'=>'raw',
//            'value'=>function($model){
//                return Message::find()
//                    ->where(['id_to' => Yii::$app->user->id, 'id_from' => $model->id, 'read_or_not' => 1])
//                    ->count();
//            },
//        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{message}',
            'buttons' => [
                'message' => function ($url,$model) {
                    return Html::a(
                        '<span class = \'btn btn-success\'>Діалог</span>',
                        $url);
                },
                'link' => function ($url,$model,$key) {
                    return Html::a('Действие', $url);
                },
            ],
            'controller' => 'message'
        ],
    ],
]); ?>