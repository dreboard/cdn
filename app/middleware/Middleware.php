<?php

namespace App\Main;


class Middleware
{

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

}