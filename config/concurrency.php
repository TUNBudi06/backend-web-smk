<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Concurrency Driver
    |--------------------------------------------------------------------------
    |
    | This option determines the default concurrency driver that will be used
    | by Laravel's concurrency functions. By default, concurrent work will
    | be sent to isolated PHP processes which will return their results.
    |
    | Supported: "process", "fork", "sync"
    | change process to "sync" but change its again when you want to push to production
    |
    */

    'default' => env('CONCURRENCY_DRIVER', 'sync'),

];
