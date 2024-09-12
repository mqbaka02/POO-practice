<?php
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use function DI\factory;

return [
    'views.path'=> dirname(__DIR__) . '/views',
    RendererInterface::class => factory(TwigRendererFactory::class)
];
