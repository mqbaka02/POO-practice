<?php
namespace App\Blog;

use App\Blog\Actions\AdminBlogAction;
use App\Blog\Actions\BlogAction;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Container\ContainerInterface;

class BlogModule extends Module
{
    const DEFINITIONS= __DIR__ . '/config.php';

    const MIGRATIONS= __DIR__ . '/db/migrations';

    const SEEDS= __DIR__ . '/db/seeds';

    public function __construct(ContainerInterface $container)
    {
        $container->get(RendererInterface::class)->addPath('blog', __DIR__ . '/views');
        $router= $container->get(Router::class);
        $prefix= $container->get('blog.prefix');
        $router->get($prefix, BlogAction::class, 'blog.index');
        $router->get($prefix . '/{slug:[a-z\-0-9]+}-{id:[0-9]+}', BlogAction::class, 'blog.show');

        if ($container->has('admin.prefix')) {
            $prefix= $container->get('admin.prefix');
            $router->get("$prefix/posts", AdminBlogAction::class, 'admin.blog.index');
            $router->get("$prefix/posts/{id:\d+}", AdminBlogAction::class, 'admin.blog.edit');
            $router->post("$prefix/posts/{id:\d+}", AdminBlogAction::class);
        }
    }
}
