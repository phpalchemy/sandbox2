<?php
/**
 * Application Bootstrap
 */

ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
$t = microtime(true);

define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../') . DIRECTORY_SEPARATOR);

try {
    if (!file_exists(APPLICATION_PATH . 'config/application.ini')) {
        throw new Exception("File 'config/application.ini' is missing.");
    }
    
    $config = parse_ini_file(APPLICATION_PATH . 'config/application.ini', true);

    if (!is_dir($config['framework']['home_path'])) {
        throw new Exception("The 'PHP Alchemy' Framework is not installed!");
    }

    require_once $config['framework']['home_path'] . '/autoload.php';

    // Create Application Config Object
    $config = new Alchemy\Config();
    $config->setAppPath(APPLICATION_PATH);

    // Create application and run
    $application = new Alchemy\Application($config);
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

