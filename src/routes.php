<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use \App\Core\DevFtp;

return function (App $app) {
    $container = $app->getContainer();
	
    $app->get('/test', function (Request $request, Response $response) {
		$title = 'Hello World';
		$response = $this->view->render($response, 'test.php', ['title' => $title]);
		return $response;
	});
    $app->get('/blog', function (Request $request, Response $response) {
		$title = 'Hello World';
		$response = $this->view->render($response, 'blog.phtml', ['title' => $title]);
		return $response;
	});
    $app->get('/admin', function (Request $request, Response $response) use ($container) {
		
		if($_SERVER['SERVER_NAME'] === 'localhost'){
			$base = '<base href="http://localhost/_dev-php/cdn-slim/public/" />';
		} else {
			$base = '<base href="http://cdn.dev-php.site/" />';
		}
		
		$ftp = new DevFtp($container);
		$files = $ftp->getFileList();
		return $this->view->render($response, 'admin.html', ['files' => $files, 'base' => $base]);
	});	
    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
	

	
	
	
};
