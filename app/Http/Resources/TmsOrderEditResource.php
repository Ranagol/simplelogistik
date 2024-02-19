<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Formats one order model for order edit page.
 */
class TmsOrderEditResource extends JsonResource
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
            
            //relationships are loaded in the controller, so here we can just return them
            'parcels' => $this->parcels,
            'addresses' => $this->orderAddresses,
            'forwarder' => $this->forwarder,
            'history' => $this->orderHistories,
            'customer' => $this->customer,
            'partner' => $this->partner,
            'contact' => $this->contact,
            
            //this is actually data from native orders or pamyra orders table.
            'details' => $this->setDetails(),
        ];
    }

    /**
     * Every order has pamyra order or native order. Either one or the other. Not both. In the 
     * controller we call pamyraOrder() and nativeOrder() relationships. One of them will be null.
     * The other one will have data. We place the found data under the key 'details' in the
     * response.
     *
     * @return void
     */
    private function setDetails()
    {

        $pamyraOrder = $this->pamyraOrder ?? null;
        $nativeOrder = $this->nativeOrder ?? null;

        if ($pamyraOrder) {
            return $pamyraOrder;
        }

        if ($nativeOrder) {
            return $nativeOrder;
        }
    }
}


