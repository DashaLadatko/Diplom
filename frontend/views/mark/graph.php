<?php

use miloschuman\highcharts\Highcharts;

echo Highcharts::widget([
    'options' => [
        'title' => ['text' => 'Успішність'],
        'xAxis' => [
            'categories' => []//['Тема 1', 'Тема 2', 'Тема 3', 'Тема 4', 'Тема 5']
        ],
        'yAxis' => [
            'title' => ['text' => 'Оцінка']
        ],
        'series' =>
            $evaluation
    ]
]);
