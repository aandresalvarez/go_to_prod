<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/27/17
 * Time: 12:23 PM
 */
// Call the REDCap Connect file in the main "redcap" directory
require_once "../../../redcap_connect.php";


 //echo '<pre>' . print_r($_SESSION["CalculatedFieldsErrors"], TRUE) . '</pre>';
?>




<div class="panel panel-default" width="50%">
    <!-- Default panel contents -->
    <div class="panel-heading"><div class="projhdr"> Variable Names With The Same Name Than An Event Name </div>
    </div>
    <div class="panel-body">
    </div>
    <div >
        <table id="presence_of_calculated_variables_data_table" class=" display " width="100%" cellspacing="0"></table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>

<script>

    dataSet = <?php echo json_encode($_SESSION["CalculatedFieldsErrors"])?>;

    console.log(dataSet);
    $(document).ready(function() {

        var table =  $('#presence_of_calculated_variables_data_table').DataTable({

            "paging":         false,
            "searching": false,

            data: dataSet,
            columns: [
                { title: "Instrument" },
                { title: "Variable / Field Name" },
                { title: "Field Label" },
                { title: "Missing Variable" },
                { title: "Edit" }
            ],

            "columnDefs": [
                { "visible": false, "targets": 0 },

                {"className": "dt-center", "targets": 2},
                {"className": "dt-center", "targets": 3},
                { "width": "25px", "targets": 3}

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
                            '<tr class="group"><td colspan="4"><h5><strong>Instrument: <u>'+group+'</u></strong></h5></td></tr>'

                        );

                        last = group;
                    }
                } );
            }
        } );


        // Order by the grouping
        $('#presence_of_calculated_variables_data_table tbody').on( 'click', 'tr.group', function () {
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

