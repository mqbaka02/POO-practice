<?php
namespace Framework\Router;

/**
 * A class for a matche route
 */
class Route
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return "";
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return "";
    }

    /**
     * Retrieve the url parameters
     * @return string[]
     */
    public function getParams(): array
    {
        return [];
    }
}
