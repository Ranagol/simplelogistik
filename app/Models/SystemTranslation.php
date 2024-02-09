<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemTranslation extends Model
{
    use HasFactory;

    public function language(){
        return $this->belongsTo(SystemLanguage::class);
    }

    public function parent(){
        return $this->belongsTo(SystemTranslation::class, 'parent_id');
    }
    
    public function children(){
        return $this->hasMany(SystemTranslation::class, 'parent_id');
    }
}
