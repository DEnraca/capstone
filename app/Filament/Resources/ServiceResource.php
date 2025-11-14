<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'fas-notes-medical';
    protected static ?string $navigationGroup = 'Maintenance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Forms\Components\Select::make('station_id')
                        ->relationship('station', 'name')
                        ->required(),
                    Forms\Components\Select::make('department_id')
                        ->relationship('department', 'name')
                        ->required(),
                ]),

                Grid::make(3)->schema(
                    [
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(10),
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->columnSpan(2)
                            ->maxLength(10),
                    ]
                ),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->minValue(1)
                    ->placeholder(0)
                    ->prefix('₱'),

                Forms\Components\Textarea::make('description')
                    ->maxLength(150)
                    ->rows(5)
                    ->columnSpanFull(),

                Section::make('Service Cover')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('service_cover')
                                ->label('Service Cover Image')
                                ->acceptedFileTypes(['image/png','image/jpg','image/jpeg'])
                                ->hint('Accepted file types: png; ')
                                ->hintColor('primary')
                                ->maxFiles(10)
                                ->helperText('1600 x 900 resolution or an aspect ration of 16:9 is recommended for better display')
                                ->collection('service_cover'),
                    ]),

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('station.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('php')
                    ->sortable(),
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
                //
            ])
            /// UPDATE `sample_services` SET `station`=1 WHERE `station`='CHEMISTRY'
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
