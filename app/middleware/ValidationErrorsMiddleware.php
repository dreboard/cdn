<?php

namespace App\Main;


class ValidationErrorsMiddleware extends Middleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Create callable for ValidationErrorsMiddleware.
     *
     * Attach all errors to the view
     * @param $request
     * @param $response
     * @param $next
     * @return mixed
     */
    public function __invoke($request, $response, $next)
    {

        //$this->container->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
        unset($_SESSION['errors']);
        $response = $next($request, $response);
        return $response;
    }
}