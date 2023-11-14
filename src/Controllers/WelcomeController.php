<?php

namespace Controllers;

use Core\ServiceProviders\ContainerProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WelcomeController
{
	public function index(Request $request): Response
	{
		$hello = ContainerProvider::getService('helloService');
		return render_template($request, ['hello' => $hello]);
	}
}
