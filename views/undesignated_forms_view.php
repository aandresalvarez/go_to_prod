<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/14/17
 * Time: 12:23 PM
 */
// Call the REDCap Connect file in the main "redcap" directory
require_once "../../../redcap_connect.php";

    // echo '<pre>' . print_r($_SESSION["NotDesignatedFormsErrors"], TRUE) . '</pre>';
require  '../classes/messages.php';

?>




<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><div class="projhdr"> <?php echo lang('NOT_DESIGNATED_FORMS_TITLE')?> </div>
    </div>
    <div class="panel-body">
    </div>
    <div style="padding: 1px">
        <table id="not_designated_forms" class=" display " width="100%" cellspacing="0"></table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('CLOSE')?></button>
    </div>
</div>

<script>



    dataSet = <?php echo json_encode($_SESSION["NotDesignatedFormsErrors"])?>;

    //console.log(dataSet);
    $(document).ready(function() {
        $('#not_designated_forms').DataTable( {
            data: dataSet,
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false,
            columnDefs: [
                { "title": "Unique Instrument Name",   "targets": 0},
                { "title": "Instrument Label",  "targets": 1 },
                { "title": "Designate Instruments for My Events",  "targets": 2 },
                {"className": "dt-center", "targets": 1},
                {"className": "dt-left", "targets": 0},
                {"className": "dt-center", "targets": 2},
                 { "width": "25px", "targets": 2}
            ],
            columns: [

                { "data": 0 },
                { "data": 1 },
                { "data": 2 }


            ]

        } );
    } );




</script>

