<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/14/17
 * Time: 12:23 PM
 */
// Call the REDCap Connect file in the main "redcap" directory
require_once "../../../redcap_connect.php";
require  '../classes/messages.php';
//print_r( $_SESSION["OtherOrUnknownErrors"]);

// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
//echo  $_SESSION["t"];
//echo '<pre>' . print_r($_SESSION["OtherOrUnknownErrors"], TRUE) . '</pre>';
?>
<link rel="stylesheet" href=" styles/go_prod_styles.css">

<div class="panel panel-default">
   <!-- Default panel contents -->
    <div class="panel-heading"><div class="projhdr"> <?php echo lang('OTHER_OR_UNKNOWN_TITLE')?> </div></div>
    <div class="panel-body">

    </div>
    <div style="padding: 1px">
    <!-- Table -->
    <table id="other_or_unknown_data_table" class=" display " width="100%" cellspacing="0"></table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('CLOSE')?></button>

    </div>

</div>




<script>

    dataSet = <?php echo json_encode($_SESSION["OtherOrUnknownErrors"])?>;


    $(document).ready(function() {

        var table =  $('#other_or_unknown_data_table').DataTable({

             "paging":         false,
            "searching": false,

            data: dataSet,
            columns: [
                { title: "Instrument " },
                { title: "Variable / Field Name" },
                { title: "Field Label" },
                { title: "Options/Choices" },
                { title: "Edit" }
            ],

            "columnDefs": [
                { "visible": false, "targets": 0 },
                {"className": "dt-left", "targets": 2},
                {"className": "dt-left", "targets": 3},

                {"className": "dt-center", "targets": 4},
                { "width": "25px", "targets": 4}

            ],
            "order": [[ 0, 'asc' ]],
            "displayLength": 15,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="4"><h5>Instrument: <strong><u>'+group+'</u></strong></h5></td></tr>'

                        );

                        last = group;
                    }
                } );
            }
        } );


        // Order by the grouping
        $('#other_or_unknown_data_table tbody').on( 'click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
                table.order( [ 0, 'desc' ] ).draw();
            }
            else {
                table.order( [ 0, 'asc' ] ).draw();
            }
        }











        );
    } );

</script>

