<?php

namespace JMac\Testing;

use Illuminate\Support\ServiceProvider;
use JMac\Testing\Traits\AdditionalAssertions;

class AdditionalAssertionsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $test_response_class = class_exists(\Illuminate\Testing\TestResponse::class)
            ? \Illuminate\Testing\TestResponse::class
            : \Illuminate\Foundation\Testing\TestResponse::class;

        if (!$test_response_class::hasMacro('assertJsonTypedStructure')) {
            $test_response_class::macro('assertJsonTypedStructure', function (array $structure) {
                AdditionalAssertions::assertArrayStructure($structure, $this->json());

                return $this;
            });
        }
    }
}


