<?php
namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    private $modules= [];

    private $router;

    /**
     * App constructor
     * @param string[] $modules List of the modules to load.
     */
    public function __construct(?array $modules = [], array $dependencies = [])
    {
        $this->router= new Router();
        if (array_key_exists('renderer', $dependencies)) {
            $dependencies['renderer']->addGlobal('router', $this->router);
        }
        foreach ($modules as $module) {
            $this->modules= new $module($this->router, $dependencies['renderer']);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri= $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === "/") {
            $response= new Response();
            $response= $response->withStatus(301);
            $response= $response->withHeader('Location', substr($uri, 0, -1));
            return $response;
        }
        $route= $this->router->match($request);
        if (is_null($route)) {
            return new Response(404, [], '<h1>404</h1>');
        }
        $params= $route->getParams();
        $request= array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $response= call_user_func_array($route->getCallback(), [$request]);
        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception("Unknown response format, not a string nor a ResponseInterface");
        }
    }
}
