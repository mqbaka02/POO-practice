<?php

use Framework\Renderer\RendererInterface;
// use Framework\Renderer\TwigRenderer;
use Framework\Renderer\TwigRendererFactory;
// use Psr\Container\ContainerInterface;

// use function DI\create;
use function DI\factory;

return [
    'views.path'=> dirname(__DIR__) . '/views',
    // RendererInterface::class => function (ContainerInterface $container) {
    //     return new TwigRenderer($container->get('config.view_path'));
    // }
    // RendererInterface::class => create(TwigRenderer::class)->constructor(\DI\get('config.view_path'))
    RendererInterface::class => factory(TwigRendererFactory::class)
];
