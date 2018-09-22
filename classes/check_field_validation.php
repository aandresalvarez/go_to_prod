<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/17/17
 * Time: 3:18 PM
 */
class check_field_validation
{

    public static function getMinimumOfValidatedFields($DataDictionary,$min_percentage){
       // $var= array();
        $count_validated_fields=0;
        $count_fields=0; // count fields that can be validated
        // Loop through each field and do something with each

        foreach ($DataDictionary as $field_name=>$field_attributes){
            // Do something with this field if it is a checkbox field
            if ($field_attributes['field_type'] == "text"){
                 $count_fields++;
               if (strlen(trim($field_attributes['text_validation_type_or_show_slider_number'])) >0 or strlen(trim($field_attributes['select_choices_or_calculations']))  > 0  ) {
                 $count_validated_fields++;

                }
            }


        }

     return ($count_validated_fields/$count_fields) < $min_percentage ?  Array($count_validated_fields,$count_fields ): false;

    }




}