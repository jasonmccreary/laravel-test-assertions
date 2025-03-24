<?php

namespace JMac\Testing;

use Illuminate\Support\ServiceProvider;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Assert;

class AdditionalAssertionsServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (! \Illuminate\Testing\TestResponse::hasMacro('assertJsonTypedStructure')) {
            \Illuminate\Testing\TestResponse::macro('assertJsonTypedStructure', function (array $structure) {
                AdditionalAssertions::assertArrayStructure($structure, $this->json());

                return $this;
            });
        }

        if (! \Illuminate\Testing\TestResponse::hasMacro('assertViewHasNull')) {
            \Illuminate\Testing\TestResponse::macro('assertViewHasNull', function (string $key) {
                $this->assertViewHas($key, function ($value) use ($key) {
                    Assert::assertNull($value, 'View data ['.$key.'] was not null.');

                    return true;
                });
            });
        }
    }
}
