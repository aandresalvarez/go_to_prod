<?php

/**
 * Created by Alvaro Alvarez.
 * User: alvaro1
 * Date: 3/7/17
 * Time: 5:20 PM
 */
class check_identifiers
{


    /**
     * @param $DataDictionary
     * @return bool - True if there is at least one variable set as Identifier
     */
public static function AnyIdentifier($DataDictionary){

        // Loop through each field and check if is a Identifier
        foreach ($DataDictionary as $field_name=>$field_attributes){
            if ($field_attributes['identifier'] == "y" ) {
                return true;
            }
        }

        return false;
    }


}