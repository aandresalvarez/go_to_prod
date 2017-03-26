<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/16/17
 * Time: 10:29 PM
 */



require 'utilities.php';
// Call the REDCap Connect file in the main "redcap" directory
require_once findRedcapConnect();

$data_dictionary_array = REDCap::getDataDictionary('array');
//project information
global $Proj;

require_once  'messages.php';


function PrintTr($title_text,$body_text,$span_label,$a_tag){

        return

        '<tr class="gp-tr">
            <td>   
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    
            </td>
            <td class="gp-info-content">
                <div class="gp-title-content">
                    <strong>
                        '.$title_text. ' <span class="title-text-plus" style="color: #5492a3"><small>(more)</small></span>
                    </strong>
                </div>
                    
                <div class="gp-body-content">
                    <p>
                        ' .$body_text.' 
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

            $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/other_or_unknown_view.php" data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').'</a>';
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
            $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/presence_of_branching_logic_variables_view.php" data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').' </a>';
            $span='<span class="label label-danger">'.lang('DANGER').'</span>';
            $_SESSION["BranchingLogicErrors"]= $array;
            return PrintTr(lang('BRANCHING_LOGIC_TITLE'),lang('BRANCHING_LOGIC_BODY'),$span,$a);

        }else return false;


    }

function PrintDatesConsistentErrors($DataDictionary){
    include "check_dates_consistency.php";
    $res= new check_dates_consistency();
    $array=$res::IsDatesConsistent($DataDictionary);
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/dates_consistency_view.php" data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').'</a>';

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
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/consistency_yes_no_view.php" data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').'</a>';
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
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/consistency_positive_negative_view.php" data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').'</a>';

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
        return PrintTr(lang('IDENTIFIERS_TITLE'),lang('IDENTIFIERS_BODY'),$span,$a);

    }else return false;


}

function PrintPIErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::PIExist($proj);
    if (!$pi_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        return PrintTr(lang('PI_TITLE'),lang('PI_BODY'),$span,$a);

    }else return false;


}

function PrintIRBErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::IRBExist($proj);
    if (!$pi_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        return PrintTr(lang('IRB_TITLE'),lang('IRB_BODY'),$span,$a);

    }else return false;


}

function PrintResearchErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $research_found=$res::IsAResearchProject($proj);
    if (!$research_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-info">'.lang('INFO').'</span>';
        return PrintTr(lang('RESEARCH_PROJECT_TITLE'),lang('RESEARCH_PROJECT_BODY'),$span,$a);

    }else return false;
}
function PrintJustForFunErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $jff_found=$res::IsJustForFunProject($proj);
    if ($jff_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        return PrintTr(lang('JUST_FOR_FUN_PROJECT_TITLE'),lang('JUST_FOR_FUN_PROJECT_BODY'),$span,$a);

    }else{

        return false;
    }
}

function PrintTestRecordsErrors(){
    include_once "check_count_test_records_and_exports.php";
    $res= new check_count_test_records_and_exports();
    global $Proj;
    $array=$res::CheckTestRecordsAndExports();
    if (!empty($array) and $Proj->project['status']==0){
        $a= '<u>Exports:</u>'.$array[0].'<br><u> Records: </u>'.$array[1];
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        return PrintTr(lang('TEST_RECORDS_TITLE'),lang('TEST_RECORDS_BODY'),$span,$a);

    }else return false;
}

function PrintNumberOfFieldsInForms($DataDictionary,$max_recommended){
    include_once 'check_number_of_fields_by_form.php';
    $res= new check_number_of_fields_by_form();
    $array=$res::getFormsWithToManyFields($DataDictionary,$max_recommended);
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/number_of_fields_by_form_view.php" data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["NumberOfFieldsByForm"]= $array;
        return PrintTr(lang('MAX_NUMBER_OF_RECORDS_TITLE'),lang('MAX_NUMBER_OF_RECORDS_BODY'),$span,$a);

    }else return false;

}

function PrintValidatedFields($DataDictionary,$min_percentage){
    include_once 'check_field_validation.php';
    $res= new check_field_validation();
    $array=$res::getMinimumOfValidatedFields($DataDictionary,$min_percentage);

    if (!empty($array)){
        $a= '<u>'.lang('VALIDATED_FIELDS').'</u>'.$array[0].'<br><u>'.lang('TEXT_BOX_FIELDS').'</u>'.$array[1];
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        return PrintTr(lang('NUMBER_VALIDATED_RECORDS_TITLE'),lang('NUMBER_VALIDATED_RECORDS_BODY'),$span,$a);

    }else{

        return false;
    }

}
function  MyFirstInstrumentError(){
    include_once "check_my_first_instrument_presence.php";
    $res= new check_my_first_instrument_presence();
    $my_first_instrument_found=$res::IsMyFirstInstrument();
    if ($my_first_instrument_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        return PrintTr(lang('MY_FIRST_INSTRUMENT_TITLE'),lang('MY_FIRST_INSTRUMENT_BODY'),$span,$a);

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

    //if is a research project ask for PI and IRB
    $research=PrintResearchErrors($Proj);
    if(!$research){
        echo PrintPIErrors($Proj);
        echo PrintIRBErrors($Proj);



    }else{
        //if is not a research project but you want to go to production anyways
        echo $research;


    }

    $res_records= PrintTestRecordsErrors();
    $res_other_or_unknown= PrintOtherOrUnknownErrors($data_dictionary_array, 100 );
    $res_branching_logic= PrintBranchingLogicErrors($data_dictionary_array);
    $res_dates_consistent= PrintDatesConsistentErrors($data_dictionary_array);
    $res_yes_no_consistent= PrintYesNoConsistentErrors($data_dictionary_array);
    $res_positive_negative_consistent= PrintPositiveNegativeConsistentErrors($data_dictionary_array);
    $res_identifiers= PrintIdentifiersErrors($data_dictionary_array);
    $res_number_of_fields_by_form=PrintNumberOfFieldsInForms($data_dictionary_array,30);
    $res_validated_fields=PrintValidatedFields($data_dictionary_array, 0.05);
    $res_my_first_instrument_found=MyFirstInstrumentError();


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
        echo $res_validated_fields;
        echo $res_positive_negative_consistent;
        echo $res_identifiers;
        echo $res_number_of_fields_by_form;
        echo $res_my_first_instrument_found;


    }else{
        //if all is ok you can go to production!!
        echo PrintSuccess();
    }

}



