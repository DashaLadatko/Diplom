<?php



use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
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

    <p>
        <?= Html::a('Додати НМКД', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>    <div style="overflow: scroll;"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',

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
            //'protocol_chair',

            ['label'=>'Протокол кафедри',
                'attribute'=>'protocol_chair',
                'filter'=>array('0'=>'Ні', '1'=> 'Так',),

                'headerOptions' => ['width' => '100']],
            //'protocol_fuculty',
            ['label'=>'Протокол факультету',
                'attribute'=>'protocol_fuculty',

                'filter'=>array('0'=>'Ні', '1'=> 'Так',)],
            // 'protocol_university',
            ['label'=>'Протокол університету',
                'attribute'=>'protocol_university',
                'filter'=>array('0'=>'Ні', '1'=> 'Так',)],
            'comment',
            ['label'=>'Остаточно затверджено',
                'attribute'=>'total',
                'filter'=>array('0'=>'Ні', '1'=> 'Так',)],
            //'total',

            //'created_at',
            ['format'=>'datetime','attribute'=>'created_at'],
            // 'created_by',
            //'updated_at',
            ['format'=>'datetime','attribute'=>'updated_at'],
            //'updated_by',

            ['class' => 'yii\grid\ActionColumn',

                'template' => '{view} {update}  {link}',],
        ],


    ]); ?></div>
    <?php Pjax::end();  ?>
