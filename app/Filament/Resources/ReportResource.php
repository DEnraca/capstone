<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Employee;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'fas-file-zipper';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Report';


    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([

                Forms\Components\Select::make('report_kind_id')
                    ->relationship('reportKind','name')
                    ->required(),

                Forms\Components\Select::make('range')
                    ->label('Range')
                    ->live()
                    ->options([
                        1 => 'Today',
                        2 => 'This Week',
                        3 => 'Last 7 Days',
                        4 => 'Last 15 Days',
                        5 => 'Last 30 Days',
                        6 => 'Custom',
                    ])
                    ->required(),

                Grid::make(2)
                    ->visible( fn(Get $get) :bool => ($get('range') == 6) ? true : false)
                    ->schema([
                        Forms\Components\DatePicker::make('from')
                            ->live()
                            ->required(),
                        Forms\Components\DatePicker::make('to')
                            ->minDate(fn (Get $get) => $get('from'))
                            ->required(),
                    ]),
                Forms\Components\Select::make('type')
                    ->options([
                        1 => 'Excel',
                        2 => 'PDF'
                    ])
                    ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('from')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('to')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ($state == 2)? 'PDF' : 'Excel')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reportKind.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('generatedBy.id')
                    ->formatStateUsing(fn ($state) => Employee::find($state)?->getFullname() ?? null )
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
            ->actions([

                Action::make('download')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Report $record): string => route('generate.report', ['id' => $record->id])),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReports::route('/'),
        ];
    }
}
