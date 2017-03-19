<?php
/**
 * PLUGIN NAME: Go Prod  By Alvaro Alvarez
 * DESCRIPTION: A brief description of the Plugin.
 * VERSION: 0.1
 * AUTHOR:   Alvaro Alvarez
 */

// Call the REDCap Connect file in the main "redcap" directory
require_once "../../redcap_connect.php";

// OPTIONAL: Your custom PHP code goes here. You may use any constants/variables listed in redcap_info().

// OPTIONAL: Display the project header
require_once APP_PATH_DOCROOT . 'ProjectGeneral/header.php';



//including checks
include 'classes/check_other_or_unknown.php';
include 'classes/check_consistency_for_lists.php'; // yes/no - positive/negative
include 'classes/check_identifiers.php';
include 'classes/check_pi_irb_type.php';
include 'classes/check_consistency_for_dates.php';
include 'classes/check_presence_of_branching_logic_variables.php';
include 'classes/check_test_records.php';

//Load the Data Dictionary
$data_dictionary_array = REDCap::getDataDictionary('array');

//project information
global $Proj;

//capture the status to be used in classes
$_SESSION["status"]=$status;

// KWarning if project is  in production status
if ($status == 1)
{
    echo "<div class=\"alert alert-warning\">
  <strong>Warning!</strong> This plugin may not work as is expected projects in <strong>Production</strong> mode. For better results move back to Development mode.</div>";
}




//classes
$irb= new check_pi_irb;
$other_or_unknown = new check_other_or_unknown;
$consistency = new check_consistency_for_lists; // yes/no - positive/negative
$identifiers= new check_identifiers;
$date_consistency = new check_consistency_for_dates;
$branching= new check_presence_of_branching_logic_variables;
$test_records = new check_test_records;

//Results
$is_research_project=$irb::IsAResearchProjec($Proj);
$PI_found=$irb::PIExist($Proj);
$IRB_found=$irb::IRBExist($Proj);
$identifiers_found=$identifiers::AnyIdentifier($data_dictionary_array);

$_SESSION["other_or_unknown_problems_found"]= $other_or_unknown::CheckOtherOrUnknown($data_dictionary_array,100); //Percentage of similarity required
$_SESSION["is_yes_no_consistent"]=$consistency::IsYesNoConsistent($data_dictionary_array);
$_SESSION["is_positive_negative_consistent"]=$consistency::IsPositiveNegativeConsistent($data_dictionary_array);
$_SESSION["is_date_consistent"]=$date_consistency::IsDateConsistent($data_dictionary_array);
$_SESSION["branching_logic_problems_found"]=$branching::CheckIfBranchingLogicVariablesExist($data_dictionary_array);
$_SESSION["test_records_and_exports_found"]= $test_records::CheckTestRecordsAndExports();//??
// echo '<pre>' . print_r($_SESSION["test_records_and_exports_found"], TRUE) . '</pre>';


//Validation Labels
$other_or_unknown_problems_found_label='<strong>Incorrect Coding of "Other" and "Unknown" values in drop-down lists, radio-buttons or check-boxes:</strong><br><div>It is common to include an \'other\' or \'unknown\' option at the end of a dropdown list. It is encouraged to use different coding for these answers for two reasons (in general Other=99 and unknown=98). 
</div>     ';
$is_yes_no_consistent_label='<strong>Different coding for yes/no questions:</strong><br><div>When data is analyzed in statistical software you often only see the \'coded\' values.  So, it is important to be consistent across your project so the codes don\'t arbitrarily change from question to question.  In REDCap, the standard for \'Yes\' is 1 and \'No\' is 0.  If you select the Yes/No question type this is now it will be coded.

You should avoid using values other than 0 or 1 for No and Yes. Order doesn\'t matter, so you can make your radio button fields as: <br>
1, Yes<br>
0, No<br>
2, Other<br>

if you want the Yes option to come first.</div>';
$is_positive_negative_consistent_label='<strong>Different coding for Positive/Negative questions:</strong><br><div>When data is analyzed in statistical software you often only see the \'coded\' values.  So, it is important to be consistent across your project so the codes don\'t arbitrarily change from question to question.</div>';
$identifiers_found_label='<strong>No fields tagged as identifiers were found:</strong><br><p class="go_prod_text"></p>';
$PI_found_label='<div class="go_prod_text"><strong>Missing PI name and last name :</strong><br><div> For a research project the name of the principal investigator is required. Please add it on  the "Modify project title, purpose, etc." button under the Project Setup</div>';
$IRB_found_label='<strong>IRB Information is not complete:</strong><br><div>For a research project the Institutional Review Board (IRB) Number is required. Please add it on  the "Modify project title, purpose, etc." button under the Project Setup</div>';
$is_research_project_label='The purpose of this project is "<b>Not Research</b>" There is no reason to move this project into production mode.  There are NO additional features that are enabled when moving to production.  You can test and even collect data in development mode.';
$is_date_consistent_label='<strong>Date Format Inconsistencies:</strong><br><div> Different date formats (i.e, mix of mdy and ymd) – validate consistently across all dates.</div>';
$branching_logic_problems_found_label='<strong>Branching Logic Inconsistencies:</strong>';
$test_records_and_exports_found_label='<strong>This project has not been sufficiently tested:</strong><br><div>We recommend the creation of least 3 test records and at least 1 export in development mode to be sure of the results.</div> ';











//Print table
?>

<link rel="stylesheet" href="styles/go_prod_styles.css">


<body>

    <div class="projhdr"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Go to Production mode Check List </div>
    <p style="margin-top:0px;">
        If the thought of loosing the data you have entered into your REDCap project sounds painful, then you should be in Production mode.
        Production mode helps protect your data from accidental mistakes. This plugin will allow you to verify if your project is ready to go to production or you ned to fix something before.  <a href="https://medwiki.stanford.edu/x/SRMzAw" > <u>When do I move to Production Mode?</u></a>
    </p>
    <br>
<table class="table go_prod_table table-hover table-condensed ">
    <thead>
        <tr>
            <th><strong></strong></th>
            <th><strong>Validation</strong></th>
            <th><strong>Result</strong></th>
            <th><strong>Options</strong></th>
        </tr>
    </thead>
    <tbody>

            <?php if ($is_research_project){
                    if(!$PI_found){ ?>
                        <tr><td ><strong><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></strong></td><td><?php echo $PI_found_label;?></td> <td><span class="label label-warning">Warning</span></span></td><td><a  target="_blank" href="<?php echo APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid']; ?>"  >Project Setup</a> </td></tr>
                    <?php }
                    if(!$IRB_found){ ?>
                        <tr><td ><strong><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></strong></td><td><?php echo $IRB_found_label;?></td> <td><span class="label label-warning">Warning</span></td><td><a  target="_blank" href="<?php echo APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid']; ?>"  >Project Setup</a></td></tr>
            <?php }     } else {  ?>
                        <tr><td ><strong><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></strong></td><td><?php echo $is_research_project_label;?></td> <td><span class="label label-info">Info</span></td><td>--</td></tr>
                    <?php }?>
            <?php if (!empty($_SESSION["other_or_unknown_problems_found"])){?>
                <tr><td ><strong><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></strong></td><td><?php echo $other_or_unknown_problems_found_label;?></td> <td><span class="label label-warning">Warning</span></td><td><a data-toggle="modal" role="button" class="btn" href="views/other_or_unknown_view.php " data-target="#ResultsModal">See</a></td></tr>
            <?php } if (!empty($_SESSION["is_yes_no_consistent"])) {?>
                <tr><td ><strong><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></strong></td><td><?php echo $is_yes_no_consistent_label;?></td> <td><span class="label label-warning">Warning</span></td><td><a data-toggle="modal" role="button" class="btn" href="views/consistency_yes_no_view.php " data-target="#ResultsModal">See</a></td></tr>
            <?php } if (!empty($_SESSION["is_positive_negative_consistent"])){ ?>
                <tr><td ><strong><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></strong></td><td><?php echo $is_positive_negative_consistent_label;?></td> <td><span class="label label-warning">Warning</span></td><td><a data-toggle="modal" role="button" class="btn" href="views/consistency_positive_negative_view.php" data-target="#ResultsModal">See</a></td></tr>
            <?php } if (!$identifiers_found){?>
                <tr><td ><strong><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></strong></td><td><?php echo $identifiers_found_label;?></td> <td><span class="label label-warning">Warning</span></td><td><a  target="_blank"  role="button" class="btn" href="<?php echo APP_PATH_WEBROOT.'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index'; ?>"  >Edit</a></td></tr>
            <?php } if (!empty($_SESSION["is_date_consistent"])) {?>
                <tr><td ><strong><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></strong></td><td><?php echo $is_date_consistent_label;?></td> <td><span class="label label-warning">Warning</span></td><td><a data-toggle="modal" role="button" class="btn" href="views/consistency_for_dates_view.php" data-target="#ResultsModal">See</a></td></tr>
            <?php } if (!empty($_SESSION["branching_logic_problems_found"])) {?>
                <tr><td ><strong><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></strong></td><td><?php echo $branching_logic_problems_found_label;?></td> <td><span class="label label-danger">Danger</span></td><td><a data-toggle="modal" role="button" class="btn" href="views/presence_of_branching_logic_variables_view.php" data-target="#ResultsModal">See</a></td></tr>
            <?php } if (!empty($_SESSION["test_records_and_exports_found"])) {?>
                <tr><td ><strong><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></strong></td><td><?php echo $test_records_and_exports_found_label;?></td> <td><span class="label label-danger">Danger</span></td><td><?php echo '<u> #E: </u>'.$_SESSION["test_records_and_exports_found"][0].'<br>';  echo '<u>#R: </u>'.$_SESSION["test_records_and_exports_found"][1].'<br>'?></td></tr>

            <?php } ?>


    </tbody>
</table>




    <!-- Modal -->
    <div class="modal fade " id="ResultsModal" tabindex="-1" role="dialog" aria-labelledby="ResultsModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body clearable-content"><div class="te"></div></div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

</body>

<?php

// OPTIONAL: Display the project footer
require_once APP_PATH_DOCROOT . 'ProjectGeneral/footer.php';



