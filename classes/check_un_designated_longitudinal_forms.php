<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/10/17
 * Time: 10:47 AM
 */

require_once "../../../redcap_connect.php";

class check_un_designated_longitudinal_forms
{
    //  in a longitudinal project: check and list all the forms not designated for events.

//TODO:Improper enabling of Longitudinal with only 1 event – disable Longitudinal mode

    public static function NotDesignatedForms()
    {
        $array = Array();
        global $Proj;
        $events= $Proj->eventsForms;
        // Check if project is longitudinal first
        if (REDCap::isLongitudinal()){
                $instrument_names = REDCap::getInstrumentNames();
                $instrument_unique_names = Array();
                $events_with_forms = Array();

                foreach ($instrument_names as $unique_name => $label) {
                    array_push($instrument_unique_names, $unique_name);
                }

                foreach ($instrument_unique_names as $form_name) {

                    foreach ($events as $event_id => $forms_array) {

                        if ( in_array($form_name, $forms_array)) array_push($events_with_forms, $form_name);
                    }
                }

               $events_with_forms = array_map("unserialize", array_unique(array_map("serialize", $events_with_forms)));

               $result = array_diff($instrument_unique_names, $events_with_forms);

                foreach ($result as $item) {
                    $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'Design/designate_forms.php?pid='.$_GET['pid'].'"  >'.lang('VIEW').'</a>';
                    array_push($array, Array($item,REDCap::getInstrumentNames($item),$a));
                }
        }

    return  $array;
    }
}


