<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class PatientCategoryPieChart extends ApexChartWidget
{
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 4;

    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'patientCategoryPieChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Patient Category';

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
                'type' => 'pie',
            ],
            'series' => [2, 8, 3],
            'labels' => ['PWD/SC/Pregnant', 'Appointment', 'Walk-in'],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
