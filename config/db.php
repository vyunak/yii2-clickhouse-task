<?php

return [
    'class'                 => 'bashkarev\clickhouse\Connection',
    'dsn'                   => 'host=' . getenv('CLICKHOUSE_DB_HOST') . ';port='. getenv('CLICKHOUSE_DB_PORT') .';database=' . getenv('CLICKHOUSE_DB_NAME'),
    'username'              => getenv('CLICKHOUSE_DB_USER'),
    'password'              => getenv('CLICKHOUSE_DB_PASSWORD'),
    'charset'               => 'utf8',
];