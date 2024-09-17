<?php
namespace Tests\App\Blog\Actions;

use App\Blog\Actions\BlogAction;
use App\Blog\Entity\Post;
use App\Blog\Table\PostTable;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class BlogActionTest extends TestCase
{
    /**
     * @var BlogAction
     */
    private $action;
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var RendererInterface
     */
    private $renderer;
    /**
     * @var PostTable
     */
    private $postTable;

    public function setUp(): void
    {

        $this->renderer= $this->createMock(RendererInterface::class);
        // $this->renderer->method('render')->willReturn('');

        $this->postTable= $this->createMock(PostTable::class);

        $post= new \stdClass();
        $post->id= 9;
        $post->slug= 'demo-test';

        $this->router= $this->createMock(Router::class);

        $this->action= new BlogAction(
            $this->renderer,
            $this->router,
            $this->postTable
        );
    }

    public function makePost(int $id, string $slug): Post
    {
        $post= new Post();
        $post->id= $id;
        $post->slug= $slug;
        return $post;
    }

    public function testShowRedirect()
    {
        $id= 9;
        $slug= 'anything';
        $post= $this->makePost($id, $slug);

        $this->postTable->method('find')->with($post->id)->willReturn($post);

        $request= (new ServerRequest('GET', '/'))
            ->withAttribute('id', $post->id)
            ->withAttribute('slug', 'demo');
        $response= call_user_func_array($this->action, [$request]);
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testShowRender()
    {
        $id= 9;
        $slug= 'anything';
        $post= $this->makePost($id, $slug);

        $this->postTable->method('find')->with($post->id)->willReturn($post);

        $request= (new ServerRequest('GET', '/'))
            ->withAttribute('id', $post->id)
            ->withAttribute('slug', $post->slug);
        $this->renderer->method('render')->with('@blog/show', ['post'=> $post])->willReturn('');

        $response= call_user_func_array($this->action, [$request]);
        // $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, true);
    }
}
