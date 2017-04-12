<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/17/17
 * Time: 12:45 AM
 */
// large proj for testing 5749 , PID 9748 5292
// Call the REDCap Connect file in the main "redcap" directory
require_once "../../redcap_connect.php";


// OPTIONAL: Display the project header
require_once APP_PATH_DOCROOT . 'ProjectGeneral/header.php';
require_once 'classes/messages.php';
require_once 'classes/utilities.php';

// Check if user can create new records, if not Exit.
 //IsProjectAdmin();

//project information
global $Proj;

//echo $_SERVER['DOCUMENT_ROOT'];
//echo APP_PATH_WEBROOT;
//echo redcap_info();

// Warning if project is in production mode
if ($status == 1)
{
    echo lang('PRODUCTION_WARNING');
}


$data_dictionary_array = REDCap::getDataDictionary('array');
/*echo "<pre>";
echo print_array($data_dictionary_array);
echo "</pre>";*/


?>
<link rel="stylesheet" href="styles/go_prod_styles.css">


    <div class="projhdr"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> <?php echo lang('TITLE');?> </div>
    <div id="main-container">
        <div><p><?php echo lang('MAIN_TEXT');?></p></div>
        <button id="go_prod_go_btn" class=" btn btn-lg btn-primary"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span><?php echo lang('RUN');?> </button>
        <hr>
        <table  id="go_prod_table" style="display: none"  class="table table-striped" >
                <thead>
                <tr>
                    <th><strong></strong></th>
                    <th><h4 class="projhdr"><?php echo lang('VALIDATION');?> </h4></th>
                    <th><h4 class="projhdr"><?php echo lang('RESULT');?></h4></th>
                    <th><h4 class="projhdr"><?php echo lang('OPTIONS');?></h4></th>
                </tr>
                </thead>
                                 <!--INITIAL RESULTS ARE LOADED HERE-->
                <tbody id="go_prod_tbody">
                </tbody>
        </table>
         <div id="gp-loader"  style="display: none"  ><div  class="loader"></div></div>
        <div id="gp-loader-extra-time"  style="display: none"   ><div class="alert alert-info fade in" role="alert"><?php echo lang('LOADING_EXTRA_TIME');?></div></div>
    </div>


    <!--REUSABLE MODAL -->
    <div id="ResultsModal" class="modal fade">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <p><?php echo lang('LOADING');?></p>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <!--Ajax calls -->
    <script> var project_id=<?php echo $_GET['pid']; ?>;</script>
    <script type="text/javascript" src="js/ajax_calls.js"> </script>




<?php

// OPTIONAL: Display the project footer
require_once APP_PATH_DOCROOT . 'ProjectGeneral/footer.php';