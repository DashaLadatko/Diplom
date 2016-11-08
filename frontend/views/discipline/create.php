<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Discipline */

$this->title = 'Додати дисципліну';
$this->params['breadcrumbs'][] = ['label' => 'Дисципліни', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discipline-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
