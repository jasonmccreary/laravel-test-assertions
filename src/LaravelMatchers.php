<?php

namespace JMac\Testing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Assert;

class LaravelMatchers
{
    public static function isModel(Model $model = null)
    {
        if (is_null($model)) {
            return \Mockery::type(Model::class);
        }

        return \Mockery::on(function ($argument) use ($model) {
            return $model->is($argument);
        });
    }

    public static function isCollection(Collection $collection = null)
    {
        if (is_null($collection)) {
            return \Mockery::type(Collection::class);
        }

        return \Mockery::on(function ($argument) use ($collection) {
            Assert::assertEquals($collection, $argument);
            return true;
        });
    }

    public static function isEloquentCollection(\Illuminate\Database\Eloquent\Collection $collection = null)
    {
        if (is_null($collection)) {
            return \Mockery::type(\Illuminate\Database\Eloquent\Collection::class);
        }

        return \Mockery::on(function ($argument) use ($collection) {
            Assert::assertEquals($collection, $argument);
            return true;
        });
    }
}
