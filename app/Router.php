<?php
namespace MeuMicroframework;
use MeuMicroframework\DependencyInjection\Container;

class Router extends Container{

    private $routes;

    public function method(){
        return isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
    }

    public function uri()
    {
        return isset($_SERVER['REQUEST_URI']) ? str_replace('index.php/', '', $_SERVER['REQUEST_URI']) : '';
    }

    public function on($method, $path, $callback, $middleware = null){
        $method = strtolower($method);

        if(!isset($this->routes[$method])){
            $this->routes[$method] = [];
        }
        $uri = substr($path, 0, 1) == '/' ? $path : '/' . $path;
        $route = '/^' . str_replace('/', '\/', $uri) . '$/';

        if($middleware != null){
            $this->register($middleware, $middleware);
            $instance = $this->get($middleware);
            if(!$instance->handle()){
                $callback = [Helper\Exception::class, "forbidden"];
            }
        }
        $this->routes[$method][$route] = $callback;



        return $this;
    }

    public function run($method, $uri)
    {
        $method = strtolower($method);
        if (!isset($this->routes[$method])) {
            header("Status: 404 Not Found");
            return '404';
        }
        $queryString = null;
        if(str_contains($uri, '?')){
            $uriQuery = explode('?', $uri);
            $uri = $uriQuery[0];
            $queryString = $uriQuery[1];
        }
        foreach ($this->routes[$method] as $route => $callback) {
            $id = explode('/', $uri);
            $uriParam = end($id);
            if (str_contains($route, '{id}') && is_numeric($uriParam)) {
                $route = str_replace('{id}', $uriParam, $route);
            }
            if (preg_match($route, $uri, $parameters)) {
                array_shift($parameters);
                $parameters = ['id' => $uriParam, 'queryString' => $queryString, 'body' => json_decode(file_get_contents('php://input'), true)];
                if (is_array($callback)) {
                    $controller = $callback[0];
                    $method = $callback[1];
                    $this->register($controller, $controller);
                    $instance = $this->get($controller);
                    return $instance->$method($parameters);
                } else {
                    return call_user_func_array($callback, $parameters);
                }
            }
        }
        header("Status: 404 Not Found");
        return null;
    }
}