<?php

use Pimple\Container;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing;

$container = new Container();

$container['helloService'] = fn () => 'Hello from the container';

$container['routeMatcher'] = function () {
	$routes = require_once __DIR__ . '/routes.php';
	$context = new Routing\RequestContext();
	return new Routing\Matcher\UrlMatcher($routes, $context);
};
$container['eventDispatcher'] = fn () => require_once __DIR__ . '/events.php';
$container['argumentResolver'] = fn () => new ArgumentResolver();
$container['controllerResolver'] = fn () => new ControllerResolver();

return $container;
