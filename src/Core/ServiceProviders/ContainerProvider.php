<?php

namespace Core\ServiceProviders;

use Pimple\Psr11\Container;

class ContainerProvider
{

	private static Container $container;

	/**
	 * Set the DI Continaer
	 * @param \Pimple\Psr11\Container $container
	 * @return void
	 */
	public static function setcontainer(Container $container): void
	{
		self::$container = $container;
	}

	/**
	 * returns the DI container
	 * @return \Pimple\Psr11\Container
	 */
	public static function getContainer(): Container
	{
		return self::$container;
	}

	/**
	 * Get specified service from DI container
	 * @param string $service
	 * @return \Pimple\Psr11\Container
	 */
	public static function getService(string $service): mixed
	{
		return self::$container->get($service);
	}
}
