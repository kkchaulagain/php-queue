<?php

namespace kkchaulagain\phpQueue;

class BookingHook extends BaseQueue
{

    public $data;

    public function __construct(array $payload = [])
    {
        $this->data = $payload;
    }


    public function handle()
    {
        echo "Handling" . PHP_EOL;
        echo is_string($this->data) . PHP_EOL;
        echo "Handled";
    }
}
