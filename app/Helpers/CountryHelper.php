<?php

namespace App\Helpers;

use App\Repositories\CountryRepository;
use DB;
use App\Country;
use App\Phone;

class CountryHelper
{
    /** @var TwilioApiClient */
    protected $twilioApiClient;
    /** @var CountryRepository */
    protected $countries;

    /**
     * CountryHelper constructor.
     * @param TwilioApiClient $twilioApiClient
     */
    public function __construct(TwilioApiClient $twilioApiClient, CountryRepository $countries)
    {
        $this->twilioApiClient = $twilioApiClient;
        $this->countries = $countries;
    }

    /**
     * @param string $countryCode
     * @return string
     * @throws \Exception
     */
    public function validateCountryCode($countryCode = '')
    {
        $countryCode = strtolower($countryCode);
        if (!$countryCode) {
            throw new \Exception('Country code cannot be empty');
        }
        if (strlen($countryCode) !== 2) {
            throw new \Exception('Country code should only be two characters');
        }
        if (!preg_match('/^[a-z]{2}$/', $countryCode)) {
            throw new \Exception('Only latin characters are allowed in country code');
        }

        return $countryCode;
    }

    /**
     * @param Country $country
     * @return Country
     * @throws \Exception
     */
    public function buyPhoneNumberForCountry(Country $country)
    {
        if (!$country || !$country->id || !$country->code) {
            throw new \Exception('Country is required');
        }
        DB::beginTransaction();

        try {
            // Accessing country with lock, so we won't buy a phone_number twice.
            $countryId = $country->id;
            $country = $this->countries->getLocked($countryId);
            $country->phone = $country->phones()
                ->where('is_active', '=', true)
                ->first();
            if ($country->phone) {
                DB::commit();
                return $country;
            }

            // TODO make it environment-free
            //$availablePhones = $this->twilioApiClient->getAvailablePhoneNumbers($country->code);
            //$phoneNumber = $availablePhones->available_phone_numbers[0]->phone_number;
            $phoneNumber = '+15005550006';

            $phone = $this->twilioApiClient->buyPhoneNumber($phoneNumber);
            $phoneModel = new Phone([
                'phone_number' => $phone->phone_number,
                'is_active' => true,
            ]);

            $country->phones()->save($phoneModel);
            $country->phone = $phoneModel;

            // lock end
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return $country;
    }
}