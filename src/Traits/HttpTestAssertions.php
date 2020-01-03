<?php

namespace JMac\Testing\Traits;

use PHPUnit\Framework\Assert;

trait HttpTestAssertions
{
    public function assertActionUsesFormRequest(string $controller, string $method, string $form_request)
    {
        Assert::assertTrue(is_subclass_of($form_request, 'Illuminate\\Foundation\\Http\\FormRequest'), $form_request . ' is not a type of Form Request');

        try {
            $reflector = new \ReflectionClass($controller);
            $action = $reflector->getMethod($method);
        } catch (\ReflectionException $exception) {
            Assert::fail('Controller action could not be found: ' . $controller . '@' . $method);
        }

        Assert::assertTrue($action->isPublic(), 'Action "' . $method . '" is not public, controller actions must be public.');

        $actual = collect($action->getParameters())->contains(function ($parameter) use ($form_request) {
            return $parameter->getType() instanceof \ReflectionNamedType && $parameter->getType()->getName() === $form_request;
        });

        Assert::assertTrue($actual, 'Action "' . $method . '" does not have validation using the "' . $form_request . '" Form Request.');
    }

    public function assertActionUsesMiddleware($controller, $method, $middleware)
    {
        $router = resolve(\Illuminate\Routing\Router::class);
        $route = $router->getRoutes()->getByAction($controller . '@' . $method);

        Assert::assertNotNull($route, 'Unable to find route for controller action (' . $controller . '@' . $method . ')');

        if (is_array($middleware)) {
            Assert::assertSame([], array_diff($middleware, $route->gatherMiddleware()), 'Controller action does not use middleware (' . implode(', ', $middleware) . ')');
        } else {
            Assert::assertTrue(in_array($middleware, $route->gatherMiddleware()), 'Controller action does not use middleware (' . $middleware . ')');
        }
    }
}
