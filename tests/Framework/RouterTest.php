<?php
namespace Tests\Framework;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function setUp()
    {
        $this->router= new Router();
    }

    public function testGetMethod()
    {
        $request= new Request('GET', '/blog');
        $this->router->get('/blog', function () {
            return 'hello';
        }, 'blog');
        $route= $this->router->match($request);
        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
    }
    
    public function testGetMethodIfUrlDoesNotExist()
    {
        $request= new Request('GET', '/blog');
        $this->router->get('/azaz', function () {
            return 'hello';
        }, 'blog');
        $route= $this->router->match($request);
        $this->assertEquals(null, $route);
    }
    
    public function testGetMethodWithParams()
    {
        $request= new Request('GET', '/blog/my-slug-8');$this->router->get('/blog', function () {
            return 'azaz';
        }, 'blog');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $route= $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
        $this->assertEquals(['slug'=> 'my-slug', 'id'=> '8'], $route->getParams);
    }
}
