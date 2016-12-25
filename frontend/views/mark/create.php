<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Mark */

$this->title = 'Оцінювання роботи';
$this->params['breadcrumbs'][] = ['label' => 'Marks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mark-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
