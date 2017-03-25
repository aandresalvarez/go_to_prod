<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/21/17
 * Time: 6:28 PM
 */
class check_my_first_instrument_presence
{
//todo: check if still exist a form named :: My First Instrument


public static function IsMyFirstInstrument ( ){

// We have our unique instrument name
    $unique_name = 'my_first_instrument';

// Get the label of our instrument
    $instrument_label = REDCap::getInstrumentNames($unique_name);


    return  $instrument_label ? true  : false;



}


}