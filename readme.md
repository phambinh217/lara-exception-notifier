# Introduction
Notify to your slack channel when your project have exceptions

# Required
* laravel >= 5.4

# Usage
Step 1: Required to your project
Add your project via composer

`composer require phambinh/lara-except-notify`

Step 2: Register service provider
If you are using laravel 5.4, you have to open `config/app.php` and append providers

```php
'providers' => [
    ...
    Phambinh\LaraExceptionNotifier\ServiceProvider::class,
]
```

If you are using laravel 5.5 or higher, skip this step. Go to step 3

Step 3: Publish vendor

`php artisan vendor:publish --provider=Phambinh\LaraExceptionNotifier\ServiceProvider`

Step 4: Config your channel

Open `config/notification.php`, you will see

```php
<?php

return [
    'lara_exception_notify' => [
        // allow true or false
        // true is enable notify when have exception
        // false is disable notify
        'enable' => true,

        // The channel you want to nofity
        'channel' => ['slack'],

        // Your slack web hook
        // more information about slack web hook: https://api.slack.com/incoming-webhooks
        'slack_web_hook_url' => ''
    ]
];
```

Step 4: Add event

Open `app/Exceptions/Handler.php` and go to `report` action, change to

```php
    // use Phambinh\LaraExceptionNotifier\Events\HasExceptionEvent;

    public function report(Exception $exception)
    {
        parent::report($exception);

        if ($this->shouldReport($exception)) {
            event(new HasExceptionEvent($exception));
        }
    }
```
