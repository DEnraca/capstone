<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReleaseResource\Pages;
use App\Filament\Resources\ReleaseResource\RelationManagers;
use App\Models\Release;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReleaseResource extends Resource
{
    protected static ?string $model = Release::class;


    protected static ?string $navigationIcon = 'fas-arrow-up-from-bracket';

    protected static ?string $navigationGroup = 'Admission';

    protected static ?string $navigationLabel = 'Releasings';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('Patient Name')
                    ->getStateUsing(fn ($record) =>
                        $record?->transaction?->patient?->getFullname() ?? '-'
                    )
                    ->sortable(),

                Tables\Columns\TextColumn::make('transaction.code')
                    ->label('Transaction Number')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('released_by')
                    ->label('Release By')
                    ->getStateUsing(fn ($record) =>
                        $record?->releasedBy?->getFullname() ?? '-'
                    )
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                //
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\Action::make('view_transaction')
                    ->label('View Transaction')
                    ->icon('fas-eye')
                    ->color('success')
                    ->url(fn ($record): string => TransactionResource::getUrl('view', ['record' => $record?->transaction?->id]))
                    ->requiresConfirmation(),

            ])
            ->bulkActions([

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
            'index' => Pages\ListReleases::route('/'),
            'create' => Pages\CreateRelease::route('/create'),
            'edit' => Pages\EditRelease::route('/{record}/edit'),
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
