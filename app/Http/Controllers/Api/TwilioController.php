<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendSms;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Config\Repository as Config;
use DB;


class TwilioController extends Controller
{

    const SMS_REPLY_DELAY = 60 * 18;
    const SMS_FULL_REPLY_CALL_LENGTH = 60 * 2;

    const CALL_LOG_ACTION = 'call';
    const SMS_LOG_ACTION = 'sms';

    /** @var string Local phone number for our company. Calls will be redirected here from all over the world */
    protected $localNumber;

    /**
     * TwilioController constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $config->get('services.twilio.localnumber');
        $this->localNumber = $config->get('services.twilio.local_number');
    }

    /**
     * @return Response
     */
    public function processCallStart(Request $request)
    {
        // TODO log request-params
        // TODO authenticate, that it's twilio callin'
        DB::table('call_logs')->insert([
            'action' => self::CALL_LOG_ACTION,
            'payload' => $request->input('CallSid'),
        ]);

        $job = new SendSms(
            $request->input('CallSid'),
            $this->localNumber,
            $request->input('From'),
            'Hey, thanks for your call!'
        );
        $job->delay(self::SMS_REPLY_DELAY);
        $this->dispatch($job);

        $response = new \Services_Twilio_Twiml();
        $response->dial($this->localNumber, [
            'action' => action('Api\TwilioController@processCallEnd', [], false),
        ]);
        return $this->ok($response);
    }

    /**
     * @return Response
     */
    public function processCallEnd(Request $request)
    {
        $duration = $request->input('CallDuration');
        if ($duration > self::SMS_FULL_REPLY_CALL_LENGTH) {
            // TODO find and remove old job, create new one.
        }

        // TODO log request-params
        // TODO authenticate, that it's twilio callin'

        $response = new \Services_Twilio_Twiml();
        $response->dial($this->localNumber, [
            'action' => action('Api\TwilioController@processCallEnd', [], false),
        ]);
        return $this->ok($response);
    }

    /**
     * Process sms request from Twilio
     *
     */
    public function processSms(Request $request)
    {
        DB::table('call_logs')->insert([
            'action' => self::SMS_LOG_ACTION,
            'payload' => $request->input('MessageSid'),
        ]);

        $job = new SendSms(
            $request->input('MessageSid'),
            $this->localNumber,
            $request->input('From'),
            'Hey, thanks for your message!'
        );
        $job->delay(self::SMS_REPLY_DELAY);
        $this->dispatch($job);

        // Return empty response, we do not need Twilio to do anything. Yet.
        return $this->ok(new \Services_Twilio_Twiml());
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