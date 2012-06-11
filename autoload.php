<?php
$appIniFile = dirname(__FILE__) . '/application.ini';

if (!file_exists($appIniFile)) {
    throw new Exception("File '$appIniFile' is missing.");
}

$appIniConfig = @parse_ini_file($appIniFile, true);

if (empty($appIniConfig)) {
    throw new Exception("Parse Error: '$appIniFile' has errors.");
}

if (empty($appIniConfig['phpalchemy']['root_dir'])) {
    throw new Exception("Configuration Missing: 'phpalchemy.root_dir' conf. is missing");
}

if (!is_dir($appIniConfig['phpalchemy']['root_dir'])) {
    throw new Exception(
        "Configuration Error: phpalchemy home directory not found on: " .
        "'{$appIniConfig['phpalchemy']['root_dir']}'"
    );
}

if (!file_exists($appIniConfig['phpalchemy']['root_dir'] . '/autoload.php')) {
    throw new Exception(
        "PhpAlchemy File Not Found: Autoloader is missing, maybe phpalchemy " .
        "is not installed property on: '{$appIniConfig['phpalchemy']['root_dir']}'"
    );
}

require_once $appIniConfig['phpalchemy']['root_dir'] . '/autoload.php';

return $appIniConfig;