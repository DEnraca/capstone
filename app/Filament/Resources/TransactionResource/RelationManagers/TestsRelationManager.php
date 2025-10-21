<?php

namespace App\Filament\Resources\TransactionResource\RelationManagers;

use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestsRelationManager extends RelationManager
{
    protected static string $relationship = 'tests';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('service_id')
                    ->label('Service')
                    ->relationship('service', 'id')
                    ->preload()
                    ->options(function (){
                        $options = [];
                        $services = Service::orderBy('name')->get();
                        foreach ($services as $service) {
                            $options[$service->id] = $service->code. ' - '.'('.$service->station->name.')'. $service->name. ' - ₱'. number_format($service->price, 2);
                        }
                        return $options;
                    })
                    ->columnSpanFull()
                    ->searchable(['name','code','price'])
                    ->required(),

                Select::make('status_id')
                    ->visibleOn('edit')
                    ->relationship('status', 'name'),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return auth()->user()->can('view_transaction');
    }


    public function table(Table $table): Table
    {
        return $table
            ->heading('Services Availed')
            ->defaultSort(null)
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('service.code')->searchable()->label('Code'),
                Tables\Columns\TextColumn::make('service.station.name')->searchable()->label('Station'),
                Tables\Columns\TextColumn::make('service.name')->searchable()->label('Name'),
                Tables\Columns\TextColumn::make('service.description')->searchable()->limit(50),
                Tables\Columns\TextColumn::make('status.name')->searchable()->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
