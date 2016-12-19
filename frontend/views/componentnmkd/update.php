<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Componentnmkd */

$this->title = '' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Компоненти НМКД', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="componentnmkd-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
