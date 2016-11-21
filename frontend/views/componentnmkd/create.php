<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Componentnmkd */

$this->title = 'Create Componentnmkd';
$this->params['breadcrumbs'][] = ['label' => 'Componentnmkds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="componentnmkd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
