<?php

require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$configs = __DIR__ . DIRECTORY_SEPARATOR . 'configs.php';

if (! file_exists($configs)) {
    throw new RuntimeException('Arquivo de configuração para testes não encontrado.');
} else {
    $GLOBALS['configs'] = include_once $configs;
    global $configs;
}