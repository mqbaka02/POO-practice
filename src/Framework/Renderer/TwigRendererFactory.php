<?php
namespace Framework\Renderer;

use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRendererFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $view_path= $container->get('views.path');
        $loader= new FilesystemLoader($view_path);
        $twig= new Environment($loader);
        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig->addExtension($extension);
            }
        }
        return new TwigRenderer($twig);
    }
}
