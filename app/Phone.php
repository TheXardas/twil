<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = ['phone_number', 'is_active'];
    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
