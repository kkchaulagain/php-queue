<?php

namespace kkchaulagain\phpQueue\Tests;

use kkchaulagain\phpQueue\BookingHook;
use kkchaulagain\phpQueue\Exceptions\ParameterNotFoundException;
use PHPUnit\Framework\TestCase;

class FirstClassTest extends TestCase
{
    /** @test */
    public function shouldReturnError()
    {
        try{

            BookingHook::dispatch(['sad']);
            $this->assertTrue(false);
        }catch(ParameterNotFoundException $e){
            $this->assertTrue(true);
        }
    }
}
