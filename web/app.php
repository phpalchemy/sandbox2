<?php
/**
 * Application Bootstrap
 */
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
$t = microtime(true);

define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../app') . DIRECTORY_SEPARATOR);
define('HOME_PATH', realpath(APPLICATION_PATH . '/../') . DIRECTORY_SEPARATOR);

require_once __DIR__ . '/../framework/Iron-G/IronG/autoload.php';

try {
    // Create Application Config Object
    $config = new IronG\EnvConfig();
    $config->set('HOME_PATH',        HOME_PATH);
    $config->set('APPLICATION_PATH', APPLICATION_PATH);

    // Create application and run
    $application = new IronG\Application($config);
    //$application->bootstrap();

    //$bootstrap = $application->getBootstrap();
    $application->run();
    //sleep(1);
}
catch (Exception $e) {
  echo $e->getMessage();
}

echo '<br/>';
echo microtime(true) - $t . 'seg';;
echo '<br>';
echo (microtime(true) - $t)*1000 . 'ms';
echo '<br>';
echo (microtime(true) - $t)*1000*1000 . 'us';
