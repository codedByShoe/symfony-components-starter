<?php

use Core\ServiceProviders\ContainerProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;

$routes = new Routing\RouteCollection();

$hello = ContainerProvider::getService('helloService');

$routes->add('index', new Route('/', ['_controller' => 'Controllers\WelcomeController::index']));

$routes->add('test', new Route('/test/{id}', [
	'foo' => 'bar',
	'_controller' => fn (Request $request): Response => render_template($request, ['hello' => $hello])
]));

return $routes;
