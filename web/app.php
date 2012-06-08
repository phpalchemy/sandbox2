<?php
/**
 * Application Bootstrap
 */

ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
$t = microtime(true);

define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../') . DIRECTORY_SEPARATOR);

try {
    if (!is_dir(APPLICATION_PATH . 'framework/Iron-G')) {
        throw new Exception("The 'Iron G' framework is not installed!");
    }

    require_once APPLICATION_PATH . 'framework/Iron-G/autoload.php';

    // Create Application Config Object
    $config = new IronG\Config();
    $config->setAppPath(APPLICATION_PATH);

    // Create application and run
    $application = new IronG\Application($config);
    $application->run();
}
catch (Exception $e) {
  echo '<pre>'.$e->getMessage().'<br/><br/>'.$e->getTraceAsString().'</pre>';
}

echo '<br/>----<br/>';
echo 'Process time: ' . round((microtime(true) - $t)*1000, 2) . ' ms' . "<br/>";
echo 'Memory usage: ' . memory_usage();

function memory_usage() {
    $mem_usage = memory_get_usage(true);

    if ($mem_usage < 1024)
        return $mem_usage." bytes";
    elseif ($mem_usage < 1048576)
        return round($mem_usage/1024, 2)." kb";
    else
        return round($mem_usage/1048576, 2)." Mb";
}

