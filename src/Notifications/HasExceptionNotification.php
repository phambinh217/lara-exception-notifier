<?php

namespace Phambinh\LaraExceptionNotifier\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Phambinh\LaraExceptionNotifier\Events\HasExceptionEvent;

class HasExceptionNotification extends Notification
{
    use Queueable;

    protected $event;

    public function __construct(HasExceptionEvent $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        if (config('notification.lara_exception_notify.channel')) {
            return config('notification.lara_exception_notify.channel');
        }

        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $notification = (new SlackMessage)
                ->error()
                ->content($this->event->exception->getMessage())
                ->attachment(function ($attachment) {
                    $attachment->title(get_class($this->event->exception))
                        ->content('File: ' . $this->event->exception->getFile() . ' on line' . $this->event->exception->getLine());
                });

        if ($this->event->metas && is_array($this->event->metas)) {
            $notification->attachment(function ($attachment) {
                $attachment->title('Metas');
                foreach ($this->event->metas as $title => $message) {
                    $attachment->content("$title: $message");
                }
            });
        }

        return $notification;
    }
}
