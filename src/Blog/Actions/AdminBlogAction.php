<?php
namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminBlogAction
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
        $this->renderer= $renderer;
        $this->router= $router;
        $this->postTable= $postTable;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        // var_dump($request->getMethod());
        // die();
        if ($request->getMethod() === 'DELETE') {
            return 'hello';
        }
        if (substr((string)$request->getUri(), -3) === 'new') {
            return $this->create($request);
        }
        if ($request->getAttribute('id')) {
            return $this->edit($request);
        } else {
            return $this->index($request);
        }
    }

    public function index(ServerRequestInterface $request): string
    {
        $params= $request->getQueryParams();
        $items= $this->postTable->findPaginated(12, $params['p'] ?? 1);
        return $this->renderer->render('@blog/admin/index', compact('items'));
    }

    /**
     * @param ServerRequestInterface
     * @return ResponseInterface|string
     */
    public function edit(ServerRequestInterface $request): string|ResponseInterface
    {
        $item= $this->postTable->find($request->getAttribute('id'));

        if ($request->getMethod() === 'POST') {
            $params= $this->getParams($request);
            $params= array_merge($params, [
                'updated_at'=> date('Y-m-d H:i:s')
            ]);
            $this->postTable->update($item->id, $params);
            return $this->redirect('blog.admin.index');
        }
        return $this->renderer->render('@blog/admin/edit', compact('item'));
    }

    /**
     * Creates a new post.
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface|string
     */
    public function create(ServerRequestInterface $request)
    {
        if ($request->getMethod() === 'POST') {
            $params= $this->getParams($request);
            $params= array_merge($params, [
                'updated_at'=> date('Y-m-d H:i:s'),
                'created_at'=> date('Y-m-d H:i:s')
            ]);
            $this->postTable->insert($params);
            return $this->redirect('blog.admin.index');
        }
        return $this->renderer->render('@blog/admin/create');
    }

    private function getParams(ServerRequestInterface $request)
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'content', 'slug']);
        }, ARRAY_FILTER_USE_KEY);
    }
}
