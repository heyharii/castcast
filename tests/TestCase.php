<?php

namespace Tests;

use Redis;
use Castcast\User;
use Config;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loginAdmin()
    {
        $user = factory(User::class)->create();
        
        Config::push('castcast.administrators', $user->email);

        $this->actingAs($user);
    }

    public function flushRedis()
    {
        Redis::flushall();
    }
}
