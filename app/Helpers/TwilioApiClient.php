<?php

namespace App\Helpers;

class TwilioApiClient {

    public function getAvailablePhoneNumbers()
    {
        // TODO inject config in construct like this:
        //Config::get('external.twilio');
    }

    public function buyPhoneNumber()
    {
        // TODO implement
    }

    public function sendSms()
    {
        // TODO implement
    }

}