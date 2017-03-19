<?php
/**
 * PLUGIN NAME: Name Of The Plugin
 * DESCRIPTION: A brief description of the Plugin.
 * VERSION: 0.1
 * AUTHOR: Name Of The Plugin Author
 */

// Call the REDCap Connect file in the main "redcap" directory
require_once "../../redcap_connect.php";

// OPTIONAL: Your custom PHP code goes here. You may use any constants/variables listed in redcap_info().

// OPTIONAL: Display the project header
require_once APP_PATH_DOCROOT . 'ProjectGeneral/header.php';

//including checks
include 'check_other_or_unknown.php';
include 'check_consistency_for_lists.php';
include 'check_identifiers.php';
include 'check_pi_irb_type.php';
include 'check_consistency_for_dates.php';
include 'check_presence_of_branching_logic_variables.php';
include 'check_test_records.php';

//Call the Data Dictionary
$dd_array = REDCap::getDataDictionary('array');

//classes








$test_records = new check_test_records;
$result= $test_records::GetTestRecordsAndExports();


echo "<pre>";
print_array($result);

echo "</pre>";



?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<!-- Title and Descrition -->
<div class="container col-xs-12">
		<h3 class="projhdr">Check List For Going to production</h3>
		<hr>
		<br>










		<!-- End Title and Descrition -->
    <div><strong><H3>PI and IRB information is incomplete</H3></strong></div>


    <?php


    /*
     *         *PI and IRB information is incomplete
     */

    $irb= new check_pi_irb;
    global $Proj;
    echo "<pre>";
    //echo $irb::PIExist($Proj);
    if($irb::PIExist($Proj)) {
        echo " PI - NO problems found!";
    }
    else {
        echo "<b class=\"bg-primary\">PI Information Is incomplete</b><br>";
    }

    if ($irb::IRBExist($Proj)) {
        echo " OK-IRB - NO problems found!";
    } else {
        echo "<b class=\"bg-primary\">IRB Information Is incomplete</b> <br>";
    }

    if ($irb::IsAResearchProjec($Proj)) {
        echo " This Is a Research project!";
    }
    else {
        echo '<p> The purpose of this project is "<b>Not for Research</b>" There is no reason to move this project into production mode.  There are NO additional features that are enabled when moving to production.  You can test and even collect data in development mode.</p>';
    }

    echo "</pre>";

    ?>
    <div><strong><H3>Identifiers.</H3></strong></div>


    <?php

    /*
        *Yθ	No fields are marked as identifiers – use Check for Identifiers Tool.
        */
    $identifiers= new check_identifiers;
    echo "<pre>";
    if ($identifiers::AnyIdentifier($dd_array)) {
        echo "NO problems found!";
    } else {
        echo "<b class=\"bg-primary\">No fields are marked as identifiers – use Check for Identifiers Tool.</b>";
    }
    echo "</pre>";

    ?>




<div><strong><H3>OTHER OR UNKNOWN</H3></strong></div>
	<?php	

/*
 *PRINT OTHER OR UNKNOWN
 */

 $other_or_unknown = new check_other_or_unknown;

$result= $other_or_unknown::CheckOtherOrUnknown($dd_array,90);
if (empty($result)){
    echo '<pre>';
    echo "NO problems found!";
    echo '</pre>';
}else{
?>
<pre>
        <p>Incorrect Coding of 'Other' and 'Unknown' values in dropdown lists </p>
        <table id="other" class="table striped   " cellspacing="0" width="100%" style="margin: 0 auto">
            <thead>
                <tr>
                <th>Form Name</th>
                    <th>Variable Name</th>
                    <th>Id</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Form Name</th>
                <th>Variable Name</th>
                <th>Id</th>
                <th>Value</th>
            </tr>
            </tfoot>
            <tbody>
          <?php   foreach ($result as $item){  ?>
            <tr>
              <td><?php echo $item[0]; ?></td>
                <td>[<?php echo $item[1]; ?>]</td>
                <td><?php echo $item[2]; ?></td>
                <td><?php echo $item[3]; ?></td>
                <?php } ?>
            </tr>
            </tbody>


        </table>
</pre>

<?php }  ?>


<div><strong><H3>Yes Or No Inconsistencies</H3></strong></div>

<?php
/*
   *Yes Or Not Inconsistencies
   */

$consistency = new check_consistency_for_lists;
$is_yes_no_consistent=$consistency::IsYesNoConsistent($dd_array);

echo "<pre>";
if (empty($is_yes_no_consistent)) {
    echo "NO problems found!";

} else {
    echo " <b class=\"bg-primary\">We found Different coding for (Yes/No) fields – should be coded consistently.</b>";
    print_r($is_yes_no_consistent);
}
echo "</pre>";

?>

<div><strong><H3>Positive/Negative Inconsistencies</H3></strong></div>
    <?php
    /*
       *Positive/ Negative Inconsistencies
       */
$is_positive_negative_consistent=$consistency::IsPositiveNegativeConsistent($dd_array);
echo "<pre>";
if (empty($is_positive_negative_consistent)) {
        echo "NO problems found!";

    } else {
        echo "<b class=\"bg-primary\"> We found Different coding for (Positive/Negative) fields – should be coded consistently.</b>";
        print_r($is_positive_negative_consistent);
    }
echo "</pre>";

    ?>

    <div><strong><H3> Date Format Inconsistencies</H3></strong></div>
    <?php
    /*
       *Date format Inconsistencies
       */
    $date_consistency = new check_consistency_for_dates;
    $is_date_consistent=$date_consistency::IsDateConsistent($dd_array);
    echo "<pre>";
    if (empty($is_date_consistent)) {
        echo "NO problems found!";

    } else {
        echo "<b class=\"bg-primary\"> We found Different coding for Date fields – should be coded consistently.</b>";
        print_r($is_date_consistent);
    }
    echo "</pre>";

    ?>
    <div><strong><H3> Branching Logic (including event names if longitudinal) Inconsistencies</H3></strong></div>
<?php
    $branching= new check_presence_of_branching_logic_variables;
    $test3=$branching::CheckIfBranchingLogicVariablesExist($dd_array);

    //$events = REDCap::getEventNames(false, true);
if(empty($test3)){
    echo "<pre>";

    echo "NO problems found!";

    echo "</pre>";
}else{
    echo "<pre <b class=\"bg-primary\">";

    print_r($test3);
    echo "</b></pre>";
}


?>



</div>	<!-- container  Timeline finish here -->


    <!-- Script for Datatables -->
    <script>
        $(document).ready(function() {
            $('#other').DataTable();

        } );
    </script>

<?php
// OPTIONAL: Display the project footer
require_once APP_PATH_DOCROOT . 'ProjectGeneral/footer.php';



