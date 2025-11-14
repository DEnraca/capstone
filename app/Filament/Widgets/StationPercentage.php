<?php

namespace App\Filament\Widgets;

use App\Models\Station;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class StationPercentage extends ApexChartWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 6;

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
        $stations = Station::active()
                ->withCount([
                    'patientTests as patient_tests_count'
                ])
                ->having('patient_tests_count', '>=', 1)
                ->get();

        return [
            'chart' => [
                'type' => 'pie',
                'height' => 250,
            ],
            'series' => $stations->pluck('patient_tests_count')->toArray(),
            'labels' => $stations->pluck('name')->toArray(),
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
