<?php

namespace utils;

/**
 * The Request class represents an HTTP request. Data from
 * all the super globals are stored and accessible via the Request object.
 *
 * The default request properties are:
 *   type - The content type
 *   query - Query string parameters
 *   data - Post parameters
 *   cookies - Cookie parameters
 *   method - HTTP Method.
 */
class Request 
{
    /**
     * @var array Query [GET] string parameters
     */
    public $query;

    /**
     * @var array Post parameters
     */
    public $data;

    /**
     * @var array Cookie parameters
     */
    public $cookies;

    /**
     * @var string Content type
     */
    public $type;

    /**
     * @var string HTTP Method.
     */
    public $method;

    /**
     * Constructor.
     * Initialize request properties.
     * @param array $properties Array of request properties
     */
    public function __construct($properties = array())
    {
        $this->query = $_GET;
        $this->data  = $_POST;
        $this->cookies = $_COOKIE;
        $this->type = self::getVar('CONTENT_TYPE');
        $this->method = self::getMethod();

        // Set all the defined properties
        foreach ($properties as $name => $value) 
        {
            $this->$name = $value;
        }

        // Get the Request body, and decode it.
        $body = $this->getBody();
        if ($body != '')
        {
            $data = json_decode($body, true);
            if ($data != null) 
            {
                $this->data = $data;
            }
        }

    }

    /**
     * Gets the body of the request.
     *
     * @return string Raw HTTP request body
     */
    public static function getBody() 
    {
        static $body;

        if (!is_null($body))
        {
            return $body;
        }

        $method = self::getMethod();

        if ($method == 'POST' || $method == 'PUT' || $method == 'PATCH')
        {
            $body = file_get_contents('php://input');
        }

        return $body;
    }

    /**
     * Gets the request method.
     *
     * @return string
     */
    public static function getMethod() 
    {
        $method = self::getVar('REQUEST_METHOD', 'GET');

        if (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) 
        {
            $method = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];
        }
        elseif (isset($_REQUEST['_method'])) 
        {
            $method = $_REQUEST['_method'];
        }

        return strtoupper($method);
    }

    /**
     * Gets a variable from $_SERVER using $default if not provided.
     *
     * @param string $var Variable name
     * @param string $default Default value to substitute
     * @return string Server variable value
     */
    public static function getVar($var, $default = '') 
    {
        return isset($_SERVER[$var]) ? $_SERVER[$var] : $default;
    }

}