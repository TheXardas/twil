<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use League\Flysystem\Config;

class TwilioController extends Controller
{

    /** @var string Local phone number for our company. Calls will be redirected here from all over the world */
    protected $localNumber;

    /**
     * TwilioController constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->localNumber = $config->get('services.twilio.localnumber');
    }

    /**
     * @return Response
     */
    public function processCallStart()
    {
        // TODO log request-params
        // TODO authenticate, that it's twilio callin'

        $response = new \Services_Twilio_Twiml();
        $response->dial($this->localNumber, [
            'action' => action('Api\TwilioController@processCallEnd', [], false),
        ]);
        return $this->ok($response);
    }

    /**
     * @return Response
     */
    public function processCallEnd()
    {
        // TODO log request-params
        // TODO authenticate, that it's twilio callin'

        $response = new \Services_Twilio_Twiml();
        $response->dial($this->localNumber, [
            'action' => action('Api\TwilioController@processCallEnd', [], false),
        ]);
        return $this->ok($response);
    }

    /**
     * @param \Services_Twilio_Twiml $response
     * @return Response
     */
    protected function ok(\Services_Twilio_Twiml $response)
    {
        return new Response($response, 200, [
            'Content-Type' => 'text/xml',
        ]);
    }

}