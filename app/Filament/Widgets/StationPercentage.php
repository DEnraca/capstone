<?php

namespace App\Filament\Widgets;

use App\Models\PatientTest;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class StationPercentage extends ApexChartWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 4;

    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'stationPercentage';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Station Distribution';

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
                'height' => 300,
            ],
            'series' => [3, 14, 6, 5],
            'labels' => ['Heart', 'Laboratory', 'Radiograph', 'Drug'],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
