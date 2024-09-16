<?php
namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    public function setUp(): void
    {
        $this->router= new Router();
    }

    public function testGetMethod()
    {
        $request= new ServerRequest('GET', '/blog');
        $this->router->get('/blog', function () {
            return 'hello';
        }, 'blog');
        $route= $this->router->match($request);
        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
    }
    
    public function testGetMethodIfUrlDoesNotExist()
    {
        $request= new ServerRequest('GET', '/blog');
        $this->router->get('/azaz', function () {
            return 'hello';
        }, 'blog');
        $route= $this->router->match($request);
        $this->assertEquals(null, $route);
    }
    
    public function testGetMethodWithParams()
    {
        $request= new ServerRequest('GET', '/blog/my-slug-8');
        $this->router->get('/blog', function () {
            return 'azaz';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $route= $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
        $this->assertEquals(['slug'=> 'my-slug', 'id'=> '8'], $route->getParams());
        //invalid URL
        $route= $this->router->match(new ServerRequest('GET', '/blog/my_slug-8'));
        $this->assertEquals(null, $route);
    }
    
    public function testGenerateUri()
    {
        $this->router->get('/blog', function () {
            return 'azaz';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $uri= $this->router->generateUri('post.show', ['slug'=> 'my-article', 'id'=> 18]);
        $this->assertEquals('/blog/my-article-18', $uri);
    }
    
    public function testGenerateUriWithParams()
    {
        $this->router->get('/blog', function () {
            return 'azaz';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $uri= $this->router->generateUri(
            'post.show',
            ['slug'=> 'my-article', 'id'=> 18],
            ['p'=> 2]
        );
        $this->assertEquals('/blog/my-article-18?p=2', $uri);
    }
}
