<?php

namespace App\Jobs;

use App\Helpers\TwilioApiClient;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSms extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var string */
    protected $callSid;
    /** @var string */
    protected $from;
    /** @var string */
    protected $to;
    /** @var string */
    protected $text;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($callSid, $from, $to, $text)
    {
        if (!$callSid || !$from || !$to || !$text) {
            throw new \Exception('All job parameters are required!');
        }
        $this->callSid = $callSid;
        $this->from = $from;
        $this->to = $to;
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TwilioApiClient $twilioApiClient)
    {
        $twilioApiClient->sendSms(
            $this->from,
            $this->to,
            $this->text
        );
    }
}
