<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = 'Додати тему';
$this->params['breadcrumbs'][] = ['label' => 'Теми', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
