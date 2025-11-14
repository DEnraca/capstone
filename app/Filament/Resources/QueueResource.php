<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QueueResource\Pages;
use App\Filament\Resources\QueueResource\RelationManagers;
use App\Models\Employee;
use App\Models\PatientInformation;
use App\Models\Queue;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QueueResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static ?string $navigationIcon = 'fas-person-walking';
    protected static ?string $navigationGroup = 'Admission';


    public static function form(Form $form): Form
    {
        return $form->schema(static::getQueueFormSchema())->columns(1);
    }

    public static function getQueueFormSchema(): array
    {
        return [
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
                            ->relationship(
                                name: 'appointment',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn (Builder $query) => $query->whereDate('appointment_date',now())->whereDoesntHave('queue'),
                            )
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                if (! $record) return null;

                                $patientName = $record->patient ?  $record->patient->first_name. ' '. $record->patient->last_name:  'Unknown';
                                $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $record->appointment_date.' '. $record->appointment_time ?? null)
                                    ->format('F d Y g:i A');

                                $date = $date ?? 'No Date';
                                $services = $record->services->pluck('name')->join(', ');

                                // Build a label like: "John Doe - June 24, 2007 (Services: Service 1, Service 2)"
                                return "{$patientName} - {$date} • Services: {$services}";
                            }),
                    ]),

                Forms\Components\TextInput::make('queue_start')
                    ->disabled()
                    ->hiddenOn('create')
                    ->formatStateUsing( fn ($state) => Carbon::parse($state)->isoFormat('MMMM DD YYYY, h:mm A'))
                    ->required(),

                Forms\Components\TextInput::make('queue_end')
                    ->disabled()
                    ->hiddenOn('create')
                    ->formatStateUsing( fn ($state) => (!$state) ? null : Carbon::parse($state)->isoFormat('MMMM DD YYYY, h:mm A')),
                Forms\Components\Select::make('created_by')
                    ->relationship('createdBy', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => $record->getFullname())
                    ->searchable(['first_name' , 'last_name', 'emp_id'])
                    ->preload()
                    ->hiddenOn('create'),
                ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('queue_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('queueType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient.id')
                    ->formatStateUsing(function ($state){
                        if(!$state){
                            return 'N/A';
                        }
                        return PatientInformation::find($state)->getFullname();
                    })
                    ->searchable(query: function ($query, $search) {
                        $query->whereHas('patient', function ($q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")
                              ->orWhere('last_name', 'like', "%{$search}%")
                              ->orWhere('pat_id', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('queue_start')
                    ->dateTime('M d Y h:m A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('queue_end')
                    ->dateTime('M d Y h:m A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->formatStateUsing(function ($state){
                        if(!$state){
                            return 'N/A';
                        }
                        return Employee::find($state)?->getFullname() ?? 'N/A';
                    })
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
                Tables\Actions\DeleteAction::make(),
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

        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
            // dd(auth()->user()->patient->id);
        // If user is a patient → only show his own records
        if (auth()->user()->hasRole('patient')) {
            $query->where('patient_id', auth()->user()->patient->id);
        }
        return $query;

    }
}
