<?php

namespace App\Main;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use Respect\Validation\Validator;

class LoginController extends Controller
{
    public function loginUser(Request $request, Response $response)
    {

        try {
           /* $validation = $this->validator->validate($request, [
                'email' => Validator::notEmpty(),
                'password' => Validator::notEmpty()
            ]);

            if($validation->failed()){
                return $response->withRedirect($this->router->pathFor('home'));
            }*/

            $email = $request->getParam('email');
            $pass = $request->getParam('password');

            /*$sth = $this->db->prepare("SELECT * FROM users");
            $sth->execute();
            $todos = $sth->fetchAll();
            //$users = User::find(1);
            $users = User::all();
            return $this->response->withJson($users);*/
            $user = User::where('email', $email)->first();
            if(password_verify($pass, $user->password)){
                echo 'yes';
                $_SESSION['user']['id'] = $user->id;
                $_SESSION['user']['level'] = $user->level;
                return $this->renderer->render($response, 'auth/home.phtml');

            }else {
                return $response->withRedirect($this->router->pathFor('home'));
            }
            //var_dump($user->id);die;
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }


    }

    public function logout(Response $response)
    {
        var_dump(__METHOD__);die;
        $_SESSION = [];
        session_destroy();
        return $response->withRedirect($this->router->pathFor('home'));
    }



}