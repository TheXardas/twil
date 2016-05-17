<?php

namespace App\Helpers;

use League\Flysystem\Config;

/**
 * TODO implement hardcore logging and exception-handleling here.
 */
class TwilioApiClient
{

    /** @var \Services_Twilio Twilio library client */
    protected $client;

    /**
     * TwilioApiClient constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->client = new \Services_Twilio(
            $config->get('services.twilio.sid'),
            $config->get('services.twilio.token')
        );
    }

    /**
     * @param string $countryCode
     * @return \Services_Twilio_Rest_AvailablePhoneNumbers
     * @throws \Exception
     */
    public function getAvailablePhoneNumbers($countryCode)
    {
        if (!$countryCode) {
            throw new \Exception('Country code is required in ' . __METHOD__);
        }
        return $this->client->account->available_phone_numbers->getList(strtoupper($countryCode), 'Local');
    }

    /**
     * @param $phoneNumber
     * @return \Services_Twilio_Rest_IncomingPhoneNumber
     * @throws \Exception
     */
    public function buyPhoneNumber($phoneNumber, $name = '')
    {
        if (!$phoneNumber) {
            throw new \Exception('Phone number is required in ' . __METHOD__);
        }
        $params = [
            'PhoneNumber' => $phoneNumber,
            'VoiceUrl' => action('Api\TwilioController@processCallStart'),
            'VoiceFallbackUrl' => action('Api\TwilioFallbackController@voiceFallback'),
            'SmsUrl' => action('Api\TwilioController@processSmsStart'),
            'SmsFallbackUrl' => action('Api\TwilioFallbackController@smsFallback'),
        ];
        if ($name) {
            $params['FriendlyName'] = $name;
        }

        return $this->client->incoming_phone_numbers->create($params);
    }

    /**
     * @param $numberSid
     * @return mixed
     * @throws \Exception
     */
    public function deletePhoneNumber($numberSid)
    {
        if (!$numberSid) {
            throw new \Exception('Number sid is required in ' . __METHOD__);
        }
        return $this->client->account->incoming_phone_numbers->delete($numberSid);
    }

    /**
     * @param $from
     * @param $to
     * @param $text
     * @return \Services_Twilio_Rest_Message
     * @throws \Exception
     */
    public function sendSms($from, $to, $text)
    {
        if (!$from || !$to || !$text) {
            throw new \Exception('All parameters are required in ' . __METHOD__);
        }
        return $this->client->account->messages->sendMessage(
            $from, $to, $text
        );
    }

}