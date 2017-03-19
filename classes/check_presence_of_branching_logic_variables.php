<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/9/17
 * Time: 11:38 AM
 */
class check_presence_of_branching_logic_variables
{

    //TODO: Check for  checkboxes automatic extra variables

    public static function getBranchingLogicFields($DataDictionary){
        $var= array();
        // Loop through each field and do something with each
        foreach ($DataDictionary as $field_name=>$field_attributes){
            // Do something with this field if it is a checkbox field
            if (strlen(trim($field_attributes['branching_logic']))>0 ) {
                $FormName = $field_attributes['form_name'];
                $FieldName = $field_attributes['field_name'];
                $BranchingLogic = $field_attributes['branching_logic'];
                array_push( $var, Array($FormName,$FieldName,$BranchingLogic));
            }
        }
        return $var;
    }


    public static function ExtractBranchingLogicVariables($array){

        $branching_logic_array=array();
        $re = '/\[(.*?)\]/';
        $longitudinal=REDCap::isLongitudinal();
        $events = REDCap::getEventNames(true, true);
        foreach ($array as $item){
            preg_match_all($re, trim($item[2]), $matches);
            //array_push($branching_logic_array,$matches[1]);
            //$branching_logic_array=array_merge($branching_logic_array,$matches[1]);
            foreach ($matches[1] as $item2){
                if ($longitudinal){

                        //do not remove if the Event name is also used as a Variable name.
                    if (!in_array($item2,self::VariableNamesWithTheSameNameThanAnEventName())){
                        //if the variable name name is in the list of events then is removed from the list of problems
                        if(!in_array($item2,$events)){
                            array_push( $branching_logic_array, Array($item[0],$item[1],$item2 ));
                        }
                    }
                 //if the project is not longitudinal just add all the variables
                }else{
                    array_push( $branching_logic_array, Array($item[0],$item[1],$item2 ));
                }
            }

        }




        return array_map("unserialize", array_unique(array_map("serialize", $branching_logic_array)));
    }



//TODO: Create an extra Validation Check Array  with the variable names that also are Event names...
    public static function VariableNamesWithTheSameNameThanAnEventName(){
        // Check if project is longitudinal
        $var = Array();
        if (REDCap::isLongitudinal()){
            $fields = REDCap::getFieldNames();
            $events = REDCap::getEventNames(true, true);
             $var= array_intersect($events,$fields);
        }
        return $var;
    }

    //transform a checkbox option from triple underscore  ___ to parenthesis () presentation
    public static function TransformCheckBoxField($field___format){

        //$number = substr(trim($field___format), -1);
        $number = substr(trim($field___format), strpos($field___format, "___") + 3);
        //echo $number;
        $underscore="___".$number;
        $parenthesis="(".$number.")";
        $parenthesis_format = str_replace($underscore,$parenthesis, $field___format);


        return $parenthesis_format;
    }



    //adding extra Checkbox variables to the list of variables of the project
    public static function AddCheckBoxes($fields){

        $var =Array();

        foreach ($fields as $field_name){
            if (REDCap::getFieldType($field_name) == 'checkbox') {


                $checkbox_variable_array= REDCap::getExportFieldNames($field_name);
                    foreach ($checkbox_variable_array[$field_name] as $checkbox___format){
                        $checkbox_field= self::TransformCheckBoxField($checkbox___format);
                        array_push( $var, $checkbox_field);

                    }
            } else {
                        array_push( $var, $field_name);
              }
        }
        return $var;
    }


    public static function CheckIfBranchingLogicVariablesExist($DataDictionary){


        $var= array();
        $branching_fields=self::getBranchingLogicFields($DataDictionary);
        $BranchingLogicArray=self::ExtractBranchingLogicVariables($branching_fields);
        $fields = REDCap::getFieldNames();

         $fields= self::AddCheckBoxes($fields);//adding the extra Checkbox variables
        foreach ($BranchingLogicArray as $variable){
             if(!in_array($variable[2],$fields)){

                 $link_path=APP_PATH_WEBROOT.'Design/online_designer.php?pid='.$_GET['pid'].'&page='.$variable[0].'&field='.$variable[1].'&branching=1';
                 $link_to_edit='<a href='.$link_path.' target="_blank" ><img src='.APP_PATH_IMAGES.'arrow_branch_side.png></a>';

                 array_push( $var, Array(REDCap::getInstrumentNames($variable[0]),$variable[1],$variable[2],$link_to_edit));
             }
        }


        return $var;
     }







}