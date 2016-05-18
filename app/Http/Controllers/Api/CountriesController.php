<?php

namespace App\Http\Controllers\Api;

use App\Country;
use App\Helpers\CountryHelper;
use App\Helpers\TwilioApiClient;
use App\Http\Controllers\Api\ApiController;
use App\Repositories\CountryRepository;
use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;

class CountriesController extends ApiController
{
    /** @var CountryRepository */
    protected $countries;
    /** @var CountryHelper  */
    protected $countryHelper;

    public function __construct(CountryRepository $countries, CountryHelper $countryHelper)
    {
        $this->countries = $countries;
        $this->countryHelper = $countryHelper;
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
        $countryCode = $this->countryHelper->validateCountryCode($countryCode);

        /** @var Country $country */
        $country = $this->countries
            ->active()
            ->where('code', '=', $countryCode)
            ->first()
            ->getModel()
        ;
        if (!$country) {
            return new \Illuminate\Http\Response("No country found", 404);
        }

        // TODO we should have a lock before this query, so we wouldn't buy an excessive phone number
        $country->phone = $country->phones()
            ->where('is_active', '=', true)
            ->first();

        if (!$country->phone) {
            // since there is no phone for that country yet, we should go to phone provider and try help ourselves with one.
            $country = $this->countryHelper->buyPhoneNumberForCountry($country);
        }

        return $country;
    }
}
