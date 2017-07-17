<?php

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(BASE.'/.env');

$config = [];
$files = glob(sprintf(CONFIG.'{{,*.}global,{,*.}%s}.php', getenv('APP_ENV') ? : 'production'), GLOB_BRACE);

foreach ($files as $file) {
    $config = array_merge($config, include $file);
}

return new ArrayObject($config, ArrayObject::ARRAY_AS_PROPS);