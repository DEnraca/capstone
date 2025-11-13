<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Get;
use Spatie\Permission\Models\Role;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'fas-user-doctor';

    protected static ?string $navigationGroup = 'Maintenance';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                ->schema([
                    Fieldset::make('Employee Information')
                        ->columns(2)
                        ->columnSpan(2)
                        ->schema([
                            Forms\Components\TextInput::make('emp_id')
                                ->required()
                                ->label('Employee ID')
                                ->hiddenOn('create')
                                ->disabled()
                                ->columnSpanFull()
                                ->maxLength(50),

                            Forms\Components\TextInput::make('last_name')
                                ->required()
                                ->columnSpanFull()
                                ->helperText('Kindly include suffix after last name, e.g. II, III')
                                ->label('Last Name')
                                ->required()
                                ->maxLength(25),
                            Forms\Components\TextInput::make('first_name')
                                ->columnSpanFull()
                                ->prefixIconColor('primary')
                                ->label('First Name')
                                ->maxLength(20)
                                ->required(),
                            Forms\Components\TextInput::make('middle_name')
                                ->columnSpanFull()
                                ->label('Middle Name')
                                ->maxLength(20),

                            Forms\Components\Select::make('gender_id')
                                ->relationship('gender', 'name')
                                ->columnSpan(1)
                                ->required(),
                            Forms\Components\DatePicker::make('birthdate')
                                ->label('Birth Date')
                                ->maxDate(now())
                                ->columnSpan(1)
                                ->required()
                                ->default(now()->subYears(10)),

                            Forms\Components\Select::make('department_id')
                                ->searchable()
                                ->preload()
                                ->columnSpanFull()
                                ->columnSpan(1)

                                ->relationship('department', 'name', modifyQueryUsing: fn (Builder $query) => $query->orderBy('name','asc')),
                            Forms\Components\Select::make('position_id')
                                ->searchable()
                                ->preload()
                                ->columnSpan(1)
                                ->relationship('position', 'name', modifyQueryUsing: fn (Builder $query) => $query->orderBy('name','asc')),

                            Forms\Components\Select::make('employment_type')
                                ->searchable(true)
                                ->preload()
                                ->columnSpan(1)
                                ->relationship('employmentType', 'name', modifyQueryUsing: fn (Builder $query) => $query->orderBy('name','asc')),

                            Forms\Components\DatePicker::make('date_hired')
                                    ->label('Date Hired')
                                    ->maxDate(now()->addDay())
                                    ->columnSpan(1)
                                    ->required()
                                    ->default(now()),

                            Forms\Components\TextInput::make('mobile')
                                ->minLength(10)
                                ->maxLength(10)
                                ->prefix('+63')
                                ->columnSpanFull()
                                ->label('Phone / Mobile')
                                ->helperText('Mobile number must start with +63')
                                ->maxLength(12),

                            Radio::make('is_active')
                                ->label('Employment Status')
                                ->hiddenOn('create')
                                ->columnSpanFull()
                                ->default(true)
                                ->options([
                                    true => 'Active',
                                    false => 'Not Active',
                                ])
                                ->descriptions([
                                    true => 'This employee is active.',
                                    false => "This employee isn't active",
                                ]),

                            Forms\Components\Textarea::make('notes')
                                ->columnSpanFull()
                                ->rows(3),

                        ]),

                    Fieldset::make('Employee Account')
                        ->columnSpan(1)
                        ->extraAttributes(['style' => 'padding-inline: 0.5 !important; padding-block: 0.3 !important;'])
                        ->schema([
                            Section::make()
                                ->hiddenLabel()
                                ->columnSpanFull()
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
                                    Forms\Components\Section::make('Role')
                                    ->schema([
                                        Select::make('roles')->label('Role')
                                            ->hiddenLabel()
                                            ->options( function (){
                                                // return $query->where('name', '!=', config('filament-shield.super_admin.name'));

                                                $options = Role::query()
                                                    ->where('guard_name', 'web')
                                                    ->orderBy('name', 'asc')
                                                    ->pluck('name', 'id');

                                                if (!auth()->user()->hasRole('superadmin')) {
                                                    $options->where('name', '!=', 'superadmin');
                                                }

                                                foreach ($options as $key => $value) {
                                                    $options[$key] = Str::headline($value);
                                                }
                                                return $options;
                                            })
                                            ->minItems(1)
                                            ->multiple()
                                            ->preload()
                                            ->native(false),
                                    ])
                                    ->compact(),


                                Forms\Components\Section::make()
                                    ->description('Select services that this employee can perform')
                                    ->columnSpanFull()
                                    ->schema([
                                        Select::make('services')
                                            ->relationship('services', 'name', modifyQueryUsing: function (Builder $query) {
                                                return $query->orderBy('name', 'asc');
                                            })
                                            ->multiple()
                                            ->preload()
                                            ->searchable()
                                            ->native(false)
                                            ->label('Services')
                                            ->columnSpanFull(),
                                    ]),
                            ]),


                        ]),
                    Section::make('Signature')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('e_signatures')
                                ->label('E-Signature Image')
                                ->acceptedFileTypes(['image/png','image/jpg','image/jpeg'])
                                ->hint('Accepted file types: png;')
                                ->hintColor('primary')
                                ->helperText('1600 x 900 resolution or an aspect ration of 16:9 is recommended for better display')
                                ->collection('e_signatures'),
                    ]),

                // Forms\Components\Select::make('user_id')
                //     ->hiddenOn('create')
                //     ->relationship('user', 'id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('emp_id')
                    ->label('Employee ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birthdate')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->prefix('+63')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employmentType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_hired')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
