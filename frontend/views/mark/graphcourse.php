<?php

use miloschuman\highcharts\Highcharts;
$this->title = 'Успішність';
$this->params['breadcrumbs'][] = $this->title;

echo Highcharts::widget([
    'options' => ['chart' => [
        'type' => 'bar' ],
        'title' => ['text' => 'Успішність'],
        'xAxis' => [
            'categories' => ['']
        ],
        'yAxis' => [
            'title' => ['text' => 'Середня оцінка по курсу']
        ],
        'series' =>
            $evaluation
    ]
]);