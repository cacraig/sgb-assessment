<?php

require_once 'PHPUnit/Autoload.php';
require_once('../vendor/autoload.php');

use api\Controllers\MMMRController as mmmr;
use api\Api as api;

class MMMRTest extends PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->api = new api();
        $this->mmmr = new mmmr();
    }

    // Test route setting.
    function testRouteSet()
    {
        $this->api->setRoute('/mmmr', array($this->mmmr,'MMMRapi'), 'POST');
        foreach($this->api->routes as $route)
        {
          if($route->pattern == '/mmmr')
          {
            return;
          }
        }
        $this->fail('Route Setting Test Failed.');
    }

    // Test API request.
    function testSimpleAPI()
    {
        $data   = array("numbers" => array(5,6,8,7,5));

        $output = $this->api->invokeMethod(array($this->mmmr,'MMMRapi'), $data);
        $output = array("results" => $output);

        $this->assertEquals($output, array(
          "results"=> array(
              "mean"=>6.2,
              "median"=>6,
              "mode"=>5,
              "range"=>3
          )
        ));
    }

    // Test API request with improper input.
    // No 'numbers' key defined.
    function testAPIInputFailure()
    {
        $data = array("Foo_bad_input" => array(5,"abs",8,7,5));

        try
        {
            $output = $this->api->invokeMethod(array($this->mmmr,'MMMRapi'), $data);
        }
        catch(Exception $e)
        {
            $this->assertEquals($e->getMessage(), "Invalid Input.");
            return;
        }
        $this->fail('Exception not thrown.');

    }
}