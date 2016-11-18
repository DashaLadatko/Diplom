<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FileNmkd */

$this->title = 'Create File Nmkd';
$this->params['breadcrumbs'][] = ['label' => 'File Nmkds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-nmkd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
