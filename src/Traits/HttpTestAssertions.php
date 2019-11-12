<?php

namespace JMac\Testing\Traits;

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Assert;

trait HttpTestAssertions
{
    public function assertRouteUsesFormRequest(string $routeName, string $formRequest) {
		$controllerAction = collect(Route::getRoutes())->filter(function (\Illuminate\Routing\Route $route) use ($routeName) {
			return $route->getName() == $routeName;
		})->pluck('action.controller');

		Assert::assertNotEmpty($controllerAction, "{$routeName} is not defined within the router.");

		Assert::assertCount(1, $controllerAction, "{$routeName} returns multiple routes.");

		$controllerAction = $controllerAction->first();

		list($controller, $method) = explode('@', $controllerAction);

		$this->assertActionUsesFormRequest($controller, $method, $formRequest);
	}
    
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
}
