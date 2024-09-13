<?php
namespace Framework\Actions;

use GuzzleHttp\Psr7\Response;

/**
 * Adds methods for the Router
 * Trait RouterAwareAction
 * @package Framework\Actions
 */
trait RouterAwareAction
{
    /**
     * Send a redirection response
     * @param string $path
     * @param array $params
     * @return Response
     */
    public function redirect(string $path, array $params = []): Response
    {
        
        $redirect_uri= $this->router->generateUri($path, $params);
        return (new Response())
            ->withStatus(301)
            ->withHeader('location', $redirect_uri);
    }
}
