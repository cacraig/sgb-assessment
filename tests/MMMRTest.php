<?php

require_once 'PHPUnit/Autoload.php';
require_once('../vendor/autoload.php');

use mmmr\Statistics as stats;

class MMMRTest extends PHPUnit_Framework_TestCase
{
    // Nothing needed here for this test.
    function setUp()
    {
      return;
    }

    // Test basic mean.
    function testBasicMean($arr = array(1,2,3,4,5))
    {
      $mean = stats::Mean($arr);
      $this->assertEquals($mean, 3);
    }

    // Test mean to decimal places.
    function testMeanWithRounding($arr = array(1,2,5))
    {
      $mean = stats::Mean($arr);
      $this->assertEquals($mean, 2.667);
    }

    // Test mean with no input.
    function testMeanWithNoInput($arr = array())
    {
      $mean = stats::Mean($arr);
      $this->assertEquals($mean, null);
    }

    // Test mean with wierd input.
    function testMeanWithWierdInput($arr = array(1,2,"abx"))
    {
      try
      {
        $mean = stats::Mean($arr);
      }
      catch(Exception $e)
      {
        $this->assertEquals($e->getMessage(), "Input must contain only numbers");
        return;
      }
      $this->fail('Exception not thrown.');
    }

    // Test Basic Mode.
    function testBasicMode($arr = array(1,1,2,2,3,3,3))
    {
      $mode = stats::Mode($arr);
      $this->assertEquals($mode, 3);
    }
    // Test Complex Mode.
    function testComplexMode($arr = array(1,2,3,4,1010,5,6,6,6,7,7,7,9,9,33,444,1010,1010,1010))
    {
      $mode = stats::Mode($arr);
      $this->assertEquals($mode, 1010);
    }

    // Test Mode with no input.
    function testModeWithNoInput($arr = array())
    {
      $mode = stats::Mode($arr);
      $this->assertEquals($mode, null);
    }

    // Test Mode with wierd input.
    function testModeWithWierdInput($arr = array(1,2,"abx"))
    {
      try
      {
        $mode = stats::Mode($arr);
      }
      catch(Exception $e)
      {
        $this->assertEquals($e->getMessage(), "Input must contain only numbers");
        return;
      }
      $this->fail('Exception not thrown.');
    }

    // Test Basic Range.
    function testBasicRange($arr = array(1,1,2,2,3,3,3))
    {
      $range = stats::Range($arr);
      $this->assertEquals($range, 2);
    }
    // Test Complex Range.
    function testComplexRange($arr = array(1,2,3,4,5,6,6,6,7,7,7,9,1010,1010,1010,1010,9,33,444))
    {
      $range = stats::Range($arr);
      $this->assertEquals($range, 1009);
    }

    // Test Range with no input.
    function testRangeWithNoInput($arr = array())
    {
      $range = stats::Range($arr);
      $this->assertEquals($range, null);
    }

    // Test Range with wierd input.
    function testRangeWithWierdInput($arr = array(1,2,"abx"))
    {
      try
      {
        $range = stats::Range($arr);
      }
      catch(Exception $e)
      {
        $this->assertEquals($e->getMessage(), "Input must contain only numbers");
        return;
      }
      $this->fail('Exception not thrown.');
    }

    // Test Basic Median.
    function testBasicMedian($arr = array(1,1,2,2,3,3,3))
    {
      $median = stats::Median($arr);
      $this->assertEquals($median, 2);
    }
    // Test Complex Median.
    function testComplexMedian($arr = array(1,2,1010,3,4,5,6,6,6,7,7,1010,1010,1010,7,9,9,33,444))
    {
      $median = stats::Median($arr);
      $this->assertEquals($median, 7);
    }

    // Test Median with no input.
    function testMedianWithNoInput($arr = array())
    {
      $median = stats::Median($arr);
      $this->assertEquals($median, null);
    }

    // Test Median with wierd input.
    function testMedianWithWierdInput($arr = array(1,2,"abx"))
    {
      try
      {
        $median = stats::Median($arr);
      }
      catch(Exception $e)
      {
        $this->assertEquals($e->getMessage(), "Input must contain only numbers");
        return;
      }
      $this->fail('Exception not thrown.');
    }
}