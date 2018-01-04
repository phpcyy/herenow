<?php

namespace Http;

class Request implements Injectable
{
    private $post = [];
    private $put = [];
    private $query = [];
    private $method = "";
    private $fields = [];
    private $cookie = [];
    private $uri = "";

    public function __construct()
    {
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->query = $_GET;
        $this->post = $_POST;
        $this->cookie = $_COOKIE;
        parse_str(file_get_contents("php://input"), $this->put);
        if ($this->method === "put" || $this->method === "post") {
            $this->fields = $_GET + $this->{$this->method};
        } else {
            $this->fields = $_GET;
        }
        $uri = $_SERVER['REQUEST_URI'];
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $this->uri = rawurldecode($uri);
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getCookie(string $name)
    {
        return $this->cookie[$name];
    }

    public function getAllFields()
    {
        return $this->fields;
    }

    public function getAllQueries()
    {
        return $this->query;
    }

    public function getQuery(string $name)
    {
        return $this->query[$name];
    }

    public function getField(string $name)
    {
        return $this->fields[$name];
    }

    public function getAllPostFields()
    {
        return $this->post;
    }

    public function getPostField(string $name)
    {
        return $this->post[$name];
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getClientIp()
    {
        $ipKeys = array(
            'HTTP_X_FORWARDED_FOR',
            'HTTP_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_CLUSTER_CLIENT_IP',
            'HTTP_X_CLIENT_IP',
            'HTTP_CLIENT_IP',
            'REMOTE_ADDR'
        );
        $clientIp = '';
        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $clientIp = $_SERVER[$key];
                break;
            }
        }
        return $clientIp;
    }

    public static function inject()
    {
        return \App::class;
    }
}