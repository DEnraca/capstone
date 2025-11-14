<?php

namespace App\Filament\Widgets;

use App\Models\Service;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class ServiceAvailBarChart extends ApexChartWidget
{
    use HasWidgetShield;


    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 6;

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

    public function getHeading(): null|string|Htmlable|View
    {
        return 'Service Avail Count: ' . now()->format('F');
    }

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */

    protected function getOptions(): array
    {

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $services = Service::query()
            ->withCount([
                'patientTests as patient_tests_count' => function ($query) use ($startOfMonth, $endOfMonth) {
                    $query->whereHas('transaction', function ($q) use ($startOfMonth, $endOfMonth) {
                            $q->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                        });
                },
            ])
            ->having('patient_tests_count', '>', 0)
            ->orderByDesc('patient_tests_count')
            ->get();

        $categories = $services->pluck('code');
        $data = $services->pluck('patient_tests_count');

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Service Name',
                    'data' => $data,
                ],
            ],
            'toolbar' => [
                'show' => true,
                'tools' => [
                    'download' => false,
                    'selection' => false,
                    'zoom' => false,
                    'zoomin' => false,
                    'zoomout' => false,
                    'pan' => false,
                    'reset' => false,
                ]
            ],
            'xaxis' => [
                'categories' => $categories,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'tickAmount' => 1,
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
