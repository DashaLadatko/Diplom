<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Користувачі', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php

        if ($model->isActive()) {
            echo Html::a('Видалити', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Ви впевнені, що хочете видалити??',
                    'method' => 'post',
                ],
            ]);
        } elseif(Yii::$app->user->id !== $model->id) {
            echo Html::a('Відновити', ['restore', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'last_name',
            'first_name',
            'second_name',
            'email:email',
//            'status',
            'role',
        ],

    ]) ?>

</div>
