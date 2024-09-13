<?php
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router\RouterTwigExtension;
use function DI\create;
use function DI\factory;
use function DI\get;

return [
    // 'blog.prefix'=> '/news',
    'database.host'=> 'localhost',
    'database.username'=> 'root',
    'database.password'=> '',
    'database.name'=> 'my_super_site',
    'twig.extensions' => [
        get(RouterTwigExtension::class)
    ],
    'views.path'=> dirname(__DIR__) . '/views',
    \Framework\Router::class=> create(),
    RendererInterface::class => factory(TwigRendererFactory::class)
];
