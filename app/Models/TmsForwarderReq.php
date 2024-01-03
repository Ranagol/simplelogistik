<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TmsForwarderReq extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "tms_forwarder_reqs";

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(TmsRequirement::class);
    }

    public function forwarders(): BelongsToMany
    {
        //forwarder_forwarder_req_pivot is the pivot table name between forwarders and forwarder_reqs
        return $this->belongsToMany(TmsForwarder::class, 'forwarder_forwarder_req_pivot');
    }


}
