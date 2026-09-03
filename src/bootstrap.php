<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/src/helpers.php';
require BASE_PATH . '/src/database.php';
require BASE_PATH . '/src/csrf.php';
require BASE_PATH . '/src/validation.php';
require BASE_PATH . '/src/users.php';
require BASE_PATH . '/src/auth.php';

$appSettings = config('app');

if (!empty($appSettings['debug'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

start_secure_session();
