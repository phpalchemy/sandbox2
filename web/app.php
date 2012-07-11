<?php
/**
 * Application Bootstrap
 */

ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
$t = microtime(true);
$m = memory_get_usage(true);


$conf = include __DIR__ . '/../autoload.php';

$application = new Alchemy\Application($conf);
//$application['dispatcher']->addSubscriber(new Sandbox\Event\FilterRequestListener());

$application->run();

echo '<br/>----<br/>';
echo 'Process time: ' . round((microtime(true)-$t) * 1000, 2) . ' ms' . "<br/>";
echo 'Memory usage: ' . (memory_get_usage(true)-$m)/(1024*1024) . ' Mb';
