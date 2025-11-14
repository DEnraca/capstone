<?php

namespace App\Filament\Widgets;

use App\Models\PatientInformation;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class PatientOverviewLineChart extends ApexChartWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 6;

    use HasWidgetShield;

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
    // protected static ?string $heading = 'Patient every month for this year';

    public function getHeading(): null|string|Htmlable|View
    {
        return 'Patient every month for year: ' . now()->format('Y');
    }
    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {

        $data = Trend::model(PatientInformation::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
                'toolbar' => [
                    'show' => true,
                    'tools' => [
                        'download' => false,
                        'selection' => false,
                        'zoom' => false,
                        'zoomin' => true,
                        'zoomout' => true,
                        'pan' => false,
                        'reset' => false,
                    ]
                ],
            ],
            'series' => [
                [
                    'name' => 'Patient Count',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'xaxis' => [
                'categories' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M')),
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
