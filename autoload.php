<?php

if (! file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new Exception(sprintf(
        "\n (!) Vendors are missing in this project.\n" .
        "     Please execute the following command:\n" .
        "         \$>curl -s http://getcomposer.org/installer | php\n" .
        "         \$>php composer.phar install"
    ));
    exit();
}

if (! is_dir(__DIR__ . '/vendor/phpalchemy/')) {
    throw new Exception("\n (!) PhpAlchemy Vendor is missing, you need add phpalchemy on composer.json\n");
    exit();
}

if (! file_exists(__DIR__ . '/vendor/phpalchemy/phpalchemy/autoload.php')) {
    throw new Exception(
        "PhpAlchemy File Not Found: Autoloader is missing, maybe phpalchemy is not installed properly."
        );
    exit();
}

set_include_path(__DIR__ . DIRECTORY_SEPARATOR . 'vendor' . PATH_SEPARATOR . get_include_path());

$appIniFile = dirname(__FILE__) . '/application.ini';

if (! file_exists($appIniFile)) {
    throw new Exception("File '$appIniFile' is missing.");
}

require_once 'vendor/autoload.php';
require_once 'phpalchemy/phpalchemy/autoload.php';

