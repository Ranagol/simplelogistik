<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Althoug all default seeding data/constants is usually stored in the model, in this case we can't do it
 * because of certain multiple restrictions. So, all constants and all seeding data is stored in the
 * TmsFtpCredentialSeeder.
 */
class TmsFtpCredential extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'tms_ftp_credentials';

    protected $casts = [
        'passive' => 'boolean',
        'ssl' => 'boolean',
        'throw' => 'boolean',
    ];    
}
