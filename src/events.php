<?php

use Symfony\Component\EventDispatcher\EventDispatcher;

$dispatcher = new EventDispatcher();

$dispatcher->addListener('response', function (Core\ResponseEvent $event) {
	$response = $event->getResponse();
	$response->setContent($response->getContent() . '<br /> After');
});

return $dispatcher;
