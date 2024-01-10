<?php

namespace App\Models;

use App\Models\TmsOrderAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsPartner extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'tms_partners';

    public function orders(): HasMany
    {
        return $this->hasMany(TmsOrder::class, 'partner_id');
    }

    public function provisions(): HasMany
    {
        return $this->hasMany(TmsProvision::class, 'partner_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(TmsAddress::class, 'partner_id');
    }

    public function orderAddresses(): HasMany
    {
        return $this->hasMany(TmsOrderAddress::class, 'order_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(TmsContact::class, 'partner_id');
    }
    
}
