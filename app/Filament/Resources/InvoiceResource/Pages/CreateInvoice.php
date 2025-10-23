<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Filament\Widgets\QueueAction;
use App\Models\QueueChecklist;
use App\Models\Transaction;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{

    protected static string $resource = InvoiceResource::class;

    public $checklist_details;
    public $transaction;

    public $code;

    public function mount(?QueueChecklist $checklist_details = null): void
    {

        parent::mount(); // important: always call this first
        if(!$checklist_details){
            Notification::make('Transaction Creation')
                ->title('No checklist details found.')
                ->danger()
                ->send();
            redirect()->route('filament.admin.resources.transactions.index');
        }
        else{
            $code  = generateInvoiceCode();
            $this->code = $code;

            $transactionID = Transaction::where('queue_id',$checklist_details->queue->id)->first();
            $this->transaction = $transactionID;
            $total_amount = 0;


            $services = $transactionID->tests->map( function ($service)use ($total_amount){
                return[
                    'name' => "{$service->service->code} {$service->service->station->name} - {$service->service->name}",
                    'price' => number_format($service->service->price, 2)
                ];
            });
            foreach($services as $service){
                $total_amount += $service['price'];
            }
            $filled = [
                'invoice_number' => $code,
                'transaction_id' => $transactionID->id,
                'service_availed' => $services,
                'total_amount' => number_format($total_amount,2),
            ];
            $this->form->fill($filled);
        }

    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $to_complete = clone $this->checklist_details;
        $to_complete->is_current = false;
        $to_complete->latest_status = 4;
        $to_complete->update();
        $nextStation = $to_complete->queue->checklists()->pending()->where('id', '!=', $to_complete->id)->orderBy('id','asc')->first();
        if($nextStation){
            $nextStation->is_current = true;
            $nextStation->update();
        }

        $data['amount_paid'] = str_replace(',', '', ($data['total_amount'] ?? 0));

        $data['is_paid'] = true;
        $data['invoice_number'] = $this->code;
        $data['is_paid'] = true;

        $data['created_by'] = auth()->user()?->employee?->id ?? null;
        
        return $data;
    }

    protected function afterCreate(): void
    {

        $this->record->transaction_id = $this->transaction->id;
        $this->record->update();
        $this->transaction->billing_id = $this->record->id;
        $this->transaction->update();

        $last_sort = $this->checklist_details->queue->checklists()->max('sort_order') ?? 0;

        QueueChecklist::insert([
            'queue_id' => $this->checklist_details->queue_id,
            'station_id' => 9,
            'is_default_step' => true,
            'step_name' => 'releasing',
            'sort_order' => $last_sort + 1
        ]);

        $action = new QueueAction();
        $action->getTimestamp($this->checklist_details->id, 4); // completed timestamp

        redirect()->route('filament.admin.resources.invoices.index');
    }



}
