<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Faculty */

$this->title = 'Додати факультет';
$this->params['breadcrumbs'][] = ['label' => 'Факультети', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
