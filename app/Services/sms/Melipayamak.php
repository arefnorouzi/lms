<?php

namespace App\Services\sms;

use Illuminate\Support\Facades\Log;

class Melipayamak
{
    protected int $body_id;
    protected string $to;
    protected array $args;

    public function __construct(int $body_id, string $to, array $args)
    {
        $this->body_id = $body_id;
        $this->to = $to;
        $this->args = $args;
    }
    public function send_sms(): void
    {
        Log::info("send sms to: $this->to");

    }
}
