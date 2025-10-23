<?php

namespace App\Filament\Resources;

use App\Actions\Form\AppointmentFields\DateTimeMessage;
use App\Actions\Form\PatientInformation\Address;
use App\Actions\Form\PatientInformation\PersonalInfo;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Employee;
use App\Models\PatientInformation;
use App\Models\Service;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'fas-file';

    public static function form(Form $form): Form
    {
        $patientInfoField = PersonalInfo::run();
        $patientAddressField = Address::run();

        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Transaction Details')
                            ->schema([
                                TextInput::make('code')
                                    ->label('Transaction Code')
                                    ->disabled(),
                                Textarea::make('remarks')
                                    ->label('Notes'),

                                Repeater::make('tests')
                                    ->label('Transaction Services')
                                    ->visibleOn('create')
                                    ->minItems(1)
                                    ->schema([
                                        Select::make('service_id')
                                            ->label('Service')

                                            // ->relationship('service', 'id')
                                            ->preload()
                                            ->options(function (){
                                                $options = [];
                                                $services = Service::orderBy('name')->get();
                                                foreach ($services as $service) {
                                                    $options[$service->id] = $service->code. ' - '.'('.$service->station->name.')'. $service->name. ' - ₱'. number_format($service->price, 2);
                                                }
                                                return $options;
                                            })
                                            ->searchable(['name','code','price'])
                                            ->required(),

                                        Select::make('status_id')
                                            ->hiddenOn('create')
                                            // ->relationship('status', 'name'),
                                        // ...
                                    ])

                                ])->columns(1),
                        Tabs\Tab::make('Queue Information')
                            ->disabled()
                            ->schema([Group::make()->relationship('queue')->schema(QueueResource::getQueueFormSchema())]),

                        Tabs\Tab::make('Patient Information')
                            ->disabled()
                            ->schema([Group::make()->relationship('patient')->schema(array_merge(
                                $patientInfoField,
                                [
                                    Fieldset::make('Address')
                                        ->relationship('address')
                                        ->schema($patientAddressField)
                                        ->columnSpanFull()
                                        ->columns(2),
                                ]
                            ))->columns(3)->columnSpan(2)]),

                        Tabs\Tab::make('Billing Information')
                        ->disabled()
                        ->schema([Group::make()->relationship('billing')->disabled()->schema(InvoiceResource::getInvoiceFormSchema())]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient_id')
                    ->label('Name')
                    ->formatStateUsing(function ($state){
                        if(!$state){
                            return 'N/A';
                        }
                        return PatientInformation::find($state)->getFullname();
                    })
                    ->searchable(['first_name', 'last_name', 'pat_id'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_by')
                    ->formatStateUsing(function ($state){
                        if(!$state){
                            return 'N/A';
                        }
                        return Employee::find($state)?->getFullname() ?? 'N/A';
                    })
                    ->searchable(['first_name', 'last_name', 'emp_id'])
                    ->sortable(),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('deleted_at')
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
            RelationManagers\TestsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create/{checklist_details?}'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
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
