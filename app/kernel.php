<?php

use function DI\get;
use function DI\object;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(BASE.'/.env');

$config = [];
$files = glob(sprintf(CONFIG.'{{,*.}global,{,*.}%s}.php', getenv('APP_ENV') ? : 'production'), GLOB_BRACE);

foreach ($files as $file) {
    $config = array_merge($config, include $file);
}

$config = new ArrayObject($config, ArrayObject::ARRAY_AS_PROPS);

return [

    // Config
    'config' => $config,

    // Database
    \Simply\Database\Connector::class => object()->constructor(
        $config->db_host,
        $config->db_port,
        $config->db_name,
        $config->db_user,
        $config->db_pass,
        $config->db_options
    ),
    'db' => get(\Simply\Database\Connector::class),

];