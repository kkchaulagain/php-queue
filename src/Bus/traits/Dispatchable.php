<?php

namespace kkchaulagain\PhpQueue\Bus\traits;

/**
 *  This can dispatch an event
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
