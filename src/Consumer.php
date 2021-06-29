<?php

namespace kkchaulagain\phpQueue;

use kkchaulagain\phpQueue\Bus\Pipeline;

class Consumer
{
    public static function consume($queue,$vhost='/')
    {
        $pipeline = new Pipeline($queue);
        $pipeline->executeMqJobs($vhost);
    }
}
