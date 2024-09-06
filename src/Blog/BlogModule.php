<?php
namespace App\Blog;

use Framework\Renderer;
use Framework\Router;
use Psr\Http\Message\ServerRequestInterface;

class BlogModule
{
    private $renderer;

    public function __construct(Router $router, Renderer $renderer)
    {
        $this->renderer= $renderer;
        $this->renderer->addPath('blog', __DIR__ . '/views');
        $router->get('/blog', [$this, 'index'], 'blog.index');
        $router->get('/blog/{slug:[a-z\-]+}', [$this, 'show'], 'blog.show');
    }

    public function index(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@blog/index');
        // return '<h1>Welcome</h1>';
    }

    public function show(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@blog/show', [
            'slug'=> $request->getAttribute('slug')
        ]);
        // return "<h1>Post {$request->getAttribute('slug')}</h1>";
    }
}
