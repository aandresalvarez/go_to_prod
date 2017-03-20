<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/16/17
 * Time: 10:29 PM
 */


    //TODO: All classes


// Find path to redcap_connect.php
function findRedcapConnect()
{
    $dir = __DIR__;
    while ( !file_exists( $dir . "/redcap_connect.php" ) ) {
        if ($dir == dirname($dir)) {
            throw new Exception("Unable to locate redcap_connect.php");
        } else {
            $dir = dirname($dir);
        }
    }
    return $dir . "/redcap_connect.php";
}





// Call the REDCap Connect file in the main "redcap" directory
require_once findRedcapConnect();

$data_dictionary_array = REDCap::getDataDictionary('array');
//project information
global $Proj;

require  'messages.php';



function PrintTr($title_text,$body_text,$span_label,$a_tag){

        return

        '<tr class="gp-tr">
            <td>   
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    
            </td>
            <td class="gp-info-content">
                <div class="gp-title-content">
                    <strong>
                        '.$title_text.'
                    </strong>
                </div>
                    
                <div class="gp-body-content">
                    <p>
                        '.$body_text.'
                    </p>
                </div>
            </td>
            <td>               
                    '.$span_label.'
            </td>
            <td>               
                   '.$a_tag.'
            </td>
        </tr>';

}


function PrintOtherOrUnknownErrors($DataDictionary, $similarity){
        include_once "check_other_or_unknown.php";

        $res= new check_other_or_unknown();
        $array=$res::CheckOtherOrUnknown($DataDictionary, $similarity);

        if(!empty($array)){
            $a='<a data-toggle="modal" role="button" class="btn" href="views/other_or_unknown_view.php " data-target="#ResultsModal">'.lang('VIEW').'</a>';
            $span='<span class="label label-danger">'.lang('DANGER').'</span>';
            $_SESSION["OtherOrUnknownErrors"]= $array;
           return PrintTr(lang('OTHER_OR_UNKNOWN_TITLE'),lang('OTHER_OR_UNKNOWN_BODY'),$span,$a);
        }else return false;

    }

function PrintBranchingLogicErrors($DataDictionary){
        include "check_presence_of_branching_logic_variables.php";
        $res= new check_presence_of_branching_logic_variables();
        $array=$res::CheckIfBranchingLogicVariablesExist($DataDictionary);
        if (!empty($array)){
            $a='<a data-toggle="modal" role="button" class="btn" href="views/presence_of_branching_logic_variables_view.php" data-target="#ResultsModal">'.lang('VIEW').'</a>';
            $span='<span class="label label-danger">'.lang('DANGER').'</span>';
            $_SESSION["BranchingLogicErrors"]= $array;
            return PrintTr(lang('BRANCHING_LOGIC_TITLE'),lang('BRANCHING_LOGIC_BODY'),$span,$a);

        }else return false;


    }

function PrintDatesConsistentErrors($DataDictionary){
    include "check_consistency_for_dates.php";
    $res= new check_consistency_for_dates();
    $array=$res::IsDatesConsistent($DataDictionary);
    if (!empty($array)){
        $a='<a data-toggle="modal" role="button" class="btn" href="views/consistency_for_dates_view.php" data-target="#ResultsModal">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["DatesConsistentErrors"]= $array;
        return PrintTr(lang('DATE_CONSISTENT_TITLE'),lang('DATE_CONSISTENT_BODY'),$span,$a);

    }else return false;


}

function PrintYesNoConsistentErrors($DataDictionary){
    include_once "check_consistency_for_lists.php";
    $res= new check_consistency_for_lists();
    $array=$res::IsYesNoConsistent($DataDictionary);
    if (!empty($array)){
        $a='<a data-toggle="modal" role="button" class="btn" href="views/consistency_yes_no_view.php" data-target="#ResultsModal">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["YesNoConsistentErrors"]= $array;
        return PrintTr(lang('YES_NO_TITLE'),lang('YES_NO_BODY'),$span,$a);

    }else return false;


}

function PrintPositiveNegativeConsistentErrors($DataDictionary){
    include_once "check_consistency_for_lists.php";
    $res= new check_consistency_for_lists();
    $array=$res::IsPositiveNegativeConsistent($DataDictionary);
    if (!empty($array)){
        $a='<a data-toggle="modal" role="button" class="btn" href="views/consistency_positive_negative_view.php" data-target="#ResultsModal">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["PositiveNegativeConsistentErrors"]= $array;
        return PrintTr(lang('POSITIVE_NEGATIVE_TITLE'),lang('POSITIVE_NEGATIVE_BODY'),$span,$a);

    }else return false;


}


function PrintIdentifiersErrors($DataDictionary){
    include_once "check_identifiers.php";
    $res= new check_identifiers();
    $identifiers_found=$res::AnyIdentifier($DataDictionary);
    if (!$identifiers_found){
        $a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.lang('EDIT').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        //$_SESSION["PositiveNegativeConsistentErrors"]= $identifiers_found;
        return PrintTr(lang('IDENTIFIERS_TITLE'),lang('IDENTIFIERS_BODY'),$span,$a);

    }else return false;


}

function PrintPIErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::PIExist($proj);
    if (!$pi_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        //$a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.lang('EDIT').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        //$_SESSION["PiErrors"]= $pi_found;
        return PrintTr(lang('PI_TITLE'),lang('PI_BODY'),$span,$a);

    }else return false;


}

function PrintIRBErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::IRBExist($proj);
    if (!$pi_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        //$a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.lang('EDIT').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        //$_SESSION["PiErrors"]= $pi_found;
        return PrintTr(lang('IRB_TITLE'),lang('IRB_BODY'),$span,$a);

    }else return false;


}

function PrintResearchErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $research_found=$res::IsAResearchProject($proj);
    if (!$research_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        //$a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.lang('EDIT').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        //$_SESSION["PiErrors"]= $pi_found;
        return PrintTr(lang('RESEARCH_PROJECT_TITLE'),lang('RESEARCH_PROJECT_BODY'),$span,$a);

    }else return true;


}
function PrintJustForFunErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $jff_found=$res::IsJustForFunProject($proj);
    if ($jff_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        //$a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.lang('EDIT').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        //$_SESSION["PiErrors"]= $pi_found;
        return PrintTr(lang('JUST_FOR_FUN_PROJECT_TITLE'),lang('JUST_FOR_FUN_PROJECT_BODY'),$span,$a);

    }else{

        return false;
    }


}

function PrintTestRecordsErrors(){
    include_once "check_test_records.php";
    $res= new check_test_records();

    $array=$res::CheckTestRecordsAndExports();
    if (!empty($array)){
       // $a='<a data-toggle="modal" role="button" class="btn" href="views/consistency_positive_negative_view.php" data-target="#ResultsModal">'.lang('VIEW').'</a>';
        $a= '<u>Exports:</u>'.$array[0].'<br><u> Records: </u>'.$array[1];

        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        //$_SESSION["PositiveTestRecordsErrors"]= $array;
        return PrintTr(lang('TEST_RECORDS_TITLE'),lang('TEST_RECORDS_BODY'),$span,$a);

    }else return false;



}

function PrintSuccess(){
//TODO: send directly to move to production screen
    $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
    $span='<span class="label label-success">'.lang('SUCCESS').'</span>';
    return PrintTr(lang('READY_TO_GO_TITLE'),lang('READY_TO_GO_BODY'),$span,$a);


}



//IF is Jus for fun do not check anything ,Just for fun project do not go to production
$just_for_fun=PrintJustForFunErrors($Proj);
if($just_for_fun){
    echo $just_for_fun;
}else{

    //IS is a research project ask for PI and IRB
    $research=PrintResearchErrors($Proj);
    if($research){

        echo PrintPIErrors($Proj);
        echo PrintIRBErrors($Proj);
    }else{
        //if is not a reaserch project but you want to go to production anyways
        echo $research;
    }

    $res_records= PrintTestRecordsErrors();
    $res_other_or_unknown= PrintOtherOrUnknownErrors($data_dictionary_array, 80);
    $res_branching_logic= PrintBranchingLogicErrors($data_dictionary_array);
    $res_dates_consistent= PrintDatesConsistentErrors($data_dictionary_array);
    $res_yes_no_consistent= PrintYesNoConsistentErrors($data_dictionary_array);
    $res_positive_negative_consistent= PrintPositiveNegativeConsistentErrors($data_dictionary_array);
    $res_identifiers= PrintIdentifiersErrors($data_dictionary_array);


    if($res_records or
        $res_other_or_unknown or
        $res_branching_logic or
        $res_dates_consistent or
        $res_yes_no_consistent or
        $res_positive_negative_consistent
        or $res_identifiers) {

        echo $res_records;
        echo $res_other_or_unknown;
        echo $res_branching_logic;
        echo $res_dates_consistent;
        echo $res_yes_no_consistent;
        echo $res_positive_negative_consistent;
        echo $res_identifiers;

    }else{
        //if all is ok you can go to production!!
        echo PrintSuccess();

    }
}



