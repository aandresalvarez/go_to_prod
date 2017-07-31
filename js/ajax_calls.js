/**
 * Created by alvaro1 on 4/12/17.
 */


$( document ).ready(function() {

   // $('#go_prod_go_btn').html('Run');
    $("#go_prod_go_btn").click(function(){
        //time out in case a big datadictionary
        var timer = window.setTimeout(function(){
            $('#gp-loader-extra-time').fadeIn(2000);
        }, 10000);

        $('#gp-loader').show();
        $(this).prop("disabled",true);

        $.ajax({url: "classes/ajax_handler.php?pid="+project_id, success: function(result){
            $('#go_prod_table').fadeIn();
            $('#final-info').fadeIn("slow");
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
           // $('#go_prod_go_btn').html('Run again');

            $('#go_prod_go_btn').click(function() {
                $('#go_prod_table').hide();
                $('#final-info').hide();

            });

        }});
    });



    console.log( "ready CO!" );

});
