<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/src/helpers.php';
require BASE_PATH . '/src/csrf.php';
require BASE_PATH . '/src/validation.php';

start_secure_session();
