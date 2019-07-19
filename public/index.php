<?php
if (PHP_SAPI === 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}
if (!defined('APPLICATION_ENV') && PHP_SAPI !== 'cli') {
    if ('localhost' === $_SERVER['HTTP_HOST']) {
        define('APPLICATION_ENV', 'development');
    } else {
        define('APPLICATION_ENV', 'production');
    }
}
require __DIR__ . '/../vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();
session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();


// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
try{
    $capsule = new \Illuminate\Database\Capsule\Manager();
    $capsule->addConnection($container->get('settings')['orm']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    $container['orm'] = function($container) use ($capsule){
        return $capsule;
    };

    $container['db'] = function ($container) {
        $settings = $container->get('settings')['db'];
        $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
            $settings['user'], $settings['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    };
    $container['view'] = function ($container) {
        $view = new \Slim\Views\Twig(__DIR__.'/../templates', [
            'cache' => false
        ]);
        $view->addExtension(new \Slim\Views\TwigExtension(
            $container->router,
            $container->request->getUri()
        ));
        return $view;
    };
    $container['HomeController'] = function ($container) {
        return new App\Main\HomeController($container);
    };
    $container['LoginController'] = function ($container) {
        return new App\Main\LoginController($container);
    };
    $container['FileController'] = function ($container) {
        return new App\Main\FileController($container);
    };
    $container['validator'] = function ($container) {
        return new App\Main\Validator();
    };
    $app->add(new App\Main\ValidationErrorsMiddleware($container));
    $app->run();

} catch (Throwable $e){
    echo $e->getMessage(),$e->getFile(),$e->getLine();
}

