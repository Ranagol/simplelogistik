<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Formats the data structure of all order model object in a collection, that is sent to the
 * order index page. All order will have this structure. If we don't create this class, then all
 * orders will have the structure defined in TmsOrderEditResource.php. This is the way how we can
 * have different data structures for different pages for the same model.
 */
class TmsOrderIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type_of_transport' => $this->type_of_transport,
            'origin' => $this->origin,
            'status' => $this->status,
            'customer_reference' => $this->customer_reference,
            'provision' => $this->provision,
            'order_edited_events' => $this->order_edited_events,
            'currency' => $this->currency,
            'order_number' => $this->order_number,
            'order_date' => $this->order_date,
            'purchase_price' => $this->purchase_price,
            'month_and_year' => $this->month_and_year,
            'avis' => [
                "customer_phone" => $this->avis_customer_phone,
                "sender_phone" => $this->avis_sender_phone,
                "receiver_phone" => $this->avis_receiver_phone,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'payment_method' => $this->payment_method,
            'easy_bill_customer_id' => $this->easy_bill_customer_id,

            'last_update' => $this->orderHistoryLatest?->updated_at->format('Y-m-d H:i:s'),
            'last_editor' => $this->orderHistoryLatest?->user?->name,
            
            //relationships are loaded in the controller, so here we can just return them.
            //this is not deleted, because I expect that we will need it in the future.
            'parcels' => $this->parcels,
            'addresses' => $this->orderAddresses,
            'forwarder' => $this->forwarder,
            'history' => $this->orderHistories,
            'customer' => $this->customer,
            'partner' => $this->partner,
            'contact' => $this->contact,
            'emonsInvoiceNettoPrice' => $this->emonsInvoice?->netto_price,
            'details' => $this->setDetails(),
        ];
    }

    /**
     * It returns either pamyra order or native order data.
     *
     * @return array
     */
    private function setDetails(): array
    {
        $details = $this->pamyraOrder?->toArray() ?? $this->nativeOrder?->toArray();
        return ($details !== null) ? $details : [];
    }
}
