<?php

use kkchaulagain\phpQueue\BookingHook;

require 'vendor/autoload.php';


BookingHook::dispatch(['sad'])->onQueue('test');