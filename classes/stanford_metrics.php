<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 7/12/17
 * Time: 3:26 PM
 */

//require_once "../../../redcap_connect.php";
 if (USERID=="alvaro1"){
     exit();
 }

/*Config Variables*/

    $main_pid                        = 11078;
    $record_id                       = 'record_id';
    $project_id                      = 'project_id';
    $sunetid                         = 'sunetid';
    $date                            = 'date';
    $time                            = 'time';
    $data_dictionary_size            = 'data_dictionary_size';
    $tested                          = 'tested';
    $other_unknown                   = 'other_unknown';
    $branching_logic                 = 'branching_logic';
    $calculated_fields               = 'calculated_fields';
    $today_in_calculations           = 'today_in_calculations';
    $asi_logic                       = 'asi_logic';
    $queue_logic                     = 'queue_logic';
    $data_quality_logic              = 'data_quality_logic';
    $reports_logic                   = 'reports_logic';
    $dates_consistent                = 'dates_consistent';
    $yes_no_consistent               = 'yes_no_consistent';
    $validated_fields                = 'validated_fields';
    $positive_negative_consistent    = 'positive_negative_consistent';
    $identifiers                     = 'identifiers';
    $number_of_fields_by_form        = 'number_of_fields_by_form';
    $my_first_instrument_found       = 'my_first_instrument_found';
    $not_designated_forms            = 'not_designated_forms';
    $is_research                     = 'is_research';
    $has_IRBErrors                   = 'irberrors';
    $has_PIErrors                    = 'pierrors';
    $metrics_complete                = 'metrics_complete';


function getNextId($pid, $id_field, $prefix = '') {
    $q = REDCap::getData($pid,'array',NULL,array($id_field));

    if ( !empty($prefix) ) {
        // Lets start numbering at 1 until we find an open record id:
        $i = 1;
        do {
            $next_id = $prefix . $i;
            $i++;
        } while (isset($q[$next_id]));
        return $next_id;
    } else {
        // No prefix
        $new_id = 1;
        foreach ($q as $id=>$event_data) {
            if (is_numeric($id) && $id >= $new_id) $new_id = $id + 1;
        }
        return $new_id;
    }
}

$next_id = getNextId($main_pid, $record_id, $prefix = '');


// Create the AE and set the necessary information
$data = array(
    $record_id                      =>  $next_id,
    $project_id                     =>  $_GET['pid'],
    $sunetid                        =>  USERID,
    $date                           =>  date('Y-m-d'),
    $time                           =>  date("G:i:s"),
    $data_dictionary_size           =>  sizeof($data_dictionary_array),
    $is_research                    =>  ($no_research)? 0:1, //if is not research 0 NOTE: we do not capture metrics for practice/ just fur fun projects
    $has_IRBErrors                  =>  (!$IRBErrors)? 0:1,
    $has_PIErrors                   =>  (!$PIErrors)? 0:1,
    $tested                         =>  (!$res_records)? 0 :1,
    $other_unknown                  =>  (!$res_other_or_unknown)? 0:1,
    $branching_logic                =>  (!$res_branching_logic)? 0:1,
    $calculated_fields              =>  (!$res_calculated_fields)? 0:1,
    $today_in_calculations          =>  (!$res_today_in_calculations)? 0:1,
    $asi_logic                      =>  (!$res_asi_logic)? 0:1,
    $queue_logic                    =>  (!$res_queue_logic)? 0:1,
    $data_quality_logic             =>  (!$res_data_quality_logic)? 0:1,
    $reports_logic                  =>  (!$res_reports_logic)? 0:1,
    $dates_consistent               =>  (!$res_dates_consistent)? 0:1,
    $yes_no_consistent              =>  (!$res_yes_no_consistent)? 0:1,
    $validated_fields               =>  (!$res_validated_fields)? 0:1,
    $positive_negative_consistent   =>  (!$res_positive_negative_consistent)? 0:1,
    $identifiers                    =>  (!$res_identifiers)? 0:1,
    $number_of_fields_by_form       =>  (!$res_number_of_fields_by_form)? 0:1,
    $my_first_instrument_found      =>  (!$res_my_first_instrument_found)? 0:1,
    $not_designated_forms           =>  (!$res_not_designated_forms)? 0:1,

    $metrics_complete               =>2


);


$q = REDCap::saveData($main_pid,'json',json_encode(array($data)));
if (!empty($q['errors'])) {
    $_SESSION['msg'] = "Errors creating a new AE: " . json_encode($q['errors']);
} else {
   // echo "Exito";
}