<?php

namespace Phambinh\LaraExceptionNotifier\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Exception;

class HasExceptionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $exception;
    public $metas;

    public function __construct(Exception $exception, $metas = [])
    {
        $this->exception = $exception;
        $this->metas = $metas;
    }
}
