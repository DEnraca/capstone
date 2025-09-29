<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ServiceAvailBarChart extends ApexChartWidget
{

    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 4;

    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'serviceAvailBarChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Service Avail Count: September';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Service Name',
                    'data' => [4, 2, 10, 8],
                ],
            ],
            'xaxis' => [
                'categories' => ['CHEM-001', 'MICRO-001', 'HEMA-005', 'HEMA-003'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => false,
                ],
            ],
        ];
    }
}
