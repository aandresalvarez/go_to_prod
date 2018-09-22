<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/14/17
 * Time: 10:01 AM
 *
 *
 *
 *  getFormsWithToManyFields($maximum_recommended) Returns array with the forms with more fields than the recommended number
 *
 */





class check_number_of_fields_by_form
{



    public static  function getNumberOfFieldsByForm ($DataDictionary){
        $var = array();
        // Print out the names of all instruments in the project
        $instrument_names = REDCap::getInstrumentNames();
        foreach ($instrument_names as $unique_name=>$label) {

            $count_of_fields=0;
            // Loop through each field and do something with each
            foreach ($DataDictionary as $field_name => $field_attributes) {
                // count the fields using the form name associated to each question in the array
                if ($field_attributes['form_name'] == $unique_name ) {
                    $count_of_fields++;
                }
            }
            //create an array with the count of fields in a form (form as a label).
            array_push($var, Array('name'=>$label,'count'=> $count_of_fields));
        }
        return $var ;
    }


    public static function getFormsWithToManyFields($dd_array,$maximum_recommended){
        $var = array();
        //Call the Data Dictionary
        //$dd_array = REDCap::getDataDictionary('array');
        $array= self::getNumberOfFieldsByForm($dd_array);
        foreach ($array as $item){
            if($item['count']>$maximum_recommended){

                array_push($var,$item);

            }

        }

        return $var;
    }








}