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
$lang_vars= new messages();
//project information
global $Proj;

//echo $_SERVER['DOCUMENT_ROOT'];
//echo APP_PATH_WEBROOT;
//echo redcap_info();

// KWarning if project is  in production status
if ($status == 1)
{
    echo $lang_vars->lang('PRODUCTION_WARNING');
}

?>
    <link rel="stylesheet" href="styles/go_prod_styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <div class="projhdr"><span class="glyphicon glyphicon-check" aria-hidden="true"></span><?php echo $lang_vars->lang('TITLE');?> </div>


    <div id="main-container">
    <div><p ><?php echo $lang_vars->lang('MAIN_TEXT');?></p></div>




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
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


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
                        $(this).children('.gp-body-content').slideToggle();

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








        });






    </script>


<?php

// OPTIONAL: Display the project footer
require_once APP_PATH_DOCROOT . 'ProjectGeneral/footer.php';