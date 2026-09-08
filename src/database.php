<?php

declare(strict_types=1);

function config(string $section): array
{
    static $config = null;

    if ($config === null) {
        $file = BASE_PATH . '/config/config.php';

        if (!is_file($file)) {
            exit('Missing config/config.php — copy config/config.example.php and fill it in.');
        }

        $config = require $file;
    }

    return $config[$section] ?? [];
}

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $settings = config('db');

    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $settings['host'],
        $settings['port'],
        $settings['name'],
        $settings['charset']
    );

    try {
        $pdo = new PDO($dsn, $settings['user'], $settings['pass'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $exception) {
        $app = config('app');

        if (!empty($app['debug'])) {
            exit('Database connection failed: ' . $exception->getMessage()
                . ' — check the credentials in config/config.php.');
        }

        http_response_code(503);
        exit('The service is temporarily unavailable.');
    }

    return $pdo;
}
