<?php
/**
 * Application Bootstrap
 *
 * This application is using PHPAlchemy Web Framework
 */

include __DIR__ . '/../autoload.php';

$app = new Alchemy\Application();
$app->setAppDir(realpath(__DIR__.'/../'));
$app->init();

// Registering a event subscriber
$app['dispatcher']->addSubscriber(new Sandbox\Application\EventListener\BeforeResponse());

//$app['dispatcher']->addSubscriber(new Sandbox\Event\FilterRequestListener());
//$app->register(new Sandbox\Application\Service\SampleServiceProvider());

try {
	$app->run();
} catch (Exception $e) {
	echo $e->getMessage();
}

