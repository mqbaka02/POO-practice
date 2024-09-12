<?php
namespace Framework\Renderer;

use Psr\Container\ContainerInterface;

class TwigRendererFactory
{
    public function __invoke(ContainerInterface $container)
    {
        // echo "Invoked";
        // exit();
        return new TwigRenderer($container->get('views.path'));
        // return new \stdClass();
        // return new TwigRenderer();
    }
}
