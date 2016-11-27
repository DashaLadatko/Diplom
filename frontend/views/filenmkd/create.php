<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Filenmkd */

$this->title = 'Додати НМКД';
$this->params['breadcrumbs'][] = ['label' => 'Filenmkds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filenmkd-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div>




    </div>
    <div class="filenmkd-form">

        <?php $form = ActiveForm::begin(['action' =>['filenmkd/create'], 'id' => 'forum_post', 'method' => 'post',]) ;?>

        <?=
        Html::dropDownList('list', null,  ArrayHelper::map($disciplines, 'id', 'name'),
            ['prompt'=>'- Оберіть дисципліну -' ,'id'=>'0','onchange'=>'
        $.pjax.reload({
        url: "'.Url::to(['filenmkd/create']).'?action="+$(this).val(),
        container: "#pjax-disciplin",
        timeout: 1000,
        });
        ','class'=>'form-control'])?>
        <?php Pjax::begin(['id' => 'pjax-disciplin']); ?>


        <?php  foreach ($components as $row){  ?>
            <?= Html::checkbox('component[]', false, ['value' => $row[id], 'label'  => $row[name]]);?>
            <br>
            <?php  ;}?>
        <div class="form-group">
            <?php if(count($components) >0){ ?>
                <?=Html::submitButton( 'Додати', ['class' => 'btn btn-success' ]) ?>
            <?php }?>
        </div>

        <?php Pjax::end(); ?>


        <?php ActiveForm::end(); ?>
    </div>
