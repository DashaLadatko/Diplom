<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use common\models\User;
use common\models\Faculty;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кафедри';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Додати кафедру', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
//            'faculty_id',

            [
                'attribute' => 'faculty_id',
                'value' => function ($data) {
                    return $data->faculty->name;

                },
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'faculty_id',
                    'data' => ArrayHelper::map(Faculty::find()->where(['status' => Faculty::STATUS_ACTIVE])->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Виберіть факультет...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
//                'visible' => (!empty($visibleFields)) ? in_array('areaName', $visibleFields) : true,
            ],

            'name',
           //'created_at',
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return $data->getStatusLabel();
                },
//                'visible' => (Yii::$app->user->identity->role === User::$roles[0]),
                'filter' => Html::activeDropDownList($searchModel, 'status', User::getArrayStatus(), ['prompt' => 'Виберіть статус...', 'class' => 'form-control']),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {restore}',
                'buttons' => [

                    'view' => function ($url) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'Переглянути')
                        ]);
                    },

                    'update' => function ($url, $model, $key) {
                        $options = ['title' => Yii::t('yii', 'Редагувати'), 'aria-label' => Yii::t('yii', 'Редагувати'), 'data-pjax' => '0'];
                        return ($model->status === User::STATUS_ACTIVE) ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options) : '';
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Видалити'),
                            'aria-label' => Yii::t('yii', 'Видалити'),
                            'data-confirm' => Yii::t('yii', 'Ви впевнені, що хочите видалити?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return ($model->status === User::STATUS_ACTIVE && (Yii::$app->user->identity->role == User::$roles[0])) ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options) : "";
                    },
                    'restore' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Відновити'),
                            'aria-label' => Yii::t('yii', 'Відновити'),
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
