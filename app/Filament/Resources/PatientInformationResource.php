<?php

namespace App\Filament\Resources;

use App\Actions\Form\PatientInformation\Address;
use App\Actions\Form\PatientInformation\PersonalInfo;
use App\Filament\Resources\PatientInformationResource\Pages;
use App\Filament\Resources\PatientInformationResource\RelationManagers;
use App\Models\PatientInformation;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class PatientInformationResource extends Resource
{
    protected static ?string $model = PatientInformation::class;

    protected static ?string $navigationIcon = 'fas-person-dots-from-line';

    public static function form(Form $form): Form
    {
        $patientInfoField = PersonalInfo::run();
        $patientAddressField = Address::run();

        return $form
            ->schema([
                Section::make('Personal Information')
                    ->columnspan(2)
                    ->schema([
                        Fieldset::make(' ')
                            ->columns(3)
                            ->schema($patientInfoField),

                        Fieldset::make(' ')
                            ->relationship('address')
                            ->columns(2)
                            ->schema($patientAddressField),

                    ]),
                    Section::make()
                        ->hiddenLabel()
                        ->columnspan(1)
                        ->relationship('user')
                        ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Get $get): array {
                            $data['username'] = generateUniqueUsername(
                                $get('first_name'),
                                $get('middle_name'),
                                $get('last_name')
                            );
                            $data['firstname'] = $get('first_name');
                            $data['lastname'] = $get('last_name');
                            $data['email_verified_at'] = now();
                            $data['created_at'] = now();
                            return $data;
                        })
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('media')
                                ->label('Avatar')
                                ->avatar()
                                ->collection('avatars')
                                ->alignCenter()
                                ->columnSpanFull(),

                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('email')
                                        ->unique(ignoreRecord: true)
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('password')
                                        ->password()
                                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                        ->dehydrated(fn (?string $state): bool => filled($state))
                                        ->revealable()
                                        ->required(),
                                    Forms\Components\TextInput::make('passwordConfirmation')
                                        ->password()
                                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                        ->dehydrated(fn (?string $state): bool => filled($state))
                                        ->revealable()
                                        ->same('password')
                                        ->required(),
                                ])
                                ->compact(),
                    ]),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pat_id')
                    ->label('Patient ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('id')
                    ->label('Name')
                    ->formatStateUsing(function ($state){
                        if(!$state){
                            return 'N/A';
                        }
                        return PatientInformation::find($state)->getFullname();
                    })
                    ->searchable(['first_name', 'last_name', 'pat_id'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dob')
                    ->label('Birthday')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient_gender.name')
                    ->label('Gender')
                    ->sortable(),
                Tables\Columns\TextColumn::make('civilStatus.name')
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
            'index' => Pages\ListPatientInformation::route('/'),
            'create' => Pages\CreatePatientInformation::route('/create'),
            'view' => Pages\ViewPatientInformation::route('/{record}'),
            'edit' => Pages\EditPatientInformation::route('/{record}/edit'),
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
