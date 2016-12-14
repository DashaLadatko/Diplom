<?php

/* @var $this yii\web\View */
//For Languages
use frontend\widgets\Langwidget;

$this->title = 'Система дистанційного навчання';

\common\models\Queue::startSend();
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Кафедра комп'ютерних та інформаційних технологій і систем</h1>
        
<!--     For Languages-->
<!--        --><?//= Langwidget::widget();?>
<!--        <p class="lead">--><?//= \Yii::t('general', 'You have successfully created your Yii-powered application.'); ?><!--</p>-->

<!--        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>-->
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Концепція кафедри</h2>

                <p>  Концептуальна основа створення та діяльності кафедри визначається необхідністю розвитку наукового та освітнього напрямів, що орієнтовані на підготовку висококваліфікованих фахівців з інформаційних технологій, систем штучного інтелекту, аналітики комп’ютерних систем, математичного програмного забезпечення обчислювальних машин і систем.</p>

                <p><a class="btn btn-default" href="http://fitts.pntu.edu.ua/ua/koncepciya">Детальніше &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Спеціальності</h2>

                <p>Кафедра приділяє особливу увагу подальшому кар’єрному росту своїх випускників. Зокрема навчальними планами передбачено поглиблене вивчення професійної англійської мови. А для студентів, що не вивчали в школі англійської мови створені додаткові можливості та комфортні умови для вивчення цієї мови.</p>

                <p><a class="btn btn-default" href="http://fitts.pntu.edu.ua/ua/specializations">Детальніше &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Історія кафедри</h2>

                <p> Історія кафедри починається із створення у 1935 році об’єднаної кафедри будівельної механіки, яку очолював професор Кубинський К.М. На кафедрі в той час викладались фундаментальні і проектно-орієнтовані дисципліни, такі як будівельна механіка, опір матеріалів, теоретична механіка, будівельні конструкції та інші дисципліни.</p>

                <p><a class="btn btn-default" href="http://fitts.pntu.edu.ua/ua/history">Детальніше &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
