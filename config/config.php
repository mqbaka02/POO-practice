<?php
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router\RouterTwigExtension;
use Framework\Twig\PagerFantaExtension as TwigPagerFantaExtension;
use Framework\Twig\TextExtension;
use Framework\Twig\TimeExtension;
use Psr\Container\ContainerInterface;

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
        get(RouterTwigExtension::class),
        get(TwigPagerFantaExtension::class),
        get(TextExtension::class),
        get(TimeExtension::class)
    ],
    'views.path'=> dirname(__DIR__) . '/views',
    \Framework\Router::class=> create(),
    RendererInterface::class => factory(TwigRendererFactory::class),
    \PDO::class => function (ContainerInterface $c) {
        return new \PDO(
            'mysql:host=' . $c->get('database.host') . ';dbname=' . $c->get('database.name'),
            $c->get('database.username'),
            $c->get('database.password'),
            [
                \PDO::ATTR_DEFAULT_FETCH_MODE=> \PDO::FETCH_OBJ,
                \PDO::ATTR_ERRMODE=> \PDO::ERRMODE_EXCEPTION,
            ]
        );
    }
];
