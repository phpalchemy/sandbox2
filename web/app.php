<?php
/**
 * Application Bootstrap
 *
 * This applaication is using PHPAlchemy Web Framework
 */

$conf = include __DIR__ . '/../autoload.php';
$application = new Alchemy\Application();
$application->init($conf);

//$application['dispatcher']->addSubscriber(new Sandbox\Event\FilterRequestListener());

$application->run();

