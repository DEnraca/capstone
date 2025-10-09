<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QueueResource\Pages;
use App\Filament\Resources\QueueResource\RelationManagers;
use App\Models\Queue;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
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
                    ->visibleOn('view'),

                Forms\Components\Select::make('queue_type_id')
                    ->columnSpanFull()
                    ->relationship('queueType', 'name'),
                Fieldset::make('Priority Lane')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Select::make('priority_type_id')
                            ->columnSpanFull()
                            ->relationship('priorityType', 'name'),
                    ]),
                Fieldset::make('Appointment Lane')
                    ->schema([
                        Forms\Components\Select::make('appointment_id')
                            ->columnSpanFull()
                            ->relationship('appointment', 'id'),
                    ]),


                Forms\Components\Select::make('status_id')
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
