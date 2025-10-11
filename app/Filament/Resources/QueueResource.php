<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QueueResource\Pages;
use App\Filament\Resources\QueueResource\RelationManagers;
use App\Models\Queue;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QueueResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static ?string $navigationIcon = 'fas-person-walking';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('queue_number')
                    ->required()
                    ->disabled()
                    ->visibleOn('view'),

                Forms\Components\Select::make('queue_type_id')
                    ->columnSpanFull()
                    ->live()
                    ->relationship('queueType', 'name'),

                Fieldset::make('Priority Lane')
                    ->columnSpanFull()
                    ->visible( fn (Get $get) => $get('queue_type_id') == 3)
                    ->schema([
                        Forms\Components\Select::make('priority_type_id')
                            ->columnSpanFull()
                            ->relationship('priorityType', 'name'),
                    ]),
                Fieldset::make('Appointment Lane')

                    ->visible( fn (Get $get) => $get('queue_type_id') == 1)
                    ->schema([
                        Forms\Components\Select::make('appointment_id')
                            ->columnSpanFull()
                            ->preload()
                            ->native(false)
                            ->relationship('appointment', 'id')
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                if (! $record) return null;

                                $patientName = $record->patient ?  $record->patient->first_name. ' '. $record->patient->last_name:  'Unknown';
                                // dd($record->appointment_date.' '. $record->appointment_time);
                                $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $record->appointment_date.' '. $record->appointment_time ?? null)
                                    ->format('F d Y g:i A');

                                $date = $date ?? 'No Date';
                                $services = $record->services->pluck('name')->join(', ');

                                // Build a label like: "John Doe - June 24, 2007 (Services: Service 1, Service 2)"
                                return "{$patientName} - {$date} • Services: {$services}";
                            }),

                    ]),


                Forms\Components\Select::make('status_id')
                    ->hiddenOn('create')
                    ->relationship('status', 'name'),
                Forms\Components\DateTimePicker::make('queue_start')
                    ->disabledOn('edit')
                    ->visibleOn('view')
                    ->required(),
                Forms\Components\DateTimePicker::make('queue_end')
                    ->disabledOn('edit')
                    ->visibleOn('view'),
                Forms\Components\TextInput::make('created_by')
                    ->hiddenOn('create')
                    ->numeric(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('queue_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('priorityType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('queueType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('appointment.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('queue_start')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('queue_end')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQueues::route('/'),
            'create' => Pages\CreateQueue::route('/create'),
            'view' => Pages\ViewQueue::route('/{record}'),
            'edit' => Pages\EditQueue::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
