<?php

namespace Tests;

use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase;

class AssertRouteUsesFormRequestTest extends TestCase
{
    /** @test */
    public function it_tests()
    {
        Route::get('/', 'Dummy\DummyController@test');
        $this->get('/')->assertSee('test response');
    }
}

