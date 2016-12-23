<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Filenmkd */

$this->title = 'Редагування ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Файли НМКД', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Оновлення';
?>
<div class="filenmkd-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'file' =>$file
    ]) ?>

</div>
