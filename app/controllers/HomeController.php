<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 3/15/2018
 * Time: 9:41 PM
 */

namespace App\Main;

use App\Models\User;

class HomeController extends Controller
{
    public function __construct($container)
    {
        parent::__construct($container);
    }

    public function index($request, $response)
    {
        //$user = $this->orm->table('users')->find(1);
        //$user = User::where('email', 'dre.board@gmail.com')->first();
        //var_dump($user);die;
        return $this->renderer->render($response, 'index.phtml');
    }

}