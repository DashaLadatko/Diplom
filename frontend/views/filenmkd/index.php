<?php



use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\FilenmkdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Файли НМКД';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

</div>
<div class="filenmkd-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if (Yii::$app->user->identity->role === User::ROLE_ADMINNMKD) { ?>
        <p>
            <?= Html::a('Аудит НМКД', ['auditnmkd'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>

    <p>
        <?= Html::a('Додати НМКД', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>    <div style="overflow-x:auto;"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
            'emptyCell'=>'-',
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label'=>'Назва файлу',
                'attribute'=>'name',
                'value'     => function (\common\models\Filenmkd $model) {
                    if ($model->name != null) {
                        return $model->name;
                        //or: return Html::encode($model->some_attribute)
                    } else {
                        return 'Файл не завантажено';
                    }
                },
            ],

            ['label'=>'Дисципліна',
                'attribute'=>'disciplineName',],
            ['label'=>'Викладач',
                'attribute'=>'fullName',
                'contentOptions'=>['style'=>'white-space: normal;']],
            ['label'=>'Компонент НМКД',
                'attribute'=>'componentnmkdName',
                'contentOptions'=>['style'=>'white-space: normal;'] ,],
            ['label'=>'Статус',
                'attribute'=>'signature',
                'filter'=>array('не завантажено'=>'не завантажено', 'на розгляді'=> 'на розгляді',  'затверджено'=>'затверджено')],

            ['label'=>'Протокол кафедри',
                'attribute'=>'protocol_chair',
                'filter'=>array('0'=>'Ні', '1'=> 'Так',),
                'headerOptions' => ['width' => '100']],

            ['label'=>'Протокол факультету',
                'attribute'=>'protocol_fuculty',
                'filter'=>array('0'=>'Ні', '1'=> 'Так',)],

            ['label'=>'Протокол університету',
                'attribute'=>'protocol_university',
                'filter'=>array('0'=>'Ні', '1'=> 'Так',)],
            'comment',
            ['label'=>'Остаточно затверджено',
                'attribute'=>'total',
                'filter'=>array('0'=>'Ні', '1'=> 'Так',)],

            ['format'=>'date','attribute'=>'created_at'],

            ['format'=>'date','attribute'=>'updated_at'],

            ['class' => 'yii\grid\ActionColumn',

                'template' => '{view} {update}  {link}',],
        ],


    ]); ?></div>
    <?php Pjax::end();  ?>
