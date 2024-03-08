<?php

namespace App\Http\Resources\OrderResources;

use DateTime;
use Illuminate\Http\Request;
use App\Models\TmsOrderStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Formats the data structure of all order model object in a collection, that is sent to the
 * order index page. All order will have this structure. If we don't create this class, then all
 * orders will have the structure defined in ShowEditResource.php. This is the way how we can
 * have different data structures for different pages for the same model.
 */
class IndexResource extends JsonResource
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
            'order_status_id' => $this->order_status_id,
            'order_status_text' => TmsOrderStatus::getInternalStatusName($this->order_status_id),
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

            'emonsInvoiceNettoPrice' => $this->emonsInvoice?->netto_price,
            'firstPickupAddress' => $this->getFirstAddressZipAndCity(
                $this->pickupAddresses->sortBy('date_from')
            ),
            'firstDeliveryAddress' => $this->getFirstAddressZipAndCity(
                $this->deliveryAddresses->sortBy('date_from')
            ),
            'pickupDate' => $this->getPickupDatePeriod(),
            'deliveryDate' => $this->getDeliveryDatePeriod(),
            
            //relationships are loaded in the controller, so here we can just return them.
            'parcels' => $this->parcels,
            'forwarder' => $this->forwarder,
            'history' => $this->orderHistories,
            'customer' => $this->customer,
            'partner' => $this->partner,
            'contact' => $this->contact,
            'details' => $this->setDetails(),
            'addresses' => $this->getAddresses(),
        ];
    }

    /**
     * It returns either pamyra order or native order data.
     *
     * @return array
     */
    private function setDetails(): array
    {
        //If pamyraOrder is not null, then we return it. If it is null, then we return nativeOrder.
        $details = $this->pamyraOrder?->toArray() ?? $this->nativeOrder?->toArray();

        //If $details is not null, then we return it. If it is null, then we return an empty array.
        return ($details !== null) ? $details : [];
    }

    /**
     * Return all the orderAddresses, in the next order: billing, pickup, delivery.
     * Every returned orderAddress will have an additional key called index. This index will be
     * mirroring this actual order of the orderAddresses. This index will be 0 for the billing, and
     * then it will be 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, etc. for the pickup and delivery addresses.
     * When this method processes the addresses, there are a couple of steps:
     * 1. Get the addresses with a relationship
     * 2. Convert every TmsOrderAddress object to an array, so we can add the index key to them.
     * 3. Add the index key to every address, with the value of the current index.
     * 4. Add the address to the addresses array.
     * 5. Incresase the index by one.
     * 
     * @return array
     */
    private function getAddresses(): array
    {
        //We collect here all the order addresses
        $addresses = [];

        //This is the index of the addresses. It mirrors the order of the addresses.
        $index = 0;

        //BILLING ADDRESS
        $billingAddress = $this->billingAddress;
        $billingAddress = $this->billingAddress->toArray();
        $billingAddress['index'] = $index;
        $addresses[$index] = $billingAddress;
        $index++;

        //PICKUP ADDRESSES
        $pickupAddresses = $this->pickupAddresses;
        foreach ($pickupAddresses as $pickupAddress) {
            $pickupAddress = $pickupAddress->toArray();
            $pickupAddress['index'] = $index;
            $addresses[$index] = $pickupAddress;
            $index++;
        }

        //DELIVERY ADDRESSES
        $deliveryAddresses = $this->deliveryAddresses;
        foreach ($deliveryAddresses as $deliveryAddress) {
            $deliveryAddress = $deliveryAddress->toArray();
            $deliveryAddress['index'] = $index;
            $addresses[$index] = $deliveryAddress;
            $index++;
        }

        return $addresses;
    }

    /**
     * Returns the zip and city of the first pickup address, and the number of the remaining addresses.
     * Works both for pickup and for delivery addresses. If a pickup address collection is given as 
     * an argument, then it work with pickup addresses. If a delivery address collection is given as
     * an argument, then it works with delivery addresses.
     * 
     * Change: country code like for example 'DE' must be added to the string too.
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
            $zipAndCity .=  $firstPickupAddress
                                    ->country
                                    ->alpha2_code
                            . ' '
                            . $firstPickupAddress->zip_code
                            . ' ' 
                            . $firstPickupAddress->city;
        }

        /**
         * If there are more than one pickup addresses, then we return the zip and city of the first 
         * address, and we add the number of the remaining addresses, all as a string.
         */
        if($addresses->count() > 1) {
            $firstPickupAddress = $addresses->first();
            $zipAndCity .=  $firstPickupAddress
                                    ->country
                                    ->alpha2_code
                            . ' '
                            . $firstPickupAddress->zip_code
                            . ' ' 
                            . $firstPickupAddress->city
                            . ' +' . ($addresses->count() - 1);
        }

        return $zipAndCity;
    }

    /**
     * Returns the date_from of the first pickup address.
     * Takes all belonging pickup addresses, and sorts them by date_from, then takes the first
     * pickup address, the last pickup address and returns its date_from as a string.
     * 
     * Example: pickupDate = 23.03.2024 - 29.03.2024 
     *
     * @return string
     */
    private function getPickupDatePeriod(): string
    {
        //$this->pickupAddresses is a relationship, that returns a collection of pickup addresses.
        $pickupaddresses = $this->pickupAddresses->sortBy('date_from');

        //$pickupAddresses is a collection, so we can use the first() and last() methods on it.
        $earliestPickupaddress = $pickupaddresses->first();
        $latestPickupaddress = $pickupaddresses->last();

        //We format the date to the format 'd.m.Y'.
        $earliestPickupDate = $this->formatDate($earliestPickupaddress->date_from);
        $latestPickupDate = $this->formatDate($latestPickupaddress->date_to);

        return $earliestPickupDate 
                . ' - ' 
                . $latestPickupDate;
    }

    /**
     * Formats the date to the format 'd.m.Y'.
     *
     * @param string $date
     * @return string
     */
    private function formatDate(string $date): string
    {
        $date = new DateTime($date);
        return $date->format('d.m.Y');
    }

    /**
     * Returns the date_to of the last delivery address.
     * Takes all belonging delivery addresses, and sorts them by date_to, then takes the last one.
     *
     * @return string
     */
    private function getDeliveryDatePeriod(): string
    {
        //$this->deliveryAddresses is a relationship, that returns a collection of delivery addresses.
        $deliveryAddresses = $this->deliveryAddresses->sortBy('date_to');

        //$deliveryAddresses is a collection, so we can use the last() and first method on it.
        $earliestDeliveryAddress = $deliveryAddresses->first();
        $latestDeliveryAddress = $deliveryAddresses->last();

        //We format the date to the format 'd.m.Y'.
        $earliestDeliveryDate = $this->formatDate($earliestDeliveryAddress->date_from);
        $latestDeliveryDate = $this->formatDate($latestDeliveryAddress->date_to);

        return $earliestDeliveryDate 
                . ' - ' 
                . $latestDeliveryDate;
    }
}
