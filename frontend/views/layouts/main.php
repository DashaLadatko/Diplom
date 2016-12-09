<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\User;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<<<<<<< HEAD
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
=======
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <script src="http://diplom/frontend/web/js/jquery-3.1.1.min.js"></script>-->

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
>>>>>>> 340ea476e97c5ef98b790b3e6e62349e3b110bb3

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => 'СДН',
//        'brandLabel' => 'Система дистанційного навчання',
<<<<<<< HEAD
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        //    $menuItems = [
        //        ['label' => 'Головна', 'url' => ['/site/index']],
        //        ['label' => 'Про нас', 'url' => ['/site/about']],
        //        ['label' => 'Контакти', 'url' => ['/site/contact']],
        //
        //    ];
        if (!Yii::$app->user->isGuest) {
            if (\common\models\User::isRole(['Admin'])) {
                $menuItems[] = ['label' => 'Факультети', 'url' => ['/faculty/index']];
                $menuItems[] = ['label' => 'Кафедри', 'url' => ['/department/index']];
                $menuItems[] = ['label' => 'Дисципліни', 'url' => ['/discipline/index']];
                $menuItems[] = ['label' => 'Курси', 'url' => ['/course/index']];
                $menuItems[] = ['label' => 'Групи', 'url' => ['/group/index']];
                $menuItems[] = ['label' => 'Повідомлення', 'url' => ['/message/index']];
                $menuItems[] = ['label' => 'Користувачі', 'url' => ['/user/index']];
                $menuItems[] = ['label' => 'Профіль', 'url' => ['/user/profile', 'id' => Yii::$app->user->id]];
            }
            if (\common\models\User::isRole(['Student'])) {
                $menuItems[] = ['label' => 'Курси', 'url' => ['/course/index']];
                $menuItems[] = ['label' => 'Повідомлення', 'url' => ['/message/index']];
                $menuItems[] = ['label' => 'Теми', 'url' => ['/topic/index']];
                $menuItems[] = ['label' => 'Завдання', 'url' => ['/workshop/index']];
                $menuItems[] = ['label' => 'Профіль', 'url' => ['/user/profile', 'id' => Yii::$app->user->id]];
            }
        }
        //    $menuItems = [
        //       // ['label' => 'Головна', 'url' => ['/site/index']],
        //       // ['label' => 'Про нас', 'url' => ['/site/about']],
        //        //['label' => 'Контакти', 'url' => ['/site/contact']],
        //        ['label' => 'Факультети', 'url' => ['/faculty/index']],
        //        ['label' => 'Кафедри', 'url' => ['/department/index']],
        //        ['label' => 'Дисципліни', 'url' => ['/discipline/index']],
        //        ['label' => 'Курси', 'url' => ['/course/index']],
        //        ['label' => 'Групи', 'url' => ['/group/index']],
        //        ['label' => 'Теми', 'url' => ['/topic/index']],
        //        ['label' => 'Завдання', 'url' => ['/workshop/index']],
        //        ['label' => 'Користувачі', 'url' => ['/user/index']],
        //        ['label' => 'Профіль', 'url' => ['/user/view','id'=>Yii::$app->user->id]],
        //    ];
        if (Yii::$app->user->isGuest) {
            // $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Вхід', 'url' => ['/site/login']];
        } else {
            $menuItems[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Вихід (' . Yii::$app->user->identity->email . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>';
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>
=======
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);


    //    $menuItems = [
    //        ['label' => 'Головна', 'url' => ['/site/index']],
    //        ['label' => 'Про нас', 'url' => ['/site/about']],
    //        ['label' => 'Контакти', 'url' => ['/site/contact']],
    //
    //    ];

    if (!Yii::$app->user->isGuest) {

        if (\common\models\User::isRole(['Admin'])) {
            $menuItems[] = ['label' => 'Факультети', 'url' => ['/faculty/index']];
            $menuItems[] = ['label' => 'Кафедри', 'url' => ['/department/index']];
            $menuItems[] = ['label' => 'Дисципліни', 'url' => ['/discipline/index']];
            $menuItems[] = ['label' => 'Курси', 'url' => ['/course/index']];
            $menuItems[] = ['label' => 'Групи', 'url' => ['/group/index']];
            $menuItems[] = ['label' => 'Повідомлення', 'url' => ['/message/index']];
            $menuItems[] = ['label' => 'Користувачі', 'url' => ['/user/index']];
            $menuItems[] = ['label' => 'Профіль', 'url' => ['/user/profile', 'id' => Yii::$app->user->id]];
        }
        if (\common\models\User::isRole(['Student'])) {
            $menuItems[] = ['label' => 'Курси', 'url' => ['/course/index']];
            $menuItems[] = ['label' => 'Повідомлення', 'url' => ['/message/index']];
            $menuItems[] = ['label' => 'Теми', 'url' => ['/topic/index']];
            $menuItems[] = ['label' => 'Завдання', 'url' => ['/workshop/index']];
            $menuItems[] = ['label' => 'Профіль', 'url' => ['/user/profile', 'id' => Yii::$app->user->id]];
        }
        if (\common\models\User::isRole(['Staff'])) {
            $menuItems[] = ['label' => 'Курси', 'url' => ['/course/index']];
            $menuItems[] = ['label' => 'Повідомлення', 'url' => ['/message/index']];
            $menuItems[] = ['label' => 'Теми', 'url' => ['/topic/index']];
            $menuItems[] = ['label' => 'Завдання', 'url' => ['/workshop/index']];
            $menuItems[] = ['label' => 'Відповіді', 'url' => ['/mark/index']];
            $menuItems[] = ['label' => 'Профіль', 'url' => ['/user/profile', 'id' => Yii::$app->user->id]];
        }

    }

    //    $menuItems = [
    //       // ['label' => 'Головна', 'url' => ['/site/index']],
    //       // ['label' => 'Про нас', 'url' => ['/site/about']],
    //        //['label' => 'Контакти', 'url' => ['/site/contact']],
    //        ['label' => 'Факультети', 'url' => ['/faculty/index']],
    //        ['label' => 'Кафедри', 'url' => ['/department/index']],
    //        ['label' => 'Дисципліни', 'url' => ['/discipline/index']],
    //        ['label' => 'Курси', 'url' => ['/course/index']],
    //        ['label' => 'Групи', 'url' => ['/group/index']],
    //        ['label' => 'Теми', 'url' => ['/topic/index']],
    //        ['label' => 'Завдання', 'url' => ['/workshop/index']],
    //        ['label' => 'Користувачі', 'url' => ['/user/index']],
    //        ['label' => 'Профіль', 'url' => ['/user/view','id'=>Yii::$app->user->id]],
    //    ];

    if (Yii::$app->user->isGuest) {
        // $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
//        $menuItems[] = ['label' => 'Вхід', 'url' => ['/site/login']];
        $menuItems = [
            ['label' => 'Головна', 'url' => ['/site/index']],
            ['label' => 'Про нас', 'url' => ['/site/about']],
            ['label' => 'Контакти', 'url' => ['/site/contact']],
            ['label' => 'Вхід', 'url' => ['/site/login']],
        ];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Вихід (' . Yii::$app->user->identity->email . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
>>>>>>> 340ea476e97c5ef98b790b3e6e62349e3b110bb3

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Ладатко Дарія 601-ТШм <?= date('Y') ?></p>

<<<<<<< HEAD
            <!--      <p class="pull-right">--><?//= Yii::powered() ?><!--</p>-->
        </div>
    </footer>
=======
        <!--      <p class="pull-right">--><? //= Yii::powered() ?><!--</p>-->
    </div>
</footer>
>>>>>>> 340ea476e97c5ef98b790b3e6e62349e3b110bb3

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>