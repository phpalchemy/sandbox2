<?php
/**
 * Application Bootstrap
 */

ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
$t = microtime(true);

try {
    $appIniConf = include __DIR__ . '/../autoload.php';
    $appIniConf['app']['root_dir'] = __DIR__ . '/../';

    // Create Application Config Object
    $config = new Alchemy\Config($appIniConf);

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

