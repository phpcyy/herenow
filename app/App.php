<?php

class App
{
    public $dispatcher;
    /**
     * @var \Http\Response
     */
    public $response;
    /**
     * @var \Http\Request
     */
    public static $request;

    public static $config;

    public static function getConfig($field = "")
    {
        if ($field) {
            return self::$config[$field];
        }
        return self::$config;
    }

    /**
     * @return \Http\Request
     */
    public static function getRequest()
    {
        return self::$request;
    }

    public function __construct()
    {

        $this->dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
            $routeConfig = include "Http/routes.php";
            foreach ($routeConfig as $method => $routes) {
                foreach ($routes as $uri => $route) {
                    list($controller, $action) = explode("@", $route);
                    $r->addRoute(strtoupper($method), trim($uri, "'"), [
                        "\\Controller\\" . ucwords($controller) . "Controller",
                        $action . "Action"
                    ]);
                }
            }
        });

        static::$config = parse_ini_file("Config/config.ini", true, INI_SCANNER_TYPED);

        static::$request = new \Http\Request();
    }

    /**
     * @throws \Exception\MethodNotAllowedException
     * @throws \Exception\NotFoundException
     * @throws Exception
     */
    public function dispatch()
    {
        $method = strtoupper(self::$request->getMethod());
        $uri = self::$request->getUri();
        $routeInfo = $this->dispatcher->dispatch($method, $uri);
        $this->checkRouteValid($routeInfo);
        $handler = [$routeInfo[1][0], $routeInfo[1][1]];
        $vars = $routeInfo[2];
        $params = $this->getDispatchRule($handler, $vars);
        $this->response = call_user_func_array([new $handler[0], $handler[1]], $params);
        return $this;
    }

    public function checkRouteValid($routeInfo)
    {
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                throw new \Exception\NotFoundException();
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                throw new \Exception\MethodNotAllowedException();
            case FastRoute\Dispatcher::FOUND:
                break;
        }
    }

    public function getDispatchRule($handler, $vars)
    {
        $method = new ReflectionMethod($handler[0], $handler[1]);
        $params = [];
        foreach ($method->getParameters() as $reflectionParameter) {
            $paramName = $reflectionParameter->name;
            if (isset($vars[$paramName])) {
                $params[$paramName] = $vars[$paramName];
            } else if ($reflectionParameter->getClass() && is_subclass_of($reflectionParameter->getClass()->getName(), \Http\Injectable::class)) {
                $params[$paramName] = $this->
                inject($reflectionParameter->getClass()->getName());
            } else if (!$reflectionParameter->isDefaultValueAvailable()) {
                throw new Exception("缺少必须的参数");
            } else {
                $params[$paramName] = $reflectionParameter->getDefaultValue();
            }
        }
        return $params;
    }

    public function inject(string $className)
    {
        switch ($className) {
            case Http\Request::class:
                return self::$request;
            default:
                return null;
        }
    }

    public function response()
    {
        $this->response->send();
        return $this;
    }
}





