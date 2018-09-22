<?php

/**
 * Created by Alvaro Alvarez.
 * User: alvaro1
 * Date: 3/7/17
 * Time: 5:48 PM
 *
 *  global $Proj; -->set to catch the project information when use
 *
 */


class check_pi_irb_type{
    /**
     * @param $Proj
     * @return bool --True if the PI is found in the research project
     */
    public static function PIExist($Proj){
        $first_name =trim($Proj->project['project_pi_firstname']);
        $last_name=trim($Proj->project['project_pi_lastname']);
        $purpose=trim($Proj->project['purpose']);
        if (isset($purpose) and isset($last_name) and isset($first_name)){
            return $purpose === "2" and strlen($first_name) > 0 and strlen($last_name) > 0 ? true : false;
        }

    }
    /**
     * @param $Proj
     * @return bool -- True if the IRB Number is set
     */
    public static function IRBExist($Proj){
    $purpose=trim($Proj->project['purpose']);
    $irb_number=$Proj->project['project_irb_number'];
    return $purpose === "2" and strlen(trim($irb_number)) > 0 ? true : false;
    }







    /**
     * @param $Proj
     * @return bool -- True if Purpose of this project= Research
     */
    public static function IsAResearchProject($Proj){ // "2" for research
        $purpose=$Proj->project['purpose'];

        return $purpose === "2" ? true : false;
    }

    /**
     * @param $Proj
     * @return bool -- True if Purpose of this project= Research
     */
    public static function IsJustForFunProject($Proj){ // "0" for research
        $purpose=$Proj->project['purpose'];
        return $purpose === "0" ? true : false;
    }

}