<?php
namespace Tests\Framework;

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Framework\Modules\ErroredModule;
use Tests\Framework\Modules\StringModule;

class AppTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $app= new App([]);
        $request= new ServerRequest('GET', '/some-slug/');
        $response= $app->run($request);
        $this->assertContains('/some-slug', $response->getHeader('Location'));
        $this->assertEquals('301', $response->getStatusCode());
    }

    public function testBlog()
    {
        $app= new App([
            BlogModule::class
        ]);
        $request= new ServerRequest('GET', '/blog');
        $response= $app->run($request);
        $requestSingle= new ServerRequest('GET', '/blog/test-post');
        $responseSingle= $app->run($requestSingle);

        $this->assertContains("<h1>Post test-post</h1>", [(string)( $responseSingle->getBody())]);

        $this->assertContains('<h1>Welcome</h1>', [(string)($response->getBody())]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testThrowExceptionIfNoResponseSent()
    {
        $app= new App([
            ErroredModule::class
        ]);
        $request= new ServerRequest('GET', '/demo');
        $this->expectException(\Exception::class);
        $app->run($request);
    }

    public function testConvertStringToResponse()
    {
        $app= new App([
            StringModule::class
        ]);
        $request= new ServerRequest('GET', '/demo');
        $response= $app->run($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('DEMO', (string)($response->getBody()));
    }

    public function testError404()
    {
        $app= new App([]);
        $request= new ServerRequest('GET', '/azaz');
        $response= $app->run($request);
        $this->assertContains('<h1>404</h1>', [(string)($response->getBody())]);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
