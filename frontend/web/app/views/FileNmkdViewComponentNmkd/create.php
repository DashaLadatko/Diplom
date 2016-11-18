<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ComponentNmkd */

$this->title = 'Create Component Nmkd';
$this->params['breadcrumbs'][] = ['label' => 'Component Nmkds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="component-nmkd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
