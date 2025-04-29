<?php

namespace App\Config;

use Dotenv\Dotenv;

class Env {
	public static function init() {
		$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
		$dotenv->load();
	}

	public static function get(string $key) : string {
		if (empty($key)) {
			throw new \Exception("Environment variable key cannot be empty.");
		}

    	$env = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

		if (!$env) {
			throw new \Exception("Environment variable {$key} not found.");
		}

		return $env;
	}
};

?>
