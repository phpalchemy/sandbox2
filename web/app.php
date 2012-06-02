<?php
/**
 * Application Bootstrap
 */
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
$t = microtime(true);

define('HOME_PATH', realpath(dirname(__FILE__) . '/../') . DIRECTORY_SEPARATOR);

try {
    if (!is_dir(HOME_PATH . 'framework/Iron-G')) {
        throw new Exception("The 'Iron G' framework is not installed!");
    }

    require_once HOME_PATH . 'framework/Iron-G/autoload.php';

    // Create Application Config Object
    $config = new IronG\Config();
    $config->set('app.home_path', HOME_PATH);

    // Create application and run
    $application = new IronG\Application($config);
    $application->run();
}
catch (Exception $e) {
  echo $e->getMessage();
}

echo '<br/>----<br/>';
echo 'Process time: '.round((microtime(true) - $t)*1000, 2) . ' ms';

