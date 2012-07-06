<?php
/**
 * Application Bootstrap
 */

ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
$t = microtime(true);
$m = memory_get_usage(true);

//try {
    $conf = include __DIR__ . '/../autoload.php';

    $application = new Alchemy\Application($conf);

    //$application['dispatcher']->addSubscriber(new Sandbox\Event\FilterRequestListener());

    $application->run();
//} catch (Exception $e) {
    //new Alchemy\Exception\Handler($exception);
    //echo '<pre>'.$e->getMessage().'<br/><br/>'.$e->getTraceAsString().'</pre>';
//}
die;
/*
$archivos_incluidos = get_included_files();
echo '<br>';
foreach ($archivos_incluidos as $i=>$nombre_archivo) {
    echo "$i.- $nombre_archivo<br/>";
}
die;*/
echo '<br/>----<br/>';
echo 'Process time: ' . round((microtime(true)-$t) * 1000, 2) . ' ms' . "<br/>";
echo 'Memory usage: ' . (memory_get_usage(true)-$m)/(1024*1024) . ' Mb';

function pr($v){echo '<pre>'; print_r($v);echo '</pre>';}