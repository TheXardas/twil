<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Adds first default countries available to call from
 * USA, Denmark and Ireland
 */
class CreateDefaultCounties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $usa = new \App\Country([
            'name' => 'USA',
            'code' => 'us',
            'is_active' => true,
        ]);
        $usa->save();

        $denmark = new \App\Country([
            'name' => 'Denmark',
            'code' => 'dk',
            'is_active' => true,
        ]);
        $denmark->save();

        $ireland = new \App\Country([
            'name' => 'Ireland',
            'code' => 'ie',
            'is_active' => true,
        ]);
        $ireland->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Country::whereIn('code', ['us', 'dk', 'ie'])->delete();
    }
}
