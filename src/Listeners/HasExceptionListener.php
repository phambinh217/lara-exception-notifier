<?php

namespace Phambinh\LaraExceptionNotifier\Listeners;

use Phambinh\LaraExceptionNotifier\Events\HasExceptionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Phambinh\LaraExceptionNotifier\Notifications\HasExceptionNotification;
use Phambinh\LaraExceptionNotifier\Exceptions\QuietException;
use Notification;
use Exception;

class HasExceptionListener
{
    public function handle(HasExceptionEvent $event)
    {
        if (!config('notification.lara_exception_notify.enable')) {
            return;
        }

        if ($event->exception instanceof QuietException) {
            return;
        }

        $notify = new HasExceptionNotification($event);

        if (!config('notification.lara_exception_notify.slack_web_hook_url')) {
            throw new Exception('Can not find config "notification.lara_exception_notify.slack_web_hook_url" information');
        }

        Notification::route('slack', config('notification.lara_exception_notify.slack_web_hook_url'))->notify($notify);
    }
}
