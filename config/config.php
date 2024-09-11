<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use Psr\Container\ContainerInterface;

return [
    'config.view_path'=> dirname(__DIR__) . '/views',
    RendererInterface::class => function (ContainerInterface $container) {
        return new TwigRenderer($container->get('config.view_path'));
    }
];
