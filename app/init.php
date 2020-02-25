<?php
/**
* Init file
*/

# Environtment File Location
$env_file = "./environment.json";
if (!file_exists($env_file)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Environment file doesn\'t exists!';
    exit(1);
}

# Getting app environment contents
$content = file_get_contents($env_file);

# decoding data
$environment = json_decode($content, true);

# Looping env content
foreach ($environment as $key => $value) {
    # Make to uppercase for env key
    # Creating env
    putenv(strtoupper($key)."=".$value);
}

# adapted from codeigniter with modified
switch (getenv("STATUS")) {
    case 'development':
		error_reporting(E_ALL);
        ini_set('display_errors', 1);
		ini_set('log_errors', 1);
		ini_set('display_startup_errors', 1);
	break;

	case 'testing':
	case 'production':
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        ini_set('log_errors', 1);
	break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Something wrong on environment.json file!';
		exit(1);
}

# load files
require_once 'config/config.php';
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Database.php';
