<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Forms\Components\Text;
use App\Forms\Components\TextEntry;
use App\Models\Discount;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\PatientInformation;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use PDO;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'fas-receipt';
    protected static ?string $navigationGroup = 'Cashier';

    public $change = 0;
    public static function form(Form $form): Form
    {
        return $form->schema(static::getInvoiceFormSchema())->columns(1);
    }

    public static function compute_total_amount($set, $get){
        $total_amount = string_to_number($get('total_amount'));
        $total_discount = string_to_number($get('total_discount') ?? 0);
        $amount_paid = string_to_number($get('payments')['amount_tendered'] ?? 00);
        $variation = string_to_number($get('change') ?? 0);
        $grand_total = string_to_number($get('grand_total') ?? 0);

        $discID = string_to_number($get('discount_id'));

        if($discID){
            $discount = Discount::find($discID);
            $total_discount = $total_amount * ($discount ? $discount->percentage / 100 : 0);
            $grand_total = $total_amount - $total_discount;
        }else{
            $total_discount = 0;
            $grand_total = $total_amount;
        }
        if($get('payments')){
            $amount_paid = string_to_number($get('payments')['amount_tendered'] ?? 0);
        }

        $variation = $amount_paid - $grand_total;

        $set('payments.variation', number_format($variation,2));
        $set('payments.amount_paid', $grand_total);
        $set('total_discount', number_format($total_discount,2));
        $set('amount_paid', number_format($amount_paid,2));
        $set('grand_total', number_format($grand_total,2));
    }

    public static function getInvoiceFormSchema(): array
    {
        return [

            Grid::make(2)->schema([
                Forms\Components\TextInput::make('invoice_number')
                ->required()
                ->disabled()
                ->maxLength(255),

            Select::make('transaction_id')
                ->preload()
                ->disabled()
                ->relationship(
                    name: 'transaction',
                    modifyQueryUsing: fn (Builder $query) => $query->orderBy('code'),
                )
                ->getOptionLabelFromRecordUsing(fn (Model $record) => "#{$record->code} {$record->patient->getFullname()}")
                ->searchable(['first_name', 'last_name']),
            ]),
            // Placeholder::make('service_availed')
            //     ->label('')
            //     ->visibleOn('create')
            //     ->content(function ($get) {
            //         // Get the current state of service_availed
            //         $serviceAvailed = $get('service_availed');

            //         return new HtmlString(
            //             view('filament.placeholders.checklist_table', [
            //                 'services' => $serviceAvailed,
            //             ])->render()
            //         );
            //     }),


            Section::make('Billing Details')
                ->columns(3)
                ->schema([
                    Forms\Components\Select::make('discount_id')
                    ->preload()
                    ->live() // Set the field to be reactive.
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        self::compute_total_amount($set, $get);  // correct
                    })
                    ->relationship(
                        name: 'discount',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('name'),
                    )
                    ->columnSpanFull()
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} {$record->percentage}%"),

                    Fieldset::make('Payments')
                        ->schema([
                            Group::make()
                                ->afterStateUpdated(fn (Set $set, Get $get) => self::compute_total_amount($set, $get))
                                ->relationship('payments')
                                ->columnSpanFull()
                                ->schema([
                                    Select::make('payment_method_id')
                                        ->columnSpanFull()
                                        ->relationship('paymentMethod','name')
                                        // ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->live()
                                        ->required(),

                                    TextInput::make('reference_number')
                                        ->required()
                                        ->live()
                                        ->visible(fn (Get $get) => $get('payment_method_id') != 1),

                                    Grid::make(5)
                                        ->schema([
                                            TextInput::make('amount_tendered')
                                                ->live()
                                                ->prefix('₱')
                                                ->label('Cash Tendered')
                                                ->minValue(0)
                                                ->columnSpan(4)
                                                ->numeric()
                                                ->rules([
                                                    fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                                        $grandTotal = string_to_number($get('../grand_total'));
                                                        if($get('payment_method_id') != 1){
                                                            if (string_to_number($value) != $grandTotal) {
                                                                return $fail('For non-cash payments, the amount must exactly match the grand total of ₱' . number_format($grandTotal, 2) . '.');                                                            }
                                                        }
                                                        if (string_to_number($value) < $grandTotal) {
                                                           return $fail('Insufficient Cash Tendered');
                                                        }
                                                    },
                                                ])
                                                ->required(),

                                            TextEntry::make('variation')
                                                ->label('Change: ')
                                                ->default('0.00')
                                                ->currency('₱')
                                                ->formatStateUsing(fn ($state) =>number_format($state,2)),

                                            TextEntry::make('amount_paid')
                                                ->label('Amount Paid: ')
                                                ->default('0.00')
                                                ->columnSpanFull()
                                                ->inlineLabel()
                                                ->currency('₱')
                                                ->formatStateUsing(fn ($state) =>number_format($state,2)),
                                        ])

                                ])
                        ])
                        ->columnSpan(2),
                    Fieldset::make('Billing Statement')
                        ->columnSpan(1)
                        ->columns(1)
                        ->schema([
                            TextEntry::make('total_amount')->label('Subtotal: ')->columnSpanFull()->default('0.00')->inlineLabel()->currency('₱')->formatStateUsing(fn ($state) =>number_format($state,2)),
                            TextEntry::make('total_discount')->label('Discount: ')->columnSpanFull()->default('0.00')->inlineLabel()->currency('₱')->formatStateUsing(fn ($state) =>number_format($state,2)),
                            TextEntry::make('grand_total')->label('Grand Total: ')->columnSpanFull()->default('0.00')->inlineLabel()->currency('₱')->formatStateUsing(fn ($state) =>number_format($state,2)),
                        ])
                ]),
        ];

    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),


                Tables\Columns\TextColumn::make('transaction.patient_id')
                    ->label('Name')
                    ->formatStateUsing(function ($state){
                        if(!$state){
                            return 'N/A';
                        }
                        return PatientInformation::find($state)->getFullname();
                    })
                    ->searchable(query: function ($query, $search) {
                        $query->whereHas('transaction.patient', function ($q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")
                              ->orWhere('last_name', 'like', "%{$search}%")
                              ->orWhere('pat_id', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_amount')->prefix('₱ ')
                        ->label('Sub Total')
                        ->formatStateUsing(fn ($state) => number_format($state,2))
                        ->sortable(),
                Tables\Columns\TextColumn::make('total_discount')
                    ->label('Discount')
                    ->prefix('₱ ')
                    ->formatStateUsing(fn ($state) => number_format($state,2))
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->prefix('₱ ')
                    ->formatStateUsing(fn ($state) => number_format($state,2))
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_paid')
                    ->boolean(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('download_invoice')
                    ->label('Download Invoice')
                    ->icon('fas-file-pdf')
                    ->color('success')
                    ->openUrlInNewTab(true)
                    ->url(fn (Invoice $record) => route('pdf.invoice',['id' => $record->id]))
                    ->requiresConfirmation(),

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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create/{checklist_details?}'),
            'view' => Pages\ViewInvoice::route('/{record}'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
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
