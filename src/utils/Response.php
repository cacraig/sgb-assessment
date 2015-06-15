<?php

namespace utils;

/**
 * The Response class represents an HTTP response. The object
 * contains the response headers, HTTP status code, and response
 * body.
 */
class Response
{
    /**
     * @var int HTTP status
     */
    protected $status = 200;

    /**
     * @var array HTTP headers
     */
    protected $headers = array();

    /**
     * @var string HTTP response body
     */
    protected $body;

    /**
     * @var array HTTP status codes
     */
    public static $codes = array(
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        404 => 'Not Found',
        500 => 'Internal Server Error'
    );

    /**
     * Sets the HTTP status of the response.
     *
     * @param int $code HTTP status code.
     * @return object Self reference
     * @throws \Exception If invalid status code
     */
    public function status($code = null)
    {
        if ($code === null) 
        {
            return $this->status;
        }

        if (array_key_exists($code, self::$codes)) 
        {
            $this->status = $code;
        }
        else 
        {
            throw new \Exception('Invalid status code.');
        }

        return $this;
    }

    /**
     * Adds a header to the response.
     *
     * @param string|array $name Header name or array of names and values
     * @param string $value Header value
     * @return object Self reference
     */
    public function header($name, $value = null)
    {
        if (is_array($name)) 
        {
            foreach ($name as $k => $v) 
            {
                $this->headers[$k] = $v;
            }
        }
        else 
        {
            $this->headers[$name] = $value;
        }

        return $this;
    }

    /**
     * Writes content to the response body.
     *
     * @param string $str Response content
     * @return object Self reference
     */
    public function write($str)
    {
        $this->body .= $str;

        return $this;
    }

    /**
     * Clears the response.
     *
     * @return object Self reference
     */
    public function clear() 
    {
        $this->status = 200;
        $this->headers = array();
        $this->body = '';

        return $this;
    }

    /**
     * Sends HTTP headers.
     *
     * @return object Self reference
     */
    public function sendHeaders()
    {
        // Send status code header
        if (strpos(php_sapi_name(), 'cgi') !== false)
        {
            header(
                sprintf(
                    'Status: %d %s',
                    $this->status,
                    self::$codes[$this->status]
                ),
                true
            );
        }
        else 
        {
            header(
                sprintf(
                    '%s %d %s',
                    (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1'),
                    $this->status,
                    self::$codes[$this->status]),
                true,
                $this->status
            );
        }

        // Send other headers
        foreach ($this->headers as $field => $value) 
        {
            if (is_array($value)) 
            {
                foreach ($value as $v) 
                {
                    header($field.': '.$v, false);
                }
            }
            else
            {
                header($field.': '.$value);
            }
        }

        // Send content length
        if (($length = strlen($this->body)) > 0)
        {
            header('Content-Length: '.$length);
        }

        header('Content-Type: application/json');

        return $this;
    }

    /**
     * Sends a HTTP response.
     */
    public function send() 
    {
        if (ob_get_length() > 0)
        {
            ob_end_clean();
        }

        if (!headers_sent())
        {
            $this->sendHeaders();
        }

        exit($this->body);
    }
}

