<?php

namespace JMac\Testing\Traits;

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Assert as PHPUnitAssert;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

trait HttpTestAssertions
{
    public function assertRouteUsesFormRequest(string $routeName, string $formRequest)
    {
        $controllerAction = collect(Route::getRoutes())->filter(function (\Illuminate\Routing\Route $route) use ($routeName) {
            return $route->getName() == $routeName;
        })->pluck('action.controller');

        PHPUnitAssert::assertNotEmpty($controllerAction, 'Route "' . $routeName . '" is not defined.');
        PHPUnitAssert::assertCount(1, $controllerAction, 'Route "' . $routeName . '" is defined multiple times, route names should be unique.');

        $controller = $controllerAction->first();
        $method = '__invoke';
        if(strstr($controllerAction->first(), '@')) {
            [$controller, $method] = explode('@', $controllerAction->first());
        }

        $this->assertActionUsesFormRequest($controller, $method, $formRequest);
    }

    public function assertActionUsesFormRequest(string $controller, string $method, string $form_request)
    {
        PHPUnitAssert::assertTrue(is_subclass_of($form_request, 'Illuminate\\Foundation\\Http\\FormRequest'), $form_request . ' is not a type of Form Request');

        try {
            $reflector = new \ReflectionClass($controller);
            $action = $reflector->getMethod($method);
        } catch (\ReflectionException $exception) {
            PHPUnitAssert::fail('Controller action could not be found: ' . $controller . '@' . $method);
        }

        PHPUnitAssert::assertTrue($action->isPublic(), 'Action "' . $method . '" is not public, controller actions must be public.');

        $actual = collect($action->getParameters())->contains(function ($parameter) use ($form_request) {
            return $parameter->getType() instanceof \ReflectionNamedType && $parameter->getType()->getName() === $form_request;
        });

        PHPUnitAssert::assertTrue($actual, 'Action "' . $method . '" does not have validation using the "' . $form_request . '" Form Request.');
    }

    public function assertActionUsesMiddleware($controller, $method, $middleware)
    {
        $router = resolve(\Illuminate\Routing\Router::class);
        $route = $router->getRoutes()->getByAction($controller . '@' . $method);

        PHPUnitAssert::assertNotNull($route, 'Unable to find route for controller action (' . $controller . '@' . $method . ')');

        if (is_array($middleware)) {
            PHPUnitAssert::assertSame([], array_diff($middleware, $route->gatherMiddleware()), 'Controller action does not use middleware (' . implode(', ', $middleware) . ')');
        } else {
            PHPUnitAssert::assertTrue(in_array($middleware, $route->gatherMiddleware()), 'Controller action does not use middleware (' . $middleware . ')');
        }
    }

    public function createFormRequest(string $form_request, array $data = [])
    {
        return $form_request::createFromBase(SymfonyRequest::create(null, 'POST', $data));
    }

    public function assertValidationRules(array $expected, array $actual)
    {
        if (class_exists(\Illuminate\Testing\Assert::class)) {
            \Illuminate\Testing\Assert::assertArraySubset($this->normalizeRules($expected), $this->normalizeRules($actual));
        } else {
            \Illuminate\Foundation\Testing\Assert::assertArraySubset($this->normalizeRules($expected), $this->normalizeRules($actual));
        }
    }

    public function assertExactValidationRules(array $expected, array $actual)
    {
        PHPUnitAssert::assertEquals($this->normalizeRules($expected), $this->normalizeRules($actual));
    }

    public function assertValidationRuleContains($rule, string $class)
    {
        if (is_object($rule)) {
            PHPUnitAssert::assertInstanceOf($rule, $class);

            return;
        }

        $matches = array_filter($this->expandRules($rule), function ($rule) use ($class) {
            return $rule instanceof $class;
        });

        if (empty($matches)) {
            PHPUnitAssert::fail('Failed asserting rule contains ' . $class);
        }
    }

    public function assertEventHasListener($event, $listener)
    {
        $events = [];

        foreach ($this->app->getProviders(EventServiceProvider::class) as $provider) {
            $providerEvents = array_merge_recursive(
                $provider->shouldDiscoverEvents() ? $provider->discoverEvents() : [], $provider->listens()
            );

            $events = array_merge_recursive($events, $providerEvents);
        }

        PHPUnitAssert::assertContains($listener, $events[$event]);
    }

    private function normalizeRules(array $rules)
    {
        return array_map([$this, 'expandRules'], $rules);
    }

    private function expandRules($rule)
    {
        return is_string($rule) ? explode('|', $rule) : $rule;
    }
}
