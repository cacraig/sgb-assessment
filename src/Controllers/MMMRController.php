<?php

namespace api\Controllers;

use mmmr\Statistics as stats;

class MMMRController 
{
    /**
    * API for calculating Mean, Median, Mode, and Range.
    * @param  array $numbers Array of Numbers.
    * @return array
    */
    public static function MMMRapi(array $numbers)
    {
        $mmmr = new stats();
        // Throw Exception if numbers index is not found, and data is improperly formatted.
        if(!isset($numbers['numbers']) && !empty($numbers))
        {
            throw new \Exception("Invalid Input.");
        }

        // Allow for multiple kinds of inputs.
        // Either a nested array of 
        // array( 'numbers' => [12,3,4,56,44,77,77])
        //   OR
        // array(12,3,4,56,44,77,77)
        if(isset($numbers['numbers']))
        {
            $numbers = $numbers['numbers'];
        }

        $mean   = $mmmr::Mean($numbers);
        $median = $mmmr::Median($numbers);
        $mode   = $mmmr::Mode($numbers);
        $range  = $mmmr::Range($numbers);

        // make output, replace nulls with empty strings.
        $output = array(
            'mean'   => is_null($mean)   ? "" : $mean,
            'median' => is_null($median) ? "" : $median,
            'mode'   => is_null($mode)   ? "" : $mode,
            'range'  => is_null($range)  ? "" : $range
        );

        return $output;

    }


}