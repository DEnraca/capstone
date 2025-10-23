<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;

class ViewAppointment extends ViewRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('approve')
                ->label('Approve')
                ->hidden(fn ($record) => ($record->status == 1) ? false : true)
                ->requiresConfirmation()
                ->action(function (Appointment $record) {
                    Mail::to($record->patient->user->email)->queue(new AppointmentConfirmation($record->id));
                    if($record->services()->count() == 0 || $record->services()->where('status',2)->count() < 1) {
                        Notification::make()
                            ->title('Error')
                            ->body('No services selected/approved for this appointment.')
                            ->danger()
                            ->send();
                        return;
                    }

                    $record->status = 2;
                    $record->confimed_by = auth()->user()->id;
                    $record->save();

                    //send email reminder here

                    Notification::make()
                        ->title('Success')
                        ->body('Appointment has been approved.')
                        ->success()
                        ->send();
                })
                ->color('success'),

            Actions\EditAction::make(),
        ];
    }
}
