<?php
namespace Framework;

class Renderer
{
    const DEFAULT_NAMESPACE= '__MAIN';

    private $paths= [];

    /**
     * Variable that all views can access
     * @var array
     */
    private $globals= [];

    /**
     * Add a path to load the views
     * @param string $namespace
     * @param string|null $path
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE]= $namespace;
        } else {
            $this->paths[$namespace]= $path;
        }
    }

    /**
     * Render the view with additional optional parameters
     * @param string $view
     * @param array $params
     */
    public function render(string $view, array $params = []): string
    {
        if ($this->hasNamespace($view)) {
            $path= $this->replaceNamespace($view);
            $path .= '.php';
        } else {
            $path= $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
        ob_start();
        $renderer= $this;
        extract($this->globals);
        extract($params);
        require($path);
        return ob_get_clean();
    }

    /**
     * Add global variables to all views
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key, mixed $value): void
    {
        $this->globals[$key]= $value;
    }

    private function hasNamespace(string $view): bool
    {
        return $view[0]=== '@';
    }

    private function getNamespace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') - 1);
    }

    private function replaceNamespace(string $view): string
    {
        $namespace= $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}
