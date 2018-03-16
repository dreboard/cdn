<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

/*$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
$app->get('/', function (Request $request, Response $response) {
    return $this->renderer->render($response, 'index.phtml');
});
*/
$app->get('/', 'HomeController:index');



$app->get('/home', function (Request $request, Response $response) {
    return $this->renderer->render($response, 'auth/home.phtml');
});

$app->post('/login', function() use ($app) {
    $req = $app->request;
    $user= $req->params('user');
    $pass = $req->params('pass');

    try {
        $query = $app->db->prepare("SELECT user, pass FROM users
                              WHERE user = :user AND pass = :pass
                              LIMIT 1");
        $query->execute(
            array(
                ':user' => $user,
                ':pass' => md5($pass)
            )
        );

        $result = $query->fetch();
    }

    catch (PDOException $e) {
        $this->logger->info("Slim-Skeleton '/' route");
        $app->flash('error', 'db error');
    }


    if ( empty($result) ) {
        $app->flash('error', 'wrong user or pass');
        $app->redirect('/login');
    }

    $app->redirect('/');

});
