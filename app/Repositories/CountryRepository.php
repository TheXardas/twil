<?php

namespace App\Repositories;

use App\Country;

class CountryRepository
{
    public function active()
    {
        return Country::where('is_active', true);
    }
}