<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeTypeResource\Pages;
use App\Filament\Resources\EmployeeTypeResource\RelationManagers;
use App\Models\EmployeeType;
use App\Models\EmployementType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeTypeResource extends Resource
{
    protected static ?string $model = EmployementType::class;

    protected static ?string $navigationIcon = 'fas-users-line';
    protected static ?string $navigationGroup = 'Maintenance';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Employment Type')
                    ->required()
                    ->maxLength(50)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Employment Type Name')
                    ->searchable()
                    ->sortable()
            ])
            ->filters([
                TrashedFilter::make(),
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('name')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEmployeeTypes::route('/'),
        ];
    }
}
