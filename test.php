<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/17/17
 * Time: 12:45 AM
 */

// Call the REDCap Connect file in the main "redcap" directory
require_once "../../redcap_connect.php";


// OPTIONAL: Display the project header
require_once APP_PATH_DOCROOT . 'ProjectGeneral/header.php';
require_once 'classes/messages.php';
require_once 'classes/check_user_rights.php';


// Check if user can create new records, if not Exit.
IsProjectAdmin();




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
//echo "<pre>";
 //print_r($Proj);
// echo "</pre>";
?>
<link rel="stylesheet" href="styles/go_prod_styles.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>








    <div class="projhdr"><span class="glyphicon glyphicon-check" aria-hidden="true"></span><?php echo lang('TITLE');?> </div>
    <div id="main-container">
        <div><p ><?php echo lang('MAIN_TEXT');?></p></div>
        <button id="go_prod_go_btn" class=" btn btn-lg btn-primary btn-run"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...</button>
        <hr>
        <table  id="go_prod_table" class="table table-striped " >
                <thead>
                <tr>
                    <th><strong></strong></th>
                    <th><strong>Validation</strong></th>
                    <th><strong>Result</strong></th>
                    <th><strong>Options</strong></th>
                </tr>
                </thead>
                <tbody id="go_prod_tbody">
                </tbody>
        </table>

        <div id="gp-loader" ><div  class="loader"></div></div>
    </div>







    <div id="ResultsModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Event</h4>
                </div>
                <div class="modal-body">
                    <p>Loading...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Event modal -->






    <script>


        $( document ).ready(function() {

            $('#go_prod_table').hide();
            $('#gp-loader').hide();
            $('#go_prod_go_btn').html('Run'); // Show "Downloading..."
            //$('#go_prod_tbody').load("classes/check_main.php?pid=<php echo $_GET['pid']; ?>");

            $("#go_prod_go_btn").click(function(){
                $('#gp-loader').show();
                $(this).prop("disabled",true);
                //$(this).hide();
                $.ajax({url: "classes/ajax_handler.php?pid=<?php echo $_GET['pid']; ?>", success: function(result){
                    $('#go_prod_table').show();
                    $('#gp-loader').hide();

                    $("#go_prod_tbody").html(result);
                    $('.gp-info-content').css( 'cursor', 'pointer' );

                    $('.gp-tr').hover(function(){
                        $(this).css("background","#d9e1f9");
                    },function(){
                        $(this).css("background","");
                    });
                    $('.gp-info-content').children('.gp-body-content').hide();

                    // $('.glyphicon-menu-down').hide();
                    $('.gp-info-content').on('click', function(e) {
                        e.preventDefault();
                        console.log( "entro al hidden modal" );
                        $(this).children('.gp-body-content').slideToggle();

                    });


                    /* This code load the content of the link in the same modal */
                    $(function() {
                        $('[data-load-remote]').on('click',function(e) {
                            e.preventDefault();
                            var $this = $(this);
                            var remote = $this.data('load-remote');
                            if (!$this.data('isloaded')) {
                                if(remote) {
                                    $($this.data('remote-target')).load(remote);
                                    $this.data('isloaded', true)
                                }
                            }
                        });
                    });




                    $('#go_prod_go_btn').prop("disabled",false);
                    $('#go_prod_go_btn').html('Run again');

                    $('#go_prod_go_btn').click(function() {
                        //$("#go_prod_tbody").html('');
                        $('#go_prod_table').hide();

                    });

                }});
            });

            console.log( "ready!" );
            //$('#ResultsModal').onHide().removeData('modal');
           /* $("#ResultsModal").on('hidden.bs.modal', function () {
                // $(this).data('bs.modal', null);


               // $(this).removeData('bs.modal');


                // $(this).text('default-label');
                //$(this).html('');

                console.log("ENTRO!!!");
            });*/

        });

    </script>

<?php

// OPTIONAL: Display the project footer
require_once APP_PATH_DOCROOT . 'ProjectGeneral/footer.php';