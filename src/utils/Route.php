<?php

namespace utils;

/**
 * The Route class maps an HTTP request method, and pattern to a callback.
 */
class Route
{
    /**
     * @var string URL pattern
     */
    public $pattern;

    /**
     * @var mixed Callback function
     */
    public $callback;

    /**
     * @var HTTP method
     */
    public $method;

    /**
     * Constructor.
     *
     * @param string $pattern URL pattern
     * @param mixed $callback Callback function
     * @param string $method HTTP method
     */
    public function __construct($pattern, $callback, $method)
    {
        $this->pattern = $pattern;
        $this->callback = $callback;
        $this->method = $method;
    }
}