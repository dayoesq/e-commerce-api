<?php
declare(strict_types=1);

namespace Ecommerce\Routes;


use Ecommerce\Http\Request;

class Router
{
    public static Request $request;

    public function __construct()
    {
        self::$request = new Request();
    }

    public function get(string $uri, $action): Router
    {

    }

    public function post(string $uri, $action): Router
    {

    }

    public function put(string $uri, $action): Router
    {

    }

    public function delete(string $uri, $action): Router
    {

    }
}