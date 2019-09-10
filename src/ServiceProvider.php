<?php

namespace Phambinh\LaraExceptionNotifier;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class ServiceProvider extends EventServiceProvider
{
    protected $listen = [
        'Phambinh\LaraExceptionNotifier\Events\HasExceptionEvent' => [
            'Phambinh\LaraExceptionNotifier\Listeners\HasExceptionListener'
        ]
    ];

    public function boot()
    {
        parent::boot();

        $this->publishes([
            __DIR__ .'/../config/notification.php' => config_path('notification.php')
        ], 'config');
    }
}
