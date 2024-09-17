<?php
namespace Framework\Renderer;

use Twig\Environment;

class TwigRenderer implements RendererInterface
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig= $twig;
    }
    /**
     * Add a path to load the views
     * @param string $namespace
     * @param string|null $path
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        ($this->twig->getLoader())->addPath($path, $namespace);
    }

    /**
     * Render the view with additional optional parameters
     * @param string $view
     * @param array $params
     */
    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . '.twig', $params);
    }

    /**
     * Add global variables to all views
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key, mixed $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
