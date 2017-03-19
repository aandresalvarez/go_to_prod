<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/7/17
 * Time: 5:45 PM
 */
// connect to the REDCap database
//require_once('../../redcap_connect.php');

class check_test_records
{




    /**
     * @param $string
     * @return mixed|string
     */
    public static function CleanString($string){

        // first preparing the strings.
        //for $string1
        //remove spaces at the end and convert in lowercase
        $word1=trim(strtolower($string));
        //remove spaces between words
        $word1 = str_replace(' ', '_', $word1);
        //remove tabs
        $word1 = preg_replace('/\s+/','_',$word1);
        $word1 = str_replace('__', '_', $word1);

        return $word1;
    }


    /**
     * @return array // Return  Array with number of exports an records created.
     */
    public static function CheckTestRecordsAndExports( ){

    $count_records=0;
    $count_exports=0;
    $total= Array();
    $sql = "SELECT description FROM  redcap_log_event where project_id=".$_GET['pid'];

    $result = db_query( $sql );
    //print_r($result);
    while ( $result1 = db_fetch_assoc( $result ) )
    {

        //echo $result;
        if(!strcmp(self::CleanString($result1[description]),self::CleanString('Create record'))){
            $count_records++;

        }elseif (trim($result1[description])==='Export data'){
            $count_exports++;

        }

    }


      if($count_records < 3 or $count_exports < 1) { $total=  Array($count_exports,$count_records); }

        return $total;

}


}