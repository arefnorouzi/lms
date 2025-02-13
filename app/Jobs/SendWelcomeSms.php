<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\sms\Melipayamak;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWelcomeSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected string $code;
    protected int $body_id = 123456;
    /**
     * Create a new job instance.
     */
    public function __construct($user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $name = 'کاربر گرامی';
        if ($this->user->name)
        {
            $name = $this->user->name;
        }
        if ($this->user->nick_name)
        {
            $name = $this->user->namnick_namee;
        }
        $sms_service = new Melipayamak(
            body_id: $this->body_id,
            to: $this->user->mobile,
            args: array($name, $this->code)
        );
        $sms_service->send_sms();
    }
}
