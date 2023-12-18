<?php

namespace App\Models;

use App\Models\TmsAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TmsCountry extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_countries";

    public function addresses(): HasMany
    {
        return $this->hasMany(TmsAddress::class, 'country_id');
    }
}
