# Laravel Test Assertions
A set of helpful assertions when testing Laravel applications.

## Requirements
Your application must be running the latest LTS version (5.5) or higher and using [Laravel's testing harness](https://laravel.com/docs/testing).

## Installation
You may install these assertions with Composer by running:

```sh
composer require --dev jasonmccreary/laravel-test-assertions
```

Afterwards, add the trait to your base `TestCase` class:

```php
<?php
namespace Tests;

use JMac\Testing\Traits\HttpTestAssertions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, HttpTestAssertions;
}
```

## Assertions
This package adds several assertions helpful when writing [Http Tests](https://laravel.com/docs/5.8/http-tests).

```
php
assertActionUsesFormRequest(string $controller, string $method, string $form_request)
```

Verifies the _action_ for a given controller performs validation using the given form request.


## Matchers
```
php
LaravelMatchers::isModel(Model $model = null)
```
Matches an argument _is_ the same as `$model`. When called without `$model`, will match any argument of type `Illuminate\Database\Eloquent\Model`.

```
php
LaravelMatchers::isCollection(Collection $collection = null)
```
Matches an argument _equals_ `$collection`. When called without `$collection`, will match any argument of type `Illuminate\Support\Collection`.

```
php
LaravelMatchers::isEloquentCollection(Collection $collection = null)
```
Matches an argument _equals_ `$collection`. When called without `$collection`, will match any argument of type `\Illuminate\Database\Eloquent\Collection`.
