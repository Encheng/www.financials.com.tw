<?php

use Illuminate\Support\Str;

return [
    'log_name' => env('LOG_NAME', 'kafka_log'),
    'connection' => env(
        'REDIS_LOG_CONNECTION',
        'log'
    ),
    'quiet' => env(
        'REDIS_LOG_CONNECTION_QUIET',
        false
    ),
    'channels' => [
        'redis-to-kafka' => [
            'host' => env('KAFKA_HOST', '127.0.0.1:9092'),
            'topic' => env('KAFKA_TOPIC', 'logstash'),
            'header' => env('APP_NAME'),
            'channel' => 'redis-to-kafka',
            'include_stack_traces' => env('APP_DEBUG', false)
        ]
    ],
];
