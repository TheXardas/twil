<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CountryApiTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Tests country controller
     *
     * @return void
     */
    public function testCountryRequest()
    {
        $country = \App\Country::where('code', '=', 'dk')->first()->getModel();
        $country->phones()->save(
            \App\Phone::create([
                'is_active' => true,
                'phone_number' => '+123123123',
            ])
        );

        $this->get('/api/country/dk')
            ->seeJson([
                'name' => 'Denmark',
                'code' => 'dk',
                'is_active' => 1,
            ])
            ->seeJsonSubset([
                'phone' => [
                    'country_id' => $country->id,
                    'phone_number' => '+123123123',
                    'is_active' => 1,
                ],
            ]);
    }
}
