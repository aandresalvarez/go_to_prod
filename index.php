<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/17/17
 * Time: 12:45 AM
 */
// large proj for testing 5749
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


?>
<link rel="stylesheet" href="styles/go_prod_styles.css">


    <div class="projhdr"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> <?php echo lang('TITLE');?> </div>
    <div id="main-container">
        <div><p><?php echo lang('MAIN_TEXT');?></p></div>
        <button id="go_prod_go_btn" class=" btn btn-lg btn-primary"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <?php echo lang('LOADING');?></button>
        <hr>
        <table  id="go_prod_table" class="table table-striped" >
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
         <div id="gp-loader" ><div  class="loader"></div></div>
        <div id="gp-loader-extra-time"  ><div class="alert alert-info fade in" role="alert"><?php echo lang('LOADING_EXTRA_TIME');?></div></div>
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
    <!-- Event modal -->

    <script>


         $('#go_prod_table').hide();
         $('#gp-loader').hide();
         $('#gp-loader-extra-time').hide();

        $( document ).ready(function() {

            $('#go_prod_go_btn').html('Run');
            $("#go_prod_go_btn").click(function(){
                //time out in case a big datadictionary
                var timer = window.setTimeout(function(){
                    $('#gp-loader-extra-time').fadeIn(2000);
                }, 10000);

                $('#gp-loader').show();
                $(this).prop("disabled",true);

                $.ajax({url: "classes/ajax_handler.php?pid=<?php echo $_GET['pid']; ?>", success: function(result){
                    $('#go_prod_table').show();

                    if(timer) {
                        clearTimeout(timer);
                        $('#gp-loader-extra-time').hide();
                    };
                    $('#gp-loader').hide();

                    $("#go_prod_tbody").html(result);

                    $('.gp-info-content').css( 'cursor', 'pointer' );
                    $('.gp-tr').hover(function(){
                        $(this).css("background","#d9e1f9");
                    },function(){
                        $(this).css("background","");
                    });
                    $('.gp-info-content').children('.gp-body-content').hide();

                    $('.gp-info-content').on('click', function(e) {
                        e.preventDefault();
                        var find_more=$(this).find('.title-text-plus');
                         //console.log( find_plus );
                        if (find_more.text() == '(more)')
                            find_more.text('(less)');
                        else
                            find_more.text('(more)');
                        $(this).children('.gp-body-content').slideToggle();
                    });

                    /*this code remove the content from the modal when is closed */
                    $("#ResultsModal").on('hidden.bs.modal', function (e) {
                        e.preventDefault();
                    });

                    /* This code load the content of the link in the same modal */
                    $(function() {
                        $('[data-load-remote]').on('click',function(e) {
                            e.preventDefault();
                            var $this = $(this);
                            var remote = $this.data('load-remote');
                                if(remote) {
                                    $($this.data('remote-target')).load(remote);
                                    $this.data('isloaded', true)
                                }
                        });

                    });

                    $('#go_prod_go_btn').prop("disabled",false);
                    $('#go_prod_go_btn').html('Run again');

                    $('#go_prod_go_btn').click(function() {
                        $('#go_prod_table').hide();
                    });

                }});
            });

            console.log( "ready CO!" );

        });

    </script>

<?php

// OPTIONAL: Display the project footer
require_once APP_PATH_DOCROOT . 'ProjectGeneral/footer.php';