<?php

namespace App\Repositories;

use App\Country;
use Illuminate\Database\Eloquent\Builder;

class CountryRepository
{
    /**
     * Get active countries, available to call from
     *
     * @return Builder
     */
    public function active()
    {
        return Country::where('is_active', true);
    }
}