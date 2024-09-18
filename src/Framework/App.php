<?php
namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    private $modules= [];

    private $router;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * App constructor
     * @param ContainerInterface $container
     * @param array $modules List of the modules to load.
     */
    public function __construct(ContainerInterface $container, ?array $modules = [])
    {
        $this->container= $container;
        foreach ($modules as $module) {
            $this->modules= $container->get($module);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri= $request->getUri()->getPath();
        $parsedBody= $request->getParsedBody();
        // var_dump($request->getParsedBody());
        // die();
        // $request= $request->withMethod('DELETE');
        if (array_key_exists('_method', $parsedBody) && in_array($parsedBody, ['DELETE', 'PUT'])) {
            $request= $request->withMethod($parsedBody['_method']);
        }
        if (!empty($uri) && $uri[-1] === "/") {
            $response= new Response();
            $response= $response->withStatus(301);
            $response= $response->withHeader('Location', substr($uri, 0, -1));
            return $response;
        }
        $route= $this->container->get(Router::class)->match($request);
        if (is_null($route)) {
            return new Response(404, [], '<h1>404</h1>');
        }
        $params= $route->getParams();
        $request= array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $callback= $route->getCallback();
        if (is_string($callback)) {
            $callback= $this->container->get($callback);
        }
        // $response= call_user_func_array($route->getCallback(), [$request]);
        $response= call_user_func_array($callback, [$request]);
        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception("Unknown response format, not a string nor a ResponseInterface");
        }
    }
    
    /**
     * Getter for the container.
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
