<?php

namespace App\Models;

use App\Models\User;
use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TmsDispatcher extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_dispatchers";

    public function forwardingContracts(): HasMany
    {
        return $this->hasMany(TmsForwardingContract::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
