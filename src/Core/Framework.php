<?php

namespace Core;

use Core\ServiceProviders\ContainerProvider;
use Pimple\Psr11\Container as Psr11Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing;


class Framework
{
	public EventDispatcher $dispatcher;
	public ArgumentResolver $argumentResolver;
	public UrlMatcher $matcher;
	public ControllerResolver $controllerResolver;
	public Psr11Container $container;

	public function boot()
	{
		$this->setContainer();
		$this->matcher = ContainerProvider::getService('routeMatcher');
		$this->controllerResolver = ContainerProvider::getService('controllerResolver');
		$this->argumentResolver = ContainerProvider::getService('argumentResolver');
		$this->dispatcher = ContainerProvider::getService('eventDispatcher');
		return $this;
	}

	private function setContainer()
	{

		$container = require_once __DIR__ . '/../dependencies.php';
		$this->container = new Psr11Container($container);
		ContainerProvider::setcontainer($this->container);
	}

	public function handle(Request $request)
	{
		$this->matcher->getContext()->fromRequest($request);
		try {
			$request->attributes->add($this->matcher->match($request->getPathInfo()));
			// handle request events before resolving controller

			$controller = $this->controllerResolver->getcontroller($request);
			$arguments = $this->argumentResolver->getArguments($request, $controller);

			$response = call_user_func_array($controller, $arguments);
		} catch (Routing\Exception\ResourceNotFoundException $exception) {
			$response = new Response('Not Found', 404);
		} catch (\Exception $exception) {
			$response = new Response('An Error Occured: ' . $exception->getMessage(), 500);
		}

		$this->dispatcher->dispatch(new ResponseEvent($response, $request), 'response');

		return $response;
	}
}
