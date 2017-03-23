<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/17/17
 * Time: 3:18 PM
 */
class check_field_validation
{
//TODO:https://medwiki.stanford.edu/display/redcap/Text+Box+Field+Validation   if the # of fields without validation in less thatn X% (5%)
///// nit validated yet
    public static function getValidationFields($DataDictionary){
        //$var= array();
        $count_validated_fields=0;
        $count_fields=0; // count fields that can be validated
        // Loop through each field and do something with each
        foreach ($DataDictionary as $field_name=>$field_attributes){
            // Do something with this field if it is a checkbox field
            if (strlen(trim($field_attributes['element_type']))=="text"){
                $count_fields++;
               if ((strlen(trim($field_attributes['element_enum'] >0 ))  or strlen(trim($field_attributes['element_validation_type'] > 0))       ) ) {
                 $count_validated_fields++;

                }
            }


        }
    return ($count_validated_fields / $count_fields) < 0.05 ? true : false;
    }




}