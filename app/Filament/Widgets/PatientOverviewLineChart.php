<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Flowframe\Trend\Trend;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class PatientOverviewLineChart extends ApexChartWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';


    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'patientOverviewLineChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Patient every month for this this year';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $trend = Trend::model(Transaction::class)
            ->between(
                start: now()->startOfYear(),
                end: now(),
            )
            ->perMonth()
            ->count();
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Patient Count',
                    'data' => $trend->pluck('aggregate')->toArray(),
                ],
            ],
            'xaxis' => [
                'categories' => $trend->pluck('date')
                    ->map(fn($date) => \Carbon\Carbon::parse($date)->format('M'))
                    ->toArray(),
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
            'stroke' => [
                'curve' => 'straight',
            ],
        ];
    }
}
