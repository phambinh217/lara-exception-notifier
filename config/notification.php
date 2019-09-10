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