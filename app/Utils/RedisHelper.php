<?php

namespace App\Utils;


class RedisHelper
{
    private static $instance;

    public static function getInstance() {
        if (! isset ( self::$instance )) {
            $config = array(
                'scheme' => 'tcp',
                'host'   => env('REDIS_HOST', '127.0.0.1'),
                'port'   => env('REDIS_PORT', '3306'),
            );
            $options = [
                'parameters' => [
                    'password' => env('REDIS_PASSWORD', 'null'),
                    'database' => 0,
                ],
            ];
            self::$instance = new \Predis\Client($config, $options);
        }

        return self::$instance;
    }
}