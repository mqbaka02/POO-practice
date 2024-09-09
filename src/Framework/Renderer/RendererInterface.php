<?php
namespace Framework\Renderer;

interface RendererInterface
{
    /**
     * Add a path to load the views
     * @param string $namespace
     * @param string|null $path
     */
    public function addPath(string $namespace, ?string $path = null): void;

    /**
     * Render the view with additional optional parameters
     * @param string $view
     * @param array $params
     */
    public function render(string $view, array $params = []): string;

    /**
     * Add global variables to all views
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key, mixed $value): void;
}
