<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
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
            'parcels' => $this->parcels,
            'addresses' => $this->orderAddresses,
            'forwarder' => $this->forwarder,
            'history' => $this->orderHistories,
            'customer' => $this->customer,
            'partner' => $this->partner,
            'contact' => $this->contact,
            'emonsInvoiceNettoPrice' => $this->emonsInvoice?->netto_price,
            'details' => $this->setDetails(),
            'firstPickupAddress' => $this->getFirstAddressZipAndCity(
                $this->pickupAddresses->sortBy('date_from')
            ),
            'firstDeliveryAddress' => $this->getFirstAddressZipAndCity(
                $this->pickupAddresses->sortBy('date_from')
            ),
            'firstPickupDate' => $this->getFirstPickupDate(),
            'lastDeliveryDate' => $this->getLastDeliveryDate(),
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

    /**
     * Returns the zip and city of the first pickup address, and the number of the remaining addresses.
     * Works both for pickup and for delivery addresses. If a pickup address collection is given as 
     * an argument, then it work with pickup addresses. If a delivery address collection is given as
     * an argument, then it works with delivery addresses.
     *
     * @param Collection $addresses     Example: $this->pickupAddresses->sortBy('date_from')
     * @return string
     */
    private function getFirstAddressZipAndCity(Collection $addresses): string
    {
        $zipAndCity = null;

        //If there is no pickup address, then we return an empty string
        if($addresses->count() === 0) {
            $zipAndCity = '';
        }

        //If there is only one pickup address, then we return the zip and city of that address as a string
        if($addresses->count() === 1) {
            $firstPickupAddress = $addresses->first();
            $zipAndCity = $firstPickupAddress->zip_code . ' ' . $firstPickupAddress->city;
        }

        /**
         * If there are more than one pickup addresses, then we return the zip and city of the first 
         * address, and we add the number of the remaining addresses, all as a string.
         */
        if($addresses->count() > 1) {
            $firstPickupAddress = $addresses->first();
            $zipAndCity = $firstPickupAddress->zip_code 
                        . ' ' 
                        . $firstPickupAddress->city
                        . " + " 
                        . ($addresses->count() - 1) . " more";
        }

        return $zipAndCity;
    }

    /**
     * Returns the date_from of the first pickup address.
     * Takes all belonging pickup addresses, and sorts them by date_from, then takes the first
     * pickup address, and returns its date_from.
     *
     * @return string
     */
    private function getFirstPickupDate(): string
    {
        
        $earliestPickupaddress = $this->pickupAddresses->sortBy('date_from')->first();

        return $earliestPickupaddress->date_from;
    }

    /**
     * Returns the date_to of the last delivery address.
     * Takes all belonging delivery addresses, and sorts them by date_to, then takes the last one.
     *
     * @return string
     */
    private function getLastDeliveryDate(): string
    {
        //Take all belonging delivery addresses, and sort them by date_to, then take the last one.
        $latestDeliveryAddress = $this->deliveryAddresses->sortBy('date_to')->last();

        return $latestDeliveryAddress->date_to;
    }
}
