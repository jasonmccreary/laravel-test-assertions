<?php

namespace JMac\Testing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JMac\Testing\Matching\Argument;
use JMac\Testing\Matching\Matcher;
use PHPUnit\Framework\Assert;

class LaravelMatchers
{
    public static function isModel(?Model $model = null): Matcher
    {
        if (is_null($model)) {
            return Argument::type(Model::class);
        }

        return Argument::satisfies(function ($argument) use ($model) {
            return $model->is($argument);
        });
    }

    public static function isCollection(?Collection $collection = null): Matcher
    {
        if (is_null($collection)) {
            return Argument::type(Collection::class);
        }

        return Argument::satisfies(function ($argument) use ($collection) {
            Assert::assertEquals($collection, $argument);

            return true;
        });
    }

    public static function isEloquentCollection(?\Illuminate\Database\Eloquent\Collection $collection = null): Matcher
    {
        if (is_null($collection)) {
            return Argument::type(\Illuminate\Database\Eloquent\Collection::class);
        }

        return Argument::satisfies(function ($argument) use ($collection) {
            Assert::assertEquals($collection, $argument);

            return true;
        });
    }
}
