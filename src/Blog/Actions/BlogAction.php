<?php
namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var PostTable
     */
    private $postTable;

    use RouterAwareAction;

    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable)
    {
        $this->postTable= $postTable;
        $this->renderer= $renderer;
        $this->router= $router;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($request->getAttribute('id')) {
            return $this->show($request);
        } else {
            return $this->index($request);
        }
    }

    public function index(ServerRequestInterface $request): string
    {
        $params= $request->getQueryParams();
        $posts= $this->postTable->findPaginated(12, $params['p'] ?? 1);
        return $this->renderer->render('@blog/index', compact('posts'));
    }

    /**
     * Displays a single post
     * @param ServerRequestInterface $request
     * @return ResponseInterface|string
     */
    public function show(ServerRequestInterface $request): string|ResponseInterface
    {
        $slug= $request->getAttribute(('slug'));
        $post= $this->postTable->find($request->getAttribute('id'));
        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', [
                'slug'=> $post->slug,
                'id'=> $post->id
            ]);
        }
        return $this->renderer->render('@blog/show', [
            'post' => $post
        ]);
    }
}
