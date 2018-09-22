<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/18/17
 * Time: 11:51 AM
 */


// Call the REDCap Connect file in the main "redcap" directory
require_once "../../../redcap_connect.php";

require  '../classes/messages.php';
// echo '<pre>' . print_r($_SESSION["QueueLogicErrors"], TRUE) . '</pre>';
?>

<div class="panel panel-default" width="50%">
    <!-- Default panel contents -->
    <div class="panel-heading"><div class="projhdr">  <?php echo lang('QUEUE_LOGIC_TITLE')?> </div>
    </div>
    <div class="panel-body">
    </div>
    <div >
        <table id="queue_logic_data_table" class=" display " width="100%" cellspacing="0"></table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('CLOSE')?></button>
    </div>
</div>

<script>

    dataSet = <?php echo json_encode($_SESSION["QueueLogicErrors"])?>;


    $(document).ready(function() {

        $('#queue_logic_data_table').DataTable({

            "paging":         false,
            "searching": false,

            data: dataSet,
            columns: [
                { title: "Instrument" },
                { title: "Event Name (if Longitudinal)" },
                { title: "Missing Variable" },
                { title: "Edit" }
            ],

            "columnDefs": [


                {"className": "dt-center", "targets": 2},
                {"className": "dt-center", "targets": 3},
                { "width": "25px", "targets": 3}

            ],
            "order": [[ 0, 'asc' ]],
            "displayLength": 15

        } );



    } );

</script>

