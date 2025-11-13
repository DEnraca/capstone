<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestResultResource\Pages;
use App\Filament\Resources\TestResultResource\RelationManagers;
use App\Models\TestResult;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestResultResource extends Resource
{
    protected static ?string $model = TestResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\Select::make('service_name')->disabled(),

                Section::make('Result Image Attachments')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('result_attachments')
                                ->label('Resullt Image')
                                ->acceptedFileTypes(['image/png','image/jpg','image/jpeg'])
                                ->hint('Accepted file types: png; Max Files: 10')
                                ->hintColor('primary')
                                ->multiple()
                                ->maxFiles(10)
                                ->helperText('1600 x 900 resolution or an aspect ration of 16:9 is recommended for better display')
                                ->collection('result_attachments'),
                    ]),

                Forms\Components\Select::make('result_id')
                    ->relationship('result', 'name')
                    ->required(),


                Forms\Components\Textarea::make('impressions')
                    ->label('Impressions / Remarks / Findings')
                    ->rows(7)
                    ->columnSpanFull(),

                Select::make('signatories')
                    ->multiple()
                    ->preload()
                    ->relationship('signatories', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->getFullname())

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('patient_fullname')
                    ->label('Patient Name')
                    ->getStateUsing(fn ($record) =>
                        $record->test?->transaction?->patient?->getFullname() ?? '-'
                    )
                    ->sortable()
                    ->searchable(),


                Tables\Columns\TextColumn::make('test.transaction.code')
                    ->label('Transaction Number')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('result.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([

                Tables\Actions\Action::make('generate_result')
                    ->label('Get PDF Result')
                    ->icon('fas-file-pdf')
                    ->color('success')
                    ->openUrlInNewTab(true)
                    ->url(fn (TestResult $record) => route('pdf.test-result',['result' => $record->id]))
                    ->requiresConfirmation(),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ServicesTable::route('/{stationID?}'),
            'create' => Pages\CreateTestResult::route('/create/{checklist_details?}'),
            'view' => Pages\ViewTestResult::route('/view/{record}'),
            'edit' => Pages\EditTestResult::route('/{record}/edit'),
            'sort' => Pages\ListTestResults::route('/service/{service_id?}'),
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
