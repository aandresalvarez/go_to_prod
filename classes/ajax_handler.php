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
 function  Lang($phrase){

     $lang_vars= new messages();
     return $lang_vars->lang($phrase);
}


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
            $a='<a data-toggle="modal" role="button" class="btn" href="views/other_or_unknown_view.php?data='.$array.' " data-target="#ResultsModal">'.Lang('VIEW').'</a>';
            $span='<span class="label label-danger">'.Lang('DANGER').'</span>';
            $_SESSION["OtherOrUnknownErrors"]= $array;
           return PrintTr(Lang('OTHER_OR_UNKNOWN_TITLE'),Lang('OTHER_OR_UNKNOWN_BODY'),$span,$a);
        }

    }

function PrintBranchingLogicErrors($DataDictionary){
        include "check_presence_of_branching_logic_variables.php";
        $res= new check_presence_of_branching_logic_variables();
        $array=$res::CheckIfBranchingLogicVariablesExist($DataDictionary);
        if (!empty($array)){
            $a='<a data-toggle="modal" role="button" class="btn" href="views/presence_of_branching_logic_variables_view.php" data-target="#ResultsModal">'.Lang('VIEW').'</a>';
            $span='<span class="label label-danger">'.Lang('DANGER').'</span>';
            $_SESSION["BranchingLogicErrors"]= $array;
            return PrintTr(Lang('BRANCHING_LOGIC_TITLE'),Lang('BRANCHING_LOGIC_BODY'),$span,$a);

        }


    }

function PrintDatesConsistentErrors($DataDictionary){
    include "check_consistency_for_dates.php";
    $res= new check_consistency_for_dates();
    $array=$res::IsDatesConsistent($DataDictionary);
    if (!empty($array)){
        $a='<a data-toggle="modal" role="button" class="btn" href="views/consistency_for_dates_view.php" data-target="#ResultsModal">'.Lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.Lang('WARNING').'</span>';
        $_SESSION["DatesConsistentErrors"]= $array;
        return PrintTr(Lang('DATE_CONSISTENT_TITLE'),Lang('DATE_CONSISTENT_BODY'),$span,$a);

    }


}

function PrintYesNoConsistentErrors($DataDictionary){
    include_once "check_consistency_for_lists.php";
    $res= new check_consistency_for_lists();
    $array=$res::IsYesNoConsistent($DataDictionary);
    if (!empty($array)){
        $a='<a data-toggle="modal" role="button" class="btn" href="views/consistency_yes_no_view.php" data-target="#ResultsModal">'.Lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.Lang('WARNING').'</span>';
        $_SESSION["YesNoConsistentErrors"]= $array;
        return PrintTr(Lang('YES_NO_TITLE'),Lang('YES_NO_BODY'),$span,$a);

    }


}

function PrintPositiveNegativeConsistentErrors($DataDictionary){
    include_once "check_consistency_for_lists.php";
    $res= new check_consistency_for_lists();
    $array=$res::IsPositiveNegativeConsistent($DataDictionary);
    if (!empty($array)){
        $a='<a data-toggle="modal" role="button" class="btn" href="views/consistency_positive_negative_view.php" data-target="#ResultsModal">'.Lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.Lang('WARNING').'</span>';
        $_SESSION["PositiveNegativeConsistentErrors"]= $array;
        return PrintTr(Lang('POSITIVE_NEGATIVE_TITLE'),Lang('POSITIVE_NEGATIVE_BODY'),$span,$a);

    }


}


function PrintIdentifiersErrors($DataDictionary){
    include_once "check_identifiers.php";
    $res= new check_identifiers();
    $identifiers_found=$res::AnyIdentifier($DataDictionary);
    if (!$identifiers_found){
        $a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.Lang('EDIT').'</a>';
        $span='<span class="label label-warning">'.Lang('WARNING').'</span>';
        //$_SESSION["PositiveNegativeConsistentErrors"]= $identifiers_found;
        return PrintTr(Lang('IDENTIFIERS_TITLE'),Lang('IDENTIFIERS_BODY'),$span,$a);

    }


}

function PrintPIErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::PIExist($proj);
    if (!$pi_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.Lang('PROJECT_SETUP').'</a>';
        //$a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.Lang('EDIT').'</a>';
        $span='<span class="label label-danger">'.Lang('DANGER').'</span>';
        //$_SESSION["PiErrors"]= $pi_found;
        return PrintTr(Lang('PI_TITLE'),Lang('PI_BODY'),$span,$a);

    }


}

function PrintIRBErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::IRBExist($proj);
    if (!$pi_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.Lang('PROJECT_SETUP').'</a>';
        //$a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.Lang('EDIT').'</a>';
        $span='<span class="label label-danger">'.Lang('DANGER').'</span>';
        //$_SESSION["PiErrors"]= $pi_found;
        return PrintTr(Lang('IRB_TITLE'),Lang('IRB_BODY'),$span,$a);

    }


}

function PrintResearchErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $research_found=$res::IsAResearchProject($proj);
    if (!$research_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.Lang('PROJECT_SETUP').'</a>';
        //$a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.Lang('EDIT').'</a>';
        $span='<span class="label label-warning">'.Lang('WARNING').'</span>';
        //$_SESSION["PiErrors"]= $pi_found;
        return PrintTr(Lang('RESEARCH_PROJECT_TITLE'),Lang('RESEARCH_PROJECT_BODY'),$span,$a);

    }


}
function PrintJustForFunErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $jff_found=$res::IsJustForFunProject($proj);
    if ($jff_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.Lang('PROJECT_SETUP').'</a>';
        //$a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.Lang('EDIT').'</a>';
        $span='<span class="label label-danger">'.Lang('DANGER').'</span>';
        //$_SESSION["PiErrors"]= $pi_found;
        return PrintTr(Lang('JUST_FOR_FUN_PROJECT_TITLE'),Lang('JUST_FOR_FUN_PROJECT_BODY'),$span,$a);

    }


}

function PrintTestRecordsErrors(){
    include_once "check_test_records.php";
    $res= new check_test_records();

    $array=$res::CheckTestRecordsAndExports();
    if (!empty($array)){
       // $a='<a data-toggle="modal" role="button" class="btn" href="views/consistency_positive_negative_view.php" data-target="#ResultsModal">'.Lang('VIEW').'</a>';
        $a= '<u>Exports:</u>'.$array[0].'<br><u> Records: </u>'.$array[1];

        $span='<span class="label label-danger">'.Lang('DANGER').'</span>';
        //$_SESSION["PositiveTestRecordsErrors"]= $array;
        return PrintTr(Lang('TEST_RECORDS_TITLE'),Lang('TEST_RECORDS_BODY'),$span,$a);

    }



}

function PrintSuccess(){
//TODO: send directly to move to production screen
    $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.Lang('PROJECT_SETUP').'</a>';
    $span='<span class="label label-success">'.Lang('SUCCESS').'</span>';
    return PrintTr(Lang('READY_TO_GO_TITLE'),Lang('READY_TO_GO_BODY'),$span,$a);


}

//echo '<table border="2">'.getOtherOrUnknownErrors($data_dictionary_array, 80 ).'</table>';
echo PrintSuccess();
echo PrintTestRecordsErrors();
echo PrintJustForFunErrors($Proj);

echo PrintResearchErrors($Proj);

echo PrintPIErrors($Proj);
echo PrintIRBErrors($Proj);


echo   PrintOtherOrUnknownErrors($data_dictionary_array, 80 );
echo PrintBranchingLogicErrors($data_dictionary_array);
echo PrintDatesConsistentErrors($data_dictionary_array);

echo PrintYesNoConsistentErrors($data_dictionary_array);

echo PrintPositiveNegativeConsistentErrors($data_dictionary_array);

echo PrintIdentifiersErrors($data_dictionary_array);






