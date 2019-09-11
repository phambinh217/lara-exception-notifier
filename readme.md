# Introduction
Notify to your slack channel when your project have exceptions

# Required
* laravel >= 5.5

# Usage

## Basic usage

**Step 1**: Required to your project
Add your project via composer

`composer require phambinh/lara-exception-notifier`

If you are using laravel 5.5 or higher, skip this step. Go to step 3

**Step 2**: Publish vendor

`php artisan vendor:publish --provider=Phambinh\LaraExceptionNotifier\ServiceProvider`

**Step 3**: Config your channel

Open `config/notification.php`, you will see

```php
<?php

return [
    'exception_notifier' => [
        // allow true or false
        // true is enable notify when have exception
        // false is disable notify
        'enable' => true,

        // The channel you want to nofity
        // Now, support only slack :D
        'channel' => ['slack'],

        // Your slack web hook
        // more information about slack web hook: https://api.slack.com/incoming-webhooks
        'slack_web_hook_url' => ''
    ]
];
```

**Step 4**: Emit event

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

## Want to know exception when try catch

Sometimes, you use try/catch but you want to know the exception, you can do like this bellow
```php
<?php

use Phambinh\LaraExceptionNotifier\Events\HasExceptionEvent;

class MyController extends Controller
{
    public function index()
    {
        try {
            // your code here
        } catch (\Exception $e) {
            event(new HasExceptionEvent($e));
        }
    }
}
```

## Give more information for exceptions

Sometimes, you have a exception but the message is not enough to know, you want to know more information about exception. You can use the second parameters of HasExceptionEvent class like example bellow.

```php
<?php

use Phambinh\LaraExceptionNotifier\Events\HasExceptionEvent;
use Phambinh\LaraExceptionNotifier\Exceptions\QuietException;

class MyController extends Controller
{
    public function index()
    {
        $a = 1;
        $b = 0;

        try {
            $c = $a/$b;
        } catch (\Exception $e) {
            event(new HasExceptionEvent($e, [
                'a' => $a,
                'b' => $b,
            ]));

            throw new QuietException($e);
            // noti
            // throw $e; # Don't use, because you will be received duplicate message
            // no throw # The laravel will never log
        }
    }
}
```
