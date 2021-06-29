<?php

namespace kkchaulagain\PhpQueue;

use kkchaulagain\PhpQueue\Bus\traits\Dispatchable;
use kkchaulagain\PhpQueue\Bus\traits\InteractWithQueue;
use kkchaulagain\PhpQueue\Bus\traits\Queueable;

abstract class BaseQueue {
    use Dispatchable,Queueable,InteractWithQueue;
}