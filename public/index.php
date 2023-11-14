<?php

use Core\Framework;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';
// Create the request object from super globals variables thank you symfony
$request = Request::createFromGlobals();
// boot up the framework and pass the request to the handle method so that the proper response can be sent
$response = (new Framework())->boot()->handle($request);
// Send it!
$response->send();
