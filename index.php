<?php

use kkchaulagain\phpQueue\BookingHook;

require 'vendor/autoload.php';

$connection = [
    'user' => 'guest',
    'host' => 'rabbitmq',
    'port' => '5672',
    'password' => 'guest'
];

BookingHook::dispatch(['sad'])
    ->onQueue('test')
    ->onConnection($connection);