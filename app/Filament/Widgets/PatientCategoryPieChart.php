<?php

namespace App\Filament\Widgets;

use App\Models\QueueType;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class PatientCategoryPieChart extends ApexChartWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 6;

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
        $queue_types = QueueType::all();
        $data = [];
        foreach($queue_types as $type){
            $data[] =[
                'name' => $type->name,
                'count' => $type->queues->count()
            ];
        }
        return [
            'chart' => [
                'type' => 'pie',
                'height' => 250,

            ],
            'series' => count(collect($data)?->pluck('count'))>0 ? collect($data)?->pluck('count') : 1,
            'labels' =>  count(collect($data)?->pluck('name'))>0 ? collect($data)?->pluck('name') : 'No Data',
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
