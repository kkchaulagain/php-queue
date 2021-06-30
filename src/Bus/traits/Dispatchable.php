<?php

namespace kkchaulagain\phpQueue\Bus\traits;

/**
 *  This trait helps to give ability to dispatch the queue
 */
trait Dispatchable
{
    public static function dispatch()
    {
        return new static(...func_get_args());
    }

    public function __destruct()
    {
        if (!$this->nosave) {
            $payload['data'] = json_encode($this);
            $payload['classname'] = $this->getNameOfClass();
            $this->save($payload);
        }
    }
}
