<?php

namespace App\Filament\Resources;

use App\Actions\Form\AppointmentFields\DateTimeMessage;
use App\Actions\Form\PatientInformation\Address;
use App\Actions\Form\PatientInformation\PersonalInfo;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'fas-calendar-days';
    protected static ?string $navigationGroup = 'Admission';

    public static function form(Form $form): Form
    {

        return $form->schema(static::getAppointmentFormSchema())->columns(1);
    }

    public static function getAppointmentFormSchema(): array
    {
        $patientInfoField = PersonalInfo::run();
        $patientAddressField = Address::run();
        $appointmentField = DateTimeMessage::run();

        return [
            Section::make('Appointment Details')
                ->description(function (Appointment $record) {
                    if ($record->services()->count() == 0 || $record->services()->where('status', 2)->count() <= 0) {
                        // $badge = $record->status_name;

                        return new HtmlString('
                                    <div class="flex justify-between">
                                        <span class="text-red-500">You must approve at least 1 booked services before appointment confirmation</span>
                                    </div>
                                ');
                    }
                    return null;
                })
                ->schema([
                    Fieldset::make('Patient Information')
                        ->relationship('patient')
                        ->disabled()
                        ->schema(array_merge(
                            $patientInfoField,
                            [
                                Fieldset::make('Address')
                                    ->relationship('address')
                                    ->schema($patientAddressField)
                                    ->columnSpanFull()
                                    ->columns(2),
                            ]
                        ))->columns(3)->columnSpan(2),

                    Fieldset::make('Appointment Date')
                        ->schema($appointmentField)
                        ->columns(1)
                        ->disabled(fn(Appointment $record) => ($record->status == 1) ? false : true)
                        ->columnSpan(1),
                ])->columns(3),

        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('patient')
                    ->label('Full Name')
                    ->formatStateUsing(fn($state) => $state->first_name . ' ' . $state->last_name)
                    ->searchable(),

                Tables\Columns\TextColumn::make('appointment_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('appointment_time')
                    ->formatStateUsing(fn($state) => date('h:i A', strtotime($state))),
                Tables\Columns\TextColumn::make('status')
                    ->numeric()
                    ->searchable()
                    ->formatStateUsing(fn($state) => getAppointmentStatus($state))
                    ->color(fn(int $state): string => match ($state) {
                        1 => 'warning',
                        2 => 'success',
                        3 => 'danger',
                        4 => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('patient.mobile')
                    ->prefix('+63')
                    ->searchable(),

                Tables\Columns\TextColumn::make('confirmedBy.employee')
                    ->label('Confirmed By')
                    ->formatStateUsing(function ($state) {
                        if ($state) {
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
                    ->label('Confirm Appointment')
                    ->hidden(fn($record) => ($record->status == 1) ? false : true)
                    ->requiresConfirmation()
                    ->action(function (Appointment $record) {
                        Mail::to($record->patient->user->email)->queue(new AppointmentConfirmation($record->id));
                        if ($record->services()->count() == 0 || $record->services()->where('status', 2)->count() < 1) {
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
