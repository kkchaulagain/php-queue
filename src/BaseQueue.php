<?php

namespace kkchaulagain\phpQueue;

use kkchaulagain\phpQueue\Bus\traits\Dispatchable;
use kkchaulagain\phpQueue\Bus\traits\InteractWithQueue;
use kkchaulagain\phpQueue\Bus\traits\Queueable;

abstract class BaseQueue {
    use Dispatchable,Queueable,InteractWithQueue;
}