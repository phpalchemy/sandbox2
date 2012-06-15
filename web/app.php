<?php
/**
 * Application Bootstrap
 */

ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
$t = microtime(true);
$m = memory_get_usage(true);

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
die;
$archivos_incluidos = get_included_files();
echo '<br>';
foreach ($archivos_incluidos as $i=>$nombre_archivo) {
    echo "$i.- $nombre_archivo<br/>";
}

echo '<br/>----<br/>';
echo 'Process time: ' . round((microtime(true)-$t) * 1000, 2) . ' ms' . "<br/>";
echo 'Memory usage: ' . (memory_get_usage(true)-$m)/(1024*1024) . ' Mb';

function pr($v){echo '<pre>'; print_r($v);echo '</pre>';}