<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'fas-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Fieldset::make('')
                    ->hiddenLabel()
                    ->schema([
                        DatePicker::make('appointment_date')
                            ->required()
                            ->native(false)
                            ->default(now()->format('Y-m-d'))
                            ->formatStateUsing(fn ($state) => $state ? date('F j, Y', strtotime($state)) : '')
                            ->prefixIcon('heroicon-o-calendar-days')
                            ->prefixIconColor('primary')
                            ->closeOnDateSelection()
                            ->label('Date'),

                        Select::make('appointment_time')
                            ->label('Time')
                            ->default('8:30')
                            ->formatStateUsing(fn ($state) => $state ? date('h:i A', strtotime($state)) : '')
                            ->placeholder('Select Time')
                            ->prefixIcon('heroicon-o-clock')
                            ->prefixIconColor('primary')
                            ->required()
                            ->disableOptionWhen(fn (string $value): bool => ($value) === '08:30')
                            ->options(fn () => get_appointment_timeslots())
                            ->searchable(),


                    Fieldset::make('Full Name')
                        ->columns(3)
                        ->schema([
                            TextInput::make('last_name')
                                ->prefixIcon('heroicon-o-user')
                                ->prefixIconColor('primary')
                                ->helperText('Kindly include suffix after last name, e.g. II, III')
                                ->label('Last Name')
                                ->required(),
                            TextInput::make('first_name')
                                ->prefixIcon('heroicon-o-user')
                                ->default('Dennis')
                                ->prefixIconColor('primary')
                                ->label('First Name')
                                ->required(),
                            TextInput::make('middle_name')
                                ->prefixIcon('heroicon-o-user')
                                ->prefixIconColor('primary')
                                ->default('Abellera')
                                ->label('Middle Name'),
                        ]),

                        TextInput::make('email')
                            ->email() // or
                            ->prefixIcon('heroicon-o-at-symbol')
                            ->prefixIconColor('primary')
                            ->label('Email')
                            ->default('dennisenraca25@gmail.com')
                            ->required(),

                        TextInput::make('mobile')
                            ->tel() // or
                            ->prefixIcon('heroicon-o-phone')
                            ->prefixIconColor('primary')
                            ->minLength(10)
                            ->maxLength(10)
                            ->prefix('+63')
                            ->label('Phone')
                            ->default('9050449294')
                            ->helperText('Mobile number must start with +63')
                            ->required(),

                        Textarea::make('message')
                            ->placeholder('I want to book an appointment')
                            ->rows(3)
                            ->default('Test')
                            ->columnSpan(2)
                            ->autosize(),

                ])->columnSpan(2),


            ]);
    }

    //admission staff
    //patient
    //cashier
    //med tech
    //administrator

    //positions
     /*
      Pathologist

     */

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at','desc')
            ->columns([
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Full Name')
                    ->formatStateUsing(fn ($record) => $record->first_name . ' ' .$record->last_name )
                    ->searchable(),

                Tables\Columns\TextColumn::make('appointment_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('appointment_time')
                    ->formatStateUsing(fn ($state) => date('h:i A', strtotime($state))),
                Tables\Columns\TextColumn::make('status')
                    ->numeric()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => getAppointmentStatus($state))
                    ->color(fn (int $state): string => match ($state) {
                        1 => 'warning',
                        2 => 'success',
                        3 => 'danger',
                        4 => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('mobile')
                    ->prefix('+63')
                    ->searchable(),

                Tables\Columns\TextColumn::make('confirmedBy.employee')
                    ->label('Confirmed By')
                    ->formatStateUsing(function ($state){
                        if($state){
                            $user = $state->employee;
                            return ($user) ? $user->first_name . ' ' . $user->last_name : null;
                        }
                        return null;
                    })
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
                //
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->hidden(fn ($record) => ($record->status == 1) ? false : true)
                    ->requiresConfirmation()
                    ->action(function (Appointment $record) {
                        if($record->services()->count() == 0 || $record->services()->where('status',2)->count() < 1) {
                            Notification::make()
                                ->title('Error')
                                ->body('No services selected/approved for this appointment.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->status = 2;
                        $record->confimed_by = auth()->user()->id;
                        $record->save();

                        //send email reminder here

                        Notification::make()
                            ->title('Success')
                            ->body('Appointment has been approved.')
                            ->success()
                            ->send();
                    })
                    ->color('success'),
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
            RelationManagers\ServicesRelationManager::class,
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'view' => Pages\ViewAppointment::route('/{record}'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
