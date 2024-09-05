<?php
namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    private $modules= [];

    /**
     * App constructor
     * @param string[] $modules List of the modules to load.
     */
    public function __construct(?array $module = [])
    {
        foreach ($modules as $module) {
            $this->modules= new $module();
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

        if ($uri=== '/blog') {
            return (new Response(200, [], '<h1>Welcome</h1>'));
        }

        return new Response(404, [], '<h1>404</h1>');
    }
}
