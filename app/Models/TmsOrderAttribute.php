<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TmsOrderAttribute extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_order_attributes";

    /**
     * This is the list of all Pamyra order attributes. It comes from here:
     * https://www.pamyra.de/academy/tms-schnittstellen
     * This list will be used for seeding order attributes.
     *
     * @var array
     */
    public const RAW_ATTRIBUTES_FROM_PAMYRA = [
        'overnightExpress',
        'sameDayDelivery',
        'lastMinute',
        'clocklikePickup',
        'clocklikeDelivery',
        'deliveryUntil8',
        'deliveryUntil10',
        'deliveryUntil12',
        'deliveryUntil14',
        'deliveryUntil16',
        'loadbySide',
        'loadbyTop',
        'loadbyBack',
        'newGoodsInsured',
        'usedGoodsInsured',
        'privateCustomer',
        'commercialCustomer',
        'allCustomer',
        'tailLiftAvailable',
        'forkLiftAvailable',
        'palletTruckAvailable',
        'craneAvailable',
        'notificationPhoneCallAgencySender',
        'notificationPhoneCallAgencyReceiver',
        'notificationSMSSender',
        'notificationSMSReceiver',
        'notificationPhoneCallDriverSender',
        'notificationPhoneCallDriverReceiver',
        'notificationEmailSender',
        'notificationEmailReceiver',
        'twoPeopleSender',
        'twoPeopleReceiver',
        'exchangePalette',
        'exchangeLatticeBox',
        'exchangeBox',
        'amazonProcessing',
        'rack',
        'dangerousGoods',
        'bulkFurniture',
        'usedFurniture',
        'newFurniture',
        'justPalletized',
        'cooledFood',
        'frozenFood',
        'uncooledFood',
        'isFrozen',
        'spirits',
        'underrun',
        'usedProducts',
        'motorbike',
        'bicycle',
        'ebike',
        'palette',
        'whiteGoods',
        'longWood',
        'lumber',
        'glass',
        'slab',
        'doorAndWindow',
        'machine',
        'tires',
        'fairTransport',
        'unloadByDriver',
        'loadTracking',
        'importClearance',
        'exportClearance',
        'movementCertificateEur1',
        'customsTariffLine',
        'deliveryReceipt',
        'deliveryToHarbour',
        'deliveryToAirport',
        'pickupFixed',
        'externalTimeSlotPlatform'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(TmsOrder::class, 'tms_order_id');
    }
}
