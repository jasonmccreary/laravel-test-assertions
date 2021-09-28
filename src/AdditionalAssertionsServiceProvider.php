<?php

namespace JMac\Testing;

use Illuminate\Support\ServiceProvider;
use JMac\Testing\Traits\AdditionalAssertions;

class AdditionalAssertionsServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (!\Illuminate\Testing\TestResponse::hasMacro('assertJsonTypedStructure')) {
            \Illuminate\Testing\TestResponse::macro('assertJsonTypedStructure', function (array $structure) {
                AdditionalAssertions::assertArrayStructure($structure, $this->json());

                return $this;
            });
        }
    }
}


