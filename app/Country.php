<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable = ['name', 'code', 'is_active'];
    protected $guarded = ['created_at', 'updated_at'];

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

}
