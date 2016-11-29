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
        <?= Html::a('Файли НМКД', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            // 'discipline_id',
            //'component_nmkd_id',
            'name',
            //'user_id',
            'disciplineName',
            'fullName',
            'componentnmkdName',
            ['label'=>'signature',
                'attribute'=>'signature',
                'filter'=>array('not loaded'=>'not loaded', 'out for approval'=> 'out for approval', 'rejected'=> 'rejected',)],

            //'protocol_chair',
            ['label'=>'protocol_chair',
                'attribute'=>'protocol_chair',
                'filter'=>array('0'=>'NO', '1'=> 'YES',)],
            //'protocol_fuculty',
            ['label'=>'protocol_fuculty',
                'attribute'=>'protocol_fuculty',
                'filter'=>array('0'=>'NO', '1'=> 'YES',)],
            // 'protocol_university',
            ['label'=>'protocol_university',
                'attribute'=>'protocol_university',
                'filter'=>array('0'=>'NO', '1'=> 'YES',)],
            'comment',
            ['label'=>'total',
                'attribute'=>'total',
                'filter'=>array('0'=>'NO', '1'=> 'YES',)],
            //'total',

            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],

    ]); ?>
    <?php Pjax::end(); ?></div>
