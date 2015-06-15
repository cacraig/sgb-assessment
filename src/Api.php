<?php

namespace api;

use utils\Request as Request;
use utils\Route as Route;
use utils\Response as Response;

/**
 * The Api class houses the API functionality. 
 * (1) API Routes are set via Api->setRoute().
 * (2) After routes are set, Api->dispatch() is called
 * (3) dispatch finds a matching request | route (if it exists), and executes the associated callback.
 */
class Api 
{
    /**
     * @var array of Routes of API.
     */
    public $routes;

    /**
     * @var Request current request object.
     */
    private $request;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        // Initialize Request.
        $this->request  = new Request($_SERVER);
        // Initialize Response.
        $this->response = new Response();
    }

    /**
     * Dispatches ONE API request.
     * Limitation: Doesn't handle nested routes like /entity/:id/something/:id2 etc.
     */
    public function dispatch()
    {
        $output = array();
        // Loop through routes. Find relevent route.
        // for route in routes
        // if route == currentRoute
        //   Do Route
        //   Except 500 
        // Otherwise 404

        foreach ($this->routes as $route)
        {
            // Call route function with data (if defined).
            // This can easily be expanded to support GET | PUT | DELETE  etc.
            // For the purpose of this example, we only will use POST.
            if($route->pattern == $this->request->REQUEST_URI && $this->request->method == 'POST')
            {
                // Executes callback function, with POST data.
                try
                {
                    if(empty($this->request->data))
                    {
                        throw new \Exception("No data set in request.");
                    }
                    $output = self::invokeMethod($route->callback, $this->request->data);
                    $output = json_encode(array("results" => $output));
                    $this->response->write($output);
                    $this->end(200);
                }
                catch(\Exception $e)
                {
                    // Do 500 route.
                    // Something went wrong.
                    $errorMessage = array(
                      "code"=> 500, 
                      "message" => $e->getMessage()
                    );
                    $output = json_encode(array("error" => $errorMessage));
                    $this->response->write($output);
                    $this->end(500);
                }

            }
            else 
            {
                // Do 404 route.
                $errorMessage = array(
                  "code"=> 404, 
                  "message" => "Method ".$this->request->method." not available on this endpoint"
                );
                $output = json_encode(array("error" => $errorMessage));
                $this->response->write($output);
                $this->end(404);
                return;
            }
        }
    return;
    }

    /**
     * Sets a route in the API.
     *
     * @param string $pattern
     * @param array $callback
     * @param string $method
     */
    public function setRoute($pattern, $callback, $method)
    {
        $this->routes[] = new Route($pattern, $callback, $method);
        return;
    }

    /**
     * Invokes a method.
     *
     * @param mixed $func Class method
     * @param array $params Class method parameters
     * @return mixed Function results
     */
    public static function invokeMethod($func, array $params = array())
    {
        list($class, $method) = $func;

        $instance = is_object($class);

        return ($instance) ? $class->$method($params) : $class::$method($params);
    }

    /**
     * Ends the request. Sets output, headers, and error code.
     *
     * @param int $code HTTP status code
     */
    public function end($code = 200)
    {
        $this->response
             ->status($code)
             ->write(ob_get_clean())
             ->send();
    }
}