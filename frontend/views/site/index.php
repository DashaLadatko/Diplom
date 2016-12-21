<?php

/* @var $this yii\web\View */
//For Languages
use frontend\widgets\Langwidget;

$this->title = 'Система дистанційного навчання';

\common\models\Queue::startSend();
?>

<div class="image-block">
    <div class="slider">
        <div><h1>Кафедра комп'ютерних та інформаційних технологій і систем</h1></div>
        <div>2</div>
        <div>3</div>
        <div>4</div>
    </div>
</div>

<div class="site-index">
    <!--    <div class="jumbotron">-->


    <!--     For Languages-->
    <!--        --><? //= Langwidget::widget();?>
    <!--        <p class="lead">-->
    <? //= \Yii::t('general', 'You have successfully created your Yii-powered application.'); ?><!--</p>-->

    <!--        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>-->
    <!--    </div>-->

    <div class="body-content">

        <div class="row info-block">
            <div class="col-sm-4">
                <img src="frontend/web/img/logo_kits.gif" alt="image">
            </div>
            <div class="col-sm-8">
                <h2>Концепція кафедри</h2>
                <p> Концептуальна основа створення та діяльності кафедри визначається необхідністю розвитку наукового та
                    освітнього напрямів, що орієнтовані на підготовку висококваліфікованих фахівців з інформаційних
                    технологій, систем штучного інтелекту, аналітики комп’ютерних систем, математичного програмного
                    забезпечення обчислювальних машин і систем.
                    <p>Кафедра комп'ютерних технологій та інформаційних систем заснована на підставі рішення вченої ради
                    Полтавського національного технічного університету імені Юрія Кондратюка в якості випускної кафедри у складі створеного факультету
                    інформаційних та телекомунікаційних технологій і систем.</p>
                </p>

                <p><a class="btn btn-default" href="http://fitts.pntu.edu.ua/ua/koncepciya">Детальніше &raquo;</a></p>

            </div>
        </div>

        <div class="row info-block">
            <div class="col-sm-4">
                <img src="frontend/web/img/Data-Analysis.jpg" alt="image">
            </div>
            <div class="col-sm-8">
                <h2>Спеціальності</h2>
                <p>Кафедра приділяє особливу увагу подальшому кар’єрному росту своїх випускників. Зокрема навчальними
                    планами передбачено поглиблене вивчення професійної англійської мови. А для студентів, що не вивчали
                    в школі англійської мови створені додаткові можливості та комфортні умови для вивчення цієї
                    мови.
                </p>

                <p><a class="btn btn-default" href="http://fitts.pntu.edu.ua/ua/specializations">Детальніше &raquo;</a>
            </div>
        </div>

        <div class="row info-block">
            <div class="col-sm-4">
                <img src="frontend/web/img/sturtup.png" alt="image">
            </div>
            <div class="col-sm-8">
                <h2>Історія кафедри</h2>
                <p> Історія кафедри починається із створення у 1935 році об’єднаної кафедри будівельної механіки, яку
                    очолював професор Кубинський К.М. На кафедрі в той час викладались фундаментальні і
                    проектно-орієнтовані дисципліни, такі як будівельна механіка, опір матеріалів, теоретична механіка,
                    будівельні конструкції та інші дисципліни.</p>

                <p><a class="btn btn-default" href="http://fitts.pntu.edu.ua/ua/history">Детальніше &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
