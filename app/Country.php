<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable = ['name', 'code', 'is_active'];
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Access phones, that are available in that country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

}
