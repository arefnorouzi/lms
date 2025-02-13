<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Services\sms\Melipayamak;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderPaidSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Order $order;
    protected User $user;
    protected int $body_id = 23456;
    /**
     * Create a new job instance.
     */
    public function __construct($order, $user)
    {
        $this->order = $order;
        $this->user = $user;
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
            args: array($name, $this->order->id)
        );
        $sms_service->send_sms();
    }
}
