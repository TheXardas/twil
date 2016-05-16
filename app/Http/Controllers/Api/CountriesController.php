<?php

namespace App\Http\Controllers\Api;

use App\Country;
use App\Http\Controllers\Api\ApiController;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;

class CountriesController extends ApiController
{
    /** @var CountryRepository  */
    protected $countries;

    public function __construct(CountryRepository $countries)
    {
        $this->countries = $countries;
        parent::__construct();
    }


    /**
     * Returns list of available countries to call to
     */
    public function index()
    {
        return [];
    }

    public function show($countryCode)
    {
        sleep(2);
        $country = $this->countries
            ->active()
            ->where('code', '=', $countryCode)
            ->first()
        ;
        if (!$country) {
            return new \Illuminate\Http\Response("No country found", 404);
        }
        $country->phone = $country->phones()
            ->where('is_active', '=', true)
            ->first()
        ;
        return $country;
    }
}
