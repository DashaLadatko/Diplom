<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Department;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DisciplineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дисципліни';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discipline-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Додати дисципліну', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            [
                'attribute' => 'department_id',
                'value' => function ($data) {
                    return $data->department->name;
                },
//                'visible' => (Yii::$app->user->identity->role === User::$roles[0]),
                'filter' => Html::activeDropDownList($searchModel, 'name', ArrayHelper::map(Department::find()->where(['status' => Department::STATUS_ACTIVE])->all(), 'id', 'name'), ['prompt' => 'Виберіть кафедру...', 'class' => 'form-control']),
            ],
            'name',
           // 'status',
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
                            'data-confirm' => Yii::t('yii', 'Ви впевнені, що хочете видалити?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return ($model->status === User::STATUS_ACTIVE && (Yii::$app->user->identity->role === User::$roles[0])) ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options) : "";
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
