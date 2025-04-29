<?php

namespace App\Server;

use App\Config\Env;
use App\DB\Connection;

class Server {
	public static function create() {
		Env::init();
		Connection::init();
	}

	public static function run() {
		
	}
};

?>
