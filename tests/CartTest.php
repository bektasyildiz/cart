<?php

namespace Bektas\Cart\Tests;

use Bektas\Cart\Facades\Cart;
use Bektas\Cart\ServiceProvider;
use Orchestra\Testbench\TestCase;

class CartTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'cart' => Cart::class,
        ];
    }

    public function testExample()
    {
        assertEquals(1, 1);
    }
}
