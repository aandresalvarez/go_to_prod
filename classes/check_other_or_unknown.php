<?php
/**
 * Created by Alvaro Alvarez.
 * User: alvaro1
 * Date: 3/7/17
 * Time: 5:20 PM
 */

// Call the REDCap Connect file in the main "redcap" directory
//require_once "../../../redcap_connect.php";
require_once 'utilities.php';
 class check_other_or_unknown {

// Get the data dictionary for the current project in array format
//$dd_array = REDCap::getDataDictionary('array');


//Dictionary of warning words
//public $Words = "Other, Unknown, Don't know/Not sure ,Don't know,Not sure, Not Reported, NA, N/A, uninterpretable, otro, otra, no se, Other please specify, not obtained, missing data, do not know or not sure, refused, no response was entered on form despite affirming that the patient was untestable, no response was entered on form despite affirming that the patient was testable, did not provide answer / not answered, other type, unclear, not gradable, other frequency, sent or stored other, none, no data available, unable to examine ";
//public $Ids= "97,98,99,999,9999,888,8888,-1,777,7777";

//TODO: move the keywords to the language file

//TODO: check mix of numbers and strings  in codes  For example: 1,cat|2, dog| 3, mouse| NA, different animal
    /**
     * @return string
     */
    public static function getKeyWords(){
        $var= "Other, Unknown, Don't know/Not sure ,Don't know,Not sure, Not Reported, NA, N/A, uninterpretable, otro, otra, no se, Other please specify, not obtained, missing data, do not know or not sure, refused, no response was entered on form despite affirming that the patient was untestable, no response was entered on form despite affirming that the patient was testable, did not provide answer / not answered, other type, unclear, not gradable, other frequency, sent or stored other, no data available, unable to examine "; //none??
        return $var;
    }

    /**
     * @return string
     */
    public static function getIDs(){
        $var="97,88,98,99,999,9999,888,8888,-1,777,7777";
        return $var;
    }


    /**
     * @param $DataDictionary
     * @return array
     * //Get dropdown, Checkbox  and Radio buttons from the REDCap Data Dictionary
     */
    public static function getLists($DataDictionary){
        $var= array();
        // Loop through each field and do something with each
		foreach ($DataDictionary as $field_name=>$field_attributes){
    			// Do something with this field if it is a checkbox field
    			if ($field_attributes['field_type'] == "checkbox" || $field_attributes['field_type'] == "radio" || $field_attributes['field_type'] == "dropdown") {
                    $FormName = $field_attributes['form_name'];
                    $FieldName = $field_attributes['field_name'];                      
                    $Choices = $field_attributes['select_choices_or_calculations']; 
                    array_push( $var, Array($FormName,$FieldName,$Choices));
                 }
		}
        return $var;
    }



    /**
     * @param $array
     * @return array
     * //In: Array $FormName,$FieldName,$Choices  --- Return: Array $Form,$Field, Id, Value
     */
    public static function Transform($array){
        $dd_array= array();
        foreach ($array as $item){
            $form=$item[0];
            $field=$item[1];
            $arrayOptions = explode("|",$item[2]);
            foreach ($arrayOptions as $item2){
                $arrayOptionsExplode=explode(",",$item2,2);
                array_push( $dd_array, Array($form,$field,$arrayOptionsExplode[0],$arrayOptionsExplode[1]));

            }
        }
        return $dd_array;
    }



    /**
     * @param $string1
     * @param $string2
     * @param $percentage
     * @return bool
     * Compare two strings and return if they have a similarity bigger than $percentage
     */
    public static function EvaluateSimilarity($string1 , $string2, $percentage){

        // first preparing the strings.
            //for $string1
            //remove spaces at the end and convert in lowercase
            $word1=trim(strtolower($string1));
            //remove spaces between words
            $word1 = str_replace(' ', '_', $word1);
            //remove tabs
            $word1 = preg_replace('/\s+/','_',$word1);
            $word1 = str_replace('__', '_', $word1);
            // for $string2
            //remove spaces at the end and convert in lowercase
            $word2=trim(strtolower($string2));
            //remove spaces between words
            $word2 = str_replace(' ', '_', $word2);
            //remove tabs
            $word2 = preg_replace('/\s+/','_',$word2);
            $word2 = str_replace('__', '_', $word2);
        // obtain the % of similarity betwen words as a number and save the value on $similarity
        similar_text($word1, $word2, $similarity);

        return $similarity >= $percentage ? true : false;

    }

    //calculate if the distance of the codes  is > 0 ::: in case if coding using integers integers
    function CodeDistancesBiggerThanZero($array){
       // $difference = 0;
        $codes=array();
        //extract just the keys
        foreach( $array as $key => $value ){
             array_push($codes,$key);
        }
        asort($codes); //sort the array

        $length = count($codes);
        if ($length  == 0) return 0;

        for ($i=1; $i < $length; $i++){
            $difference = abs($codes[$i] - $codes[$i-1]);
            if($difference>1){
                return true;
            }
        }
        return false;
    }

// create the table with the choices
    public static function getChoices($array,$variable_name,$to_highlight ){
        $table='<table id="gp-results-table" class="table table-sm"  style="width:80%; border-color: inherit;" border="1">';

        foreach ($array as $list){
            if ($variable_name==$list[1]){
                if($to_highlight==$list[3]){
                    $table .='<tr><td class="bg-info" style="color: red" ><strong>'.$list[2].'</strong></td><td class="bg-info" style="color: red"><strong>'.$list[3].'</strong></td></tr>';

                }else{
                    $table .='<tr><td>'.$list[2].'</td><td>'.$list[3].'</td></tr>';
                }


            }

        }


    return $table .='</table>';
    }
    /**
     * @param $array
     * @param $known_list
     * @param $percentage
     * @return array
     *
     * Generate an Array with just the question with options that have similarity or are contained  to one of the elements of the list of Words (Other, Unknown..)
     */
    public static function FindOtherOrUnknown($array, $known_list,$percentage ){

        $to_fix_array= array();
        $OtherOrUnknownList = explode(",", $known_list);
        foreach ($array as $list){
            foreach ($OtherOrUnknownList as $Other){
                if (self::EvaluateSimilarity($list[3],$Other,$percentage ) ){   //TODO: check if   substrings should be part of the query or not strpos($list[3],$Other)

                    $table= self::getChoices($array,$list[1], $list[3]);

                    array_push( $to_fix_array, Array($list[0],$list[1],$list[2],$table));
                    //array_push( $to_fix_array, Array($list[0],$list[1],$list[2],$list[3]));
                }
            }
        }
        return $to_fix_array;
}

    /**
     * @param $array
     * @param $Ids
     * @return array
     * generate an array with  questions with codification problems for Other or Unknown..
     */
    public static function ListOfOtherOrUnknownWithProblems($array, $Ids){

        global $Proj;
        $to_fix_array= array();
        $IdsList = explode(",", $Ids);
        foreach ($array as $list){

            if(!in_array($list[2], $IdsList)){
                //check if this project is in production mode
                if ($_SESSION["status"]==1){
                    $link_path = APP_PATH_WEBROOT . 'Design/online_designer.php?pid=' . $_GET['pid'];


                }else {
                    $link_path = APP_PATH_WEBROOT . 'Design/online_designer.php?pid=' . $_GET['pid'] . '&page=' . $list[0] . '&field=' . $list[1];

                }
                     $link_to_edit = '<a href=' . $link_path . ' target="_blank" ><img src=' . APP_PATH_IMAGES .'pencil.png></a>';
                    // Adding : Intrument Name, instrument





                $label=TextBreak($list[1]);


                    array_push( $to_fix_array, Array(REDCap::getInstrumentNames($list[0]),$list[1],$label,$list[3],$link_to_edit));


            }
        }
        return array_map("unserialize", array_unique(array_map("serialize", $to_fix_array)));

    }


    public static function CheckOtherOrUnknown($DataDictionary, $similarity){
        $List= self::getLists($DataDictionary);
        $Words=self::getKeyWords();
        $Ids=self::getIDs();
        $REDCapList= self::Transform($List);
        $AllOther =self::FindOtherOrUnknown($REDCapList,$Words,$similarity);
        return self::ListOfOtherOrUnknownWithProblems($AllOther,$Ids);


    }










 }

 




