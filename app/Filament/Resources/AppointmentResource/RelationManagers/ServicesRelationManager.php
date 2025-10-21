<?php

namespace App\Filament\Resources\AppointmentResource\RelationManagers;

use App\Models\Service;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mockery\Matcher\Not;

class ServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'services';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'name')
                    ->searchable(true)
                    ->preload()
                    ->options(fn (Service $service) => $service->orderBy('name', 'asc')->pluck('name', 'id'))
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        1 => 'Pending',
                        2 => 'Confirmed',
                        3 => 'Cancelled',
                        4 => 'Completed',
                    ])
                    ->required(),
            ]);
    }


    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return auth()->user()->can('view_appointment');
    }

    public function isReadOnly(): bool
    {
        return  $this->getOwnerRecord()->status != 1;
    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),

                Tables\Columns\TextColumn::make('status')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => getAppointmentStatus($state))
                    ->color(fn (int $state): string => match ($state) {
                        1 => 'warning',
                        2 => 'success',
                        3 => 'danger',
                        4 => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('approved_by')
                    ->formatStateUsing(function ($state){
                        if($state){
                            $user = User::find($state);
                            $employee = $user?->employee;
                            return ($employee) ? $employee->first_name . ' ' . $employee->last_name : $user->firstname . ' ' . $user->lastname;
                        }
                        return null;
                    }),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('approve_all')
                    ->label('Approve All')
                    ->hidden(fn () => ($this->getOwnerRecord()->status  == 2 || $this->getOwnerRecord()->status  == 4) ? true : false)
                    ->requiresConfirmation()
                    ->action(function () {
                        $this->getOwnerRecord()->services()->update(['status' => 2, 'approved_by' => auth()->user()->id]);
                        $this->getOwnerRecord()->save();

                        Notification::make()
                            ->title('Success')
                            ->body('All services have been approved.')
                            ->success()
                            ->send();
                    })
                    ->color('success'),
                Tables\Actions\CreateAction::make()

            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->hidden(fn ($record) => ($record->status == 2 || $record->status == 4) ? true : false)
                    ->visible(fn () => $this->getOwnerRecord()->status == 1)
                    ->requiresConfirmation()
                    ->icon('fas-check')
                    ->action(function ($record) {
                        $record->pivot->status = 2;
                        $record->pivot->approved_by = auth()->user()->id;
                        $record->pivot->save();

                        Notification::make()
                            ->title('Success')
                            ->body('Service has been approved.')
                            ->success()
                            ->send();
                    })
                    ->color('success'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('approve_bulk')
                        ->label('Approve Selected')
                        ->icon('fas-check')
                        ->hidden(fn () => ($this->getOwnerRecord()->status  == 2 || $this->getOwnerRecord()->status  == 4) ? true : false)
                        ->action(function ( $records) {
                            foreach ($records as $record) {

                                $fresh = $this->getOwnerRecord()
                                        ->services()
                                        ->where('services.id', $record->id)
                                        ->first();
                                if ($fresh && $fresh->pivot) {
                                    $fresh->pivot->update([
                                        'status'      => 2,
                                        'approved_by' => auth()->id(),
                                    ]);
                                }

                            }

                            Notification::make()
                                ->title('Success')
                                ->body('Selected services have been approved.')
                                ->success()
                                ->send();
                        })
                        ->color('success'),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
