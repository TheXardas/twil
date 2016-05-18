<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Test cases for Twilio api's
 * TODO write more tests
 */
class TwilioApiTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test twilio voice initiated call request
     *
     * @return void
     */
    public function testProcessCallStart()
    {
        $this->expectsJobs(\App\Jobs\SendSms::class);

        $localNumber = Config::get('services.twilio.local_number');
        $callSid = '123123';
        $this->get('/processCallStart?From='.urlencode('+123123123').'&CallSid='.$callSid)
            ->see(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Response><Dial action="/processCallEnd">$localNumber</Dial></Response>
XML
        );

        $this->assertEquals(
            DB::table('call_logs')->where('payload', '=', $callSid)->count(),
            1,
            'Failed to create log entry for sms request from Twilio'
        );
    }
    
    /**
     * Test twilio sms recieving process
     *
     * @return void
     */
    public function testProcessSms()
    {
        $this->expectsJobs(\App\Jobs\SendSms::class);

        $messageSid = '123123';
        $this->get('/processSms?From='.urlencode('+321321321')."&Body=Hey, what's up?&MessageSid=$messageSid")
            ->see(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Response/>
XML
        );

        $this->assertEquals(
            DB::table('call_logs')->where('payload', '=', $messageSid)->count(),
            1,
            'Failed to create log entry for sms request from Twilio'
        );
    }
}
