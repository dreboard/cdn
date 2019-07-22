<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
	
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };
	
	// Register component on container
	$container['view'] = function ($c) {
		$view = new \Slim\Views\Twig(__DIR__.'/../templates', [
			'cache' => false //__DIR__.'/../var/cache'
		]);
		$view->getEnvironment()->addGlobal("app_env", $c->get('settings')['app_env']);
		$router = $c->get('router');// Instantiate and add Slim specific extension
		$uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
		$view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
		return $view;
	};	
	
	// FTP
	$container['ftp'] = function ($c) {	
		$ftp_server = $c->get('settings')['ftp']['server'];
		$ftp_user = $c->get('settings')['ftp']['user'];
		$ftp_pass = $c->get('settings')['ftp']['pass'];

		// set up a connection or die
		$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to server"); 
		if (ftp_login($conn_id, $ftp_user, $ftp_pass)) {
			ftp_pasv($conn_id, true);
		} else {
			throw new Exception("Couldn't connect to server");
		}
		return $conn_id;
	};
	// PDO database library
	$container['db'] = function ($c) {
		$settings = $c->get('settings')['db'];
		$pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
			$settings['user'], $settings['pass']);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		return $pdo;
	};
	
	// PDO database library
	$container['pdo'] = function ($c) {
		$settings = $c->get('settings')['db'];
		$pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
			$settings['user'], $settings['pass']);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		return $pdo;
	};

};
