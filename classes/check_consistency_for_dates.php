<?php

/**
 * Created by Alvaro Alvarez.
 * User: alvaro1
 * Date: 3/9/17
 * Time: 10:59 AM
 *
 * //	Different date formats (i.e, mix of mdy and ymd) – validate consistently across all dates.

 */
class check_consistency_for_dates
{

    /**
     * @return array
     */
    public static function getDateTypes(){
        $date_types=Array('date_ymd','date_mdy','date_dmy','datetime_dmy','datetime_mdy','datetime_ymd','datetime_seconds_mdy','datetime_seconds_ymd' );
        return $date_types;
    }


    /**
     * @param $DataDictionary
     * @param $Types
     * @return array
     */
    public static function getDateQuestions($DataDictionary, $Types){
        $var= array();
        // Loop through each field and do something with each
        foreach ($DataDictionary as $field_name=>$field_attributes){
            // Do something with this field if it is a checkbox field
            if ($field_attributes['field_type'] == "text" and in_array($field_attributes['text_validation_type_or_show_slider_number'],$Types) ) {
                $FormName = $field_attributes['form_name'];
                $FieldName = $field_attributes['field_name'];
                $DateFormatLong = $field_attributes['text_validation_type_or_show_slider_number'];
                $DateFormatShort= substr($field_attributes['text_validation_type_or_show_slider_number'],-3);
                array_push( $var, Array($FormName,$FieldName,$DateFormatLong,$DateFormatShort));
            }
        }
        return $var;
    }

    /**
     * @param $array
     * @return array
     */
    public static function FindProblems($array){
        $FilteredOut= array();
        foreach ($array as $item1){
            foreach ( $array as $item2){

                if ($item1[3]!=$item2[3] and !in_array($item1,$FilteredOut)){

                    $link_path1=APP_PATH_WEBROOT.'Design/online_designer.php?pid='.$_GET['pid'].'&page='.$item1[0].'&field='.$item1[1] ;
                    $link_path2=APP_PATH_WEBROOT.'Design/online_designer.php?pid='.$_GET['pid'].'&page='.$item2[0].'&field='.$item2[1] ;
                    $link_to_edit1='<a href='.$link_path1.' target="_blank" ><img src='.APP_PATH_IMAGES.'pencil.png></a>';
                    $link_to_edit2='<a href='.$link_path2.' target="_blank" ><img src='.APP_PATH_IMAGES.'pencil.png></a>';


                    array_push($FilteredOut,Array($item1[0],$item1[1],$item1[2],$item1[3],$link_to_edit1),Array($item2[0],$item2[1],$item2[2],$item2[3],$link_to_edit2));
                    break;
                }

            }
            if (!empty($FilteredOut)){

                break;
            }



        }

        return  array_map("unserialize", array_unique(array_map("serialize", $FilteredOut))); //return just the unique values found
    }

    /**
     * @param $DataDictionary
     * @return array
     */
    public static function IsDatesConsistent ($DataDictionary){

        $array=self::getDateQuestions($DataDictionary,self::getDateTypes());
        return self::FindProblems($array);

    }





}