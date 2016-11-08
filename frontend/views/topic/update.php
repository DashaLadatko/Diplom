<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = 'Редагувати тему: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Теми', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редагувати';
?>
<div class="topic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
