<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', 'HomeController:index')->setName('home');

$app->post('/login', 'LoginController:loginUser')->setName('login');
$app->get('/logout', 'LoginController:logout')->setName('logout');

$app->post('/image', 'FileController:saveFile')->setName('save');

$app->get('/home', function (Request $request, Response $response) {
    return $this->renderer->render($response, 'auth/home.phtml');
});

$app->get('/test', function (Request $request, Response $response) {

    return $this->view->render($response, '/inc/app.twig');
});

