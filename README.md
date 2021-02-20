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

use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, AdditionalAssertions;
}
```

## Assertions
This package adds several assertions helpful when writing [Http Tests](https://laravel.com/docs/http-tests).


```php
assertActionUsesFormRequest(string $controller, string $method, string $form_request)
```

Verifies the _action_ for a given controller performs validation using the given form request.

```php
assertRouteUsesFormRequest(string $routeName, string $formRequest)
```

Verifies that the corresponding action/controller, for a given _route name_ performs the validation using the given form request.


```php
assertActionUsesMiddleware(string $controller, string $method, string|array $middleware)
```

Verifies the _action_ for a given controller uses the given middleware or set of middleware.


```php
assertRouteUsesMiddleware(string $routeName, array $middlewares, bool $exact)
```

Verifies the _route_ for a given route name uses all the given middlewares or only the given set of middlewares.


```php
assertValidationRules(array $expected, array $actual)
```

Verifies the expected subset of validation rules for fields are within a set of validation rules. Rules may be passed as a delimited string or array.


```php
assertExactValidationRules(array $expected, array $actual)
```

Verifies the expected set of validation rules for fields exactly match a set of validation rules. Rules may be passed as a delimited string or array.


```php
assertValidationRuleContains($rule, string $class)
```

Verifies the rule or rules contains an instance of the given [Rule](https://laravel.com/docs/validation#custom-validation-rules) class.

```php
assertNotSoftDeleted(Model $model)
```

Verifies the given model is not _soft deleted_, providing the inverse of [assertSoftDeleted](https://laravel.com/docs/database-testing#available-assertions).

## Matchers
```php
LaravelMatchers::isModel(Model $model = null)
```
Matches an argument _is_ the same as `$model`. When called without `$model`, will match any argument of type `Illuminate\Database\Eloquent\Model`.


```php
LaravelMatchers::isCollection(Collection $collection = null)
```
Matches an argument _equals_ `$collection`. When called without `$collection`, will match any argument of type `Illuminate\Support\Collection`.


```php
LaravelMatchers::isEloquentCollection(Collection $collection = null)
```
Matches an argument _equals_ `$collection`. When called without `$collection`, will match any argument of type `\Illuminate\Database\Eloquent\Collection`.


## Creation Methods
This package also provides methods for quickly creating common objects used within Laravel application to use when testing.


```php
createFormRequest(string $class, array $data = [])
```

Creates an instance of the given [Form Request](https://laravel.com/docs/7.x/validation#form-request-validation) class with the given request data.
