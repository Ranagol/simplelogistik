<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'locale',
        'flag',
        'is_active'
    ];
    public function entries(){
        return $this->hasMany(SystemTranslation::class, 'language_id');
    }
}
