<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FileNmkdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'File Nmkds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-nmkd-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create File Nmkd', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'discipline_id',
            'component_nmkd_id',
            'name',
            'user_id',
            // 'signature',
            // 'protocol_chair',
            // 'protocol_fuculty',
            // 'protocol_university',
            // 'comment',
            // 'total',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
