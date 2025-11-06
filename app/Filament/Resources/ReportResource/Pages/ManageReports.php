<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;

class ManageReports extends ManageRecords
{
    protected static string $resource = ReportResource::class;



    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data, string $model): Model {
                    if($data['range'] != 6){
                        $dates = $this->getRange($data['range']);
                        $data['from'] = $dates['from'];
                        $data['to'] = $dates['to'];
                    }

                    $data['generated_by'] = auth()->user()?->employee?->id ?? null;

                    return $model::create($data);
                })
                ->after(function (Model $record, Action $action) {
                    return $action->redirect(route('generate.report',['id' => $record->id]));
                })
        ];
    }


    public function getRange($range){

        switch ($range) {
            case 1:
                $dates['from'] = now()->startOfDay();
                $dates['to'] = now()->endOfDay();
                break;
            case 2:
                $dates['from'] = now()->startOfWeek()->startOfDay();
                $dates['to'] = now()->endOfDay();
                break;
            case 3:
                $dates['from'] = now()->subDay(7)->startOfDay();
                $dates['to'] = now()->endOfDay();
                break;

            case 4:
                $dates['from'] = now()->subDay(15)->startOfDay();
                $dates['to'] = now()->endOfDay();
                break;

            case 5:
                $dates['from'] = now()->subDay(30)->startOfDay();
                $dates['to'] = now()->endOfDay();
                break;

            default:
                $dates['from'] = now()->startOfDay();
                $dates['to'] = now()->endOfDay();
        }

        return $dates;
    }
}
