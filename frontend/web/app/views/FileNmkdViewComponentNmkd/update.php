<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ComponentNmkd */

$this->title = 'Update Component Nmkd: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Component Nmkds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="component-nmkd-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
