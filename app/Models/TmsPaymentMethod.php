<?php

namespace App\Models;

use App\Models\TmsOrder;
use App\Models\TmsCustomer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TmsPaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'tms_payment_methods';

    /**
     * These payment methods are from Pamyra webpage.
     * https://www.pamyra.de/academy/tms-schnittstellen
     * [bill, cashOnDelivery, preCashTransfer, creditCard, directDebit]
     * They are used in seeding the database. If you want to add more payment methods, add them here.
     * internal_name is our internal name of the payment method in the database.
     * external_name is the name of the payment method in the Pamyra webpage.
     * 
     * @var array<int, array<string, string>>
     */
    public const PAYMENT_METHODS = [
        1 => [
            'internal_name' => 'Invoice',
            'external_name' => 'bill',
        ],
        2 => [
            'internal_name' => 'Cash on delivery',
            'external_name' => 'cashOnDelivery',
        ],
        3 => [
            'internal_name' => 'Paypal',
            'external_name' => 'preCashTransfer',
        ],
        4 => [
            'internal_name' => 'Vorcasse',
            'external_name' => 'creditCard',
        ],
        5 => [
            'internal_name' => 'Sofort',
            'external_name' => 'directDebit',
        ],
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(
            TmsOrder::class, 
            'order_payment_method', 
            'payment_method_id', 
            'order_id'
        );
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(
            TmsCustomer::class, 
            'customer_payment_method', 
            'payment_method_id', 
            'customer_id'
        );
    }
}

