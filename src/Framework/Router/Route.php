<?php
namespace Framework\Router;

/**
 * A class for a matche route
 */
class Route
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var array
     */
    private $params;

    /**
     * @param string $name
     * @param string|callable $callback
     * @param array $params
     */
    public function __construct(string $name, $callback, array $params)
    {
        $this->name= $name;
        $this->callback= $callback;
        $this->params= $params;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Retrieve the url parameters
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
