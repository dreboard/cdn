<?php

namespace App\Main;


class Controller
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Get App Container items
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if($this->container->{$property}){
            return $this->container->{$property};
        }
    }

    public function __set($name, $value)
    {
        return false;
    }
}