<?php

use yii\helpers\Html;
use common\models\User;

$this->title = 'Файли НМКД';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

</div>
<div class="filenmkd-index">

    <div>
        <?php if ($model){ foreach ($model as $row){ ?>
            <p> На адресу <?= User::findOne($row['user_id'])->email?> було направлено листа такого змісту: </p>
            <p> ' Шановний <?= User::findOne($row['user_id'])->getFullName()?>
                Файл<?= $row['name'] ?> не було оновлено на протязі року. Зверніть увагу. Адміністратор.' </p>
        <?php }}?>
    </div>

    <div>
        <?php if ($send){ foreach ($send as $row){ ?>
            <p> На адресу <?= User::findOne($row['user_id'])->email?> було направлено листа такого змісту: </p>
            <p> ' Шановний <?= User::findOne($row['user_id'])->getFullName()?>
                Ви не завантажили файл НМКД. Минуло 10 днів. Зверніть увагу. Адміністратор.' </p>
        <?php }}?>
    </div>