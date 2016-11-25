<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;
use kartik\tabs\TabsX;
use common\models\User;
use common\models\CourseGroupUser;
use common\models\Group;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Теми', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-view">

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
        } else {
            echo Html::a('Відновити', ['restore', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>
    <?= Html::a('mark', Url::toRoute(['/mark/index']), ['class' => 'btn btn-primary']); ?>
    <?= Html::a('Завдання', Url::toRoute(['/workshop/create']), ['class' => 'btn btn-primary']); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'name',
//            'time_of_passage:datetime',
            [
                'attribute' => 'time_of_passage',
                'format' => 'raw',
                'value' => date('d-m-Y', $model->time_of_passage),
            ],
//            'status',
//            'created_at',
//            'created_by',
//            'updated_at',
//            'updated_by',
            [
                'attribute' => 'course_id',
                'value' => $model->getTopicCourses(),
                'visible' => (Yii::$app->user->identity->role === User::$roles[0]),
            ],
            [
                'attribute' => 'status',
                'value' => $model->getStatusLabel(),
                'visible' => (Yii::$app->user->identity->role === User::$roles[0]),
            ],
            [
                'attribute' => 'created_at',
                'value' => $model->updated_at ? date('Y-m-d H:i:s', $model->updated_at) : '',
            ],
            [
                'attribute' => 'created_by',
                'value' => $model->created_by ? User::getById($model->created_by)->email : '',
            ], [
                'attribute' => 'updated_at',
                'value' => $model->updated_at ? date('Y-m-d H:i:s', $model->updated_at) : '',
            ],
            [
                'attribute' => 'updated_by',
                'value' => $model->updated_by ? User::getById($model->updated_by)->email: '',
            ],
        ],
    ]) ?>

    <?php

    $array = $model->workshops;
    $lab = 0;
    $lec = 0;
    $pra = 0;
    $sem = 0;


    echo '<h1>Лекції теми</h1>';

    foreach ($array as $key => $item) {
        if ($item->type === \common\models\Workshop::type_lecture) {
            echo ++$lec . '. <a href=' . Url::toRoute(['/workshop/view', 'id' => $item->id]) . ">$item->name</a><br>";
        }
    }

    if (!$lec) {
        echo '<p>Лекцій не знайдено</p>';
    }

    echo '<h1>Лабораторні роботи</h1>';

    foreach ($array as $key => $item) {
        if ($item->type === \common\models\Workshop::type_laboratory) {
            echo ++$lab . '. <a href=' . Url::toRoute(['/workshop/view', 'id' => $item->id]) . ">$item->name</a><br>";
        }
    }
    if (!$lab) {
        echo '<p>Лабораторних робіт не знайдено</p>';
    }


    echo '<h1>Практичні роботи</h1>';

    foreach ($array as $key => $item) {
        if ($item->type === \common\models\Workshop::type_practical) {
            echo ++$pra . '. <a href=' . Url::toRoute(['/workshop/view', 'id' => $item->id]) . ">$item->name</a><br>";
        }
    }

    if (!$pra) {
        echo '<p>Практичних робіт не найдено</p>';
    }

//    echo '<h1>Семинары</h1>';
//
//    foreach ($array as $key => $item) {
//        if ($item->type === \common\models\Workshop::type_seminar) {
//            echo ++$sem . '. <a href=' . Url::toRoute(['/workshop/view', 'id' => $item->id]) . ">$item->name</a><br>";
//        }
//    }
//
//    if (!$sem) {
//        echo '<p>Семинаров не найдено</p>';
//    }

    ?>
    <!--    --><?php
    //    $tabs[0] = [
    //        'label' => 'Групи',
    //        'content' => $this->render('/group\index', [
    //            'group_id' => $model->id,
    //            'searchModel' => $ModelGroupUser,
    //           'searchModelGroup' => $searchModelGroup,
    //        ]),
    //        'options' => ['group_id' => 'id'],
    //        'active' => (!$active || $active == 'group')
    //
    //    ];
    //    $tabs[1] = [
    //        'label' => 'Групи',
    //        'content' => 'text',
    //        'active' => true
    //    ];
    //
    //    ?>
    <!--    --><? //= TabsX::widget([
    //        'position' => TabsX::POS_ABOVE,
    //        'align' => TabsX::ALIGN_LEFT,
    //        'bordered'=>true,
    //        'items' => $tabs
    //    ]);
    //
    //    $this->title = $model->name;
    //    ?>

</div>
