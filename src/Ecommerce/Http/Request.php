<?php
declare(strict_types=1);

namespace Ecommerce\Http;


use Exception;

class Request
{
    private array $methods = ['PUT', 'DELETE', 'POST'];

    private array $headers;

    private array $cookies;

    private array $contents;

    private array $sessions;

    private array $servers;

    private array $queries;

    public function __construct()
    {
        $this->headers = getallheaders();
        $this->cookies = $_COOKIE;
        $this->sessions = $_SESSION;
        $this->servers = $_SERVER;
        $this->queries = $_GET;
        $this->contents = $this->loadContent();
    }

    private function loadContent(): array
    {
        $method = $this->getMethod();
        if (in_array($method, $this->methods)) {
            try {
                if ($method === 'POST' && !empty($_POST)) {
                    return $_POST;
                }
                return json_decode(file_get_contents('php://input'));
            } catch (Exception $e) {

            }
        }
        return [];
    }

    private function getMethod()
    {
        return $this->getServer('REQUEST_METHOD', 'GET');
    }

    /**
     * @param string $name
     * @param $default
     * @return string
     */
    public function getServer(string $name, $default): string
    {
        return isset($this->servers[$name]) ? $this->servers[$name] : $default;
    }

    public function getContent(string $name, $default): string
    {
        if (!empty($this->contents)) {
            return isset($this->contents[$name]) ? $this->contents[$name] : $default;
        }
        return isset($this->queries[$name]) ? $this->queries[$name] : $default;
    }
}