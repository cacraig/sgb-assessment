<?php

namespace mmmr;

class Statistics 
{
    // Decimal places to round to -> Precision.
    private static $PRECISION = 3;

    /**
    * Calculates Mean of a set of numbers.
    * @param  array $numbers Array of Numbers.
    * @return Float
    * @throws \Exception If input values are not numeric.
    */
    public static function Mean(array $numbers)
    {
        if(count($numbers) <= 0)
        {
            return null;
        }

        if(!self::containsNumericOnly($numbers))
        {
            throw new \Exception("Input must contain only numbers");
        }

        return round(array_sum($numbers) / count($numbers), self::$PRECISION);
    }

    /**
    * Calculates Meadian of a set of numbers.
    * @param  array $numbers Array of Numbers.
    * @return Float
    * @throws \Exception If input values are not numeric.
    */
    public static function Median(array $numbers)
    {
        $median = null;
        if(count($numbers) <= 0)
        {
            return $median;
        }

        if(!self::containsNumericOnly($numbers))
        {
            throw new \Exception("Input must contain only numbers");
        }

        rsort($numbers);
        $middle = round(count($numbers) / 2);
        $median = $numbers[$middle-1];
        return $median;
    }

    /**
    * Calculates Mode of a set of numbers.
    * @param  array $numbers Array of Numbers.
    * @return Float
    * @throws \Exception If input values are not numeric.
    */
    public static function Mode(array $numbers)
    {
        if(!self::containsNumericOnly($numbers))
        {
            throw new \Exception("Input must contain only numbers");
        }

        $mode = null;
        $v = array_count_values($numbers); 
        arsort($v);
        foreach($v as $k => $v)
        {
            $mode = $k;
            break;
        }
        return $mode;
    }

    /**
    * Calculates Range of a set of numbers.
    * @param  array $numbers Array of Numbers.
    * @return Float
    * @throws \Exception If input values are not numeric.
    */
    public static function Range(array $numbers)
    {
        $range = null;
        if(count($numbers) <= 0)
        {
            return $range;
        }

        if(!self::containsNumericOnly($numbers))
        {
            throw new \Exception("Input must contain only numbers");
        }

        sort($numbers); 
        $sml = $numbers[0]; 
        rsort($numbers); 
        $lrg = $numbers[0];
        $range = $lrg - $sml;
        return round($range, self::$PRECISION);
    }

    /**
    * Performs Mean, Median, Mode, and Range on a set of numbers.
    * @param  array $numbers Array of Numbers.
    * @return array
    * @throws \Exception If input values are not numeric.
    */
    public static function MMMR(array $numbers)
    {
        // Allow for multiple kinds of inputs.
        // Either a nested array of 
        // array( 'numbers' => [12,3,4,56,44,77,77])
        //   OR
        // array(12,3,4,56,44,77,77)
        if(isset($numbers['numbers']))
        {
            $numbers = $numbers['numbers'];
        }

        $mean   = self::Mean($numbers);
        $median = self::Median($numbers);
        $mode   = self::Mode($numbers);
        $range  = self::Range($numbers);

        $output = array(
            'mean'   => $mean,
            'median' => $median,
            'mode'   => $mode,
            'range'  => $range
        );

        return $output;

    }


    /**
    * Scans input array for any non-numeric input.
    * returns false if a non-numeric input is found.
    * @param  array $numbers Array of Numbers.
    * @return boolean
    */
    private static function containsNumericOnly(array $numbers)
    {
        foreach($numbers as $number)
        {
          if(!is_numeric($number))
          {
              return false;
          }
        }
        return true;
    }

}