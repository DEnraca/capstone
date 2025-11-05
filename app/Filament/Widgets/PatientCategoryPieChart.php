<?php

namespace App\Filament\Widgets;

use App\Models\Queue;
use Illuminate\Support\Facades\DB;
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
        $queueTypeCounts = Queue::join('queue_type', 'queues.queue_type_id', '=', 'queue_type.id')
            ->select('queue_type.name as name', 'queues.queue_type_id', DB::raw('COUNT(*) as total'))
            ->groupBy('queues.queue_type_id', 'queue_type.name')
            ->get();
        return [
            'chart' => [
                'type' => 'pie',
            ],
            'series' => $queueTypeCounts->pluck('total')->toArray(),
            'labels' => $queueTypeCounts->pluck('name')->toArray(),
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
