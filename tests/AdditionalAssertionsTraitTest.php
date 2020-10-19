<?php

namespace Tests;

use Illuminate\Support\Facades\Route;
use JMac\Testing\Traits\AdditionalAssertions;
use Orchestra\Testbench\TestCase;

class AdditionalAssertionsTraitTest extends TestCase
{
    use AdditionalAssertions;

    /** @test */
    public function asserting_a_route_uses_a_form_request_returns_as_expected()
    {
        Route::get('/', 'Tests\DummyController@test')->name('test');

        $this->assertRouteUsesFormRequest('test', DummyRequest::class);
    }

    /** @test */
    public function asserting_an_action_uses_a_form_request_returns_as_expected()
    {
        $this->assertActionUsesFormRequest(DummyController::class, 'test', DummyRequest::class);
    }
}

