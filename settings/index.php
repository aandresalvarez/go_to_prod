<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 5/1/17
 * Time: 3:46 PM
 */

// Call the REDCap Connect file in the main "redcap" directory
require_once "../../../redcap_connect.php";

// echo '<pre>' . print_r($_SESSION["NotDesignatedFormsErrors"], TRUE) . '</pre>';
require  '../classes/messages.php';

// OPTIONAL: Display the project header
require_once APP_PATH_DOCROOT . 'ProjectGeneral/header.php';

//$file = "../settings/tsconfig.json";
$file = "tsconfig.json";

$json = json_decode(file_get_contents($file),TRUE);







?>

<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative !important;
        display: inline-block !important;
        width: 40px !important;
        height: 24px !important;
    }

    /* Hide default HTML checkbox */
    .switch input {display:none !important;}

    /* The slider */
    .slider {
        position: absolute !important;
        cursor: pointer !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        background-color: #ccc !important;
        -webkit-transition: .4s !important;
        transition: .4s !important;
    }

    .slider:before {
        position: absolute !important;
        content: "" !important;
        height: 16px !important;
        width: 16px !important;
        left: 4px !important;
        bottom: 4px !important;
        background-color: white !important;
        -webkit-transition: .4s !important;
        transition: .4s !important;
    }

    input:checked + .slider {
        background-color: #2196F3 !important;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3 !important;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(16px) !important;
        -ms-transform: translateX(16px) !important;
        transform: translateX(16px) !important;
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 24px !important;
    }

    .slider.round:before {
        border-radius: 50% !important;
    }

    textarea {


        padding: 5px !important;
        resize: both !important;
        overflow: auto !important;
    }


</style>
<body>

<div class="container">
    <h2>Go to Prod Setup </h2>
    <p>Here you can activate/deactivate rules and also change the default options for each one. </p>
    <table id="settings" class="display compact cell-border " cellspacing="0" width="80%">
        <thead>
        <tr>
            <th>Rule/Checklist</th>
            <th>Options</th>
            <th>Alert Level</th>
            <th>Active</th>

        </tr>
        </thead>
        <tbody>

        <tr>
            <td class="dt-body-left"><?php echo lang('OTHER_OR_UNKNOWN_TITLE');?></td>


            <td>
                <div>
                    <div><strong>Recommended codes for "other" and/or "unknown":</strong></div>
                    <textarea   class="form-control" rows="1" title="" cols="45" id="other-unknown-recommended-values" name="other-unknown-recommended-values" > <?php  echo $json['other_or_unknown']['recommended_values']; ?></textarea>
                </div>
                <div>
                    <div><strong>Keywords:</strong></div>
                    <textarea   class="form-control" rows="3"  title="" cols="45" id="other-unknown-keywords" name="other-unknown-keywords" ><?php  echo $json['other_or_unknown']['keywords']; ?> </textarea>
                </div>

                <div>
                    <div><strong>Similarity:</strong></div>
                    <input type="number"   id="other-unknown-similarity" name="other-unknown-similarity" value="<?php  echo $json['other_or_unknown']['similarity']; ?>" min="50" max="100" title="">
                </div>


            </td>


            <td class="dt-body-center">
                <select size="1" id="other-unknown-alert-level" name="other-unknown-alert-level"  title="other-unknown-alert-level">
                    <option value="<?php echo lang('INFO');?>" <?php  if (strtolower($json['other_or_unknown']['type'])== strtolower(lang('INFO'))) echo "selected=\"selected\""; ?> >
                        <?php echo lang('INFO');?>
                    </option>
                    <option value=" <?php echo lang('WARNING');?>" <?php  if (strtolower($json['other_or_unknown']['type'])==strtolower(lang('WARNING'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('WARNING');?>
                    </option>
                    <option value="<?php echo lang('DANGER');?>" <?php  if (strtolower($json['other_or_unknown']['type'])==strtolower(lang('DANGER'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('DANGER');?>
                    </option>

                </select>
            </td>
            <td class="dt-body-center">
                <label class="switch">
                    <input type="checkbox" name="other-active-selected" value="" <?php  if ($json['other_or_unknown']['active']) echo "checked"; ?>>
                    <div class="slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> <div align="right"> <button type="button" class="btn btn-primary">Save</button></div></td>
        </tr>
        </tbody>
    </table>


</div>

<script>

    dataSet  = <?php echo json_encode($json)?>;

    function Update(settings_array, data) {





        console.log(settings_array);




        //return p1 * p2;              // The function returns the product of p1 and p2
    }


    // console.log(dataSet);
    $(document).ready(function() {

        // Update(dataSet);

        var table =  $('#settings').DataTable({
            'responsive': true,
            "searching": false,
            "ordering": false,
            "bInfo" : false,
            "paging": false,
            "columnDefs": [
                { "width": "45%", "targets": 0 },
                { "width": "40%", "targets": 1 },
                { "width": "10%", "targets": 2 },
                { "width": "5%", "targets": 3 },
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   3
                }
            ],select: {
                style:    'os',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]]


        });



        $('button').click( function() {
            var dataset = table.$('input, select, textarea ').serialize();//input, select, textarea, checkbox



            $.ajax({type: "POST",
                    data:dataset,
                    url:'save.php',
                    success: function (result){
               // $("#div1").html(result);
               // window.location.href = "save";
                 location.reload();

                 alert(
                    "The following data would have been submitted to the server: \n\n"
                    //+ data.substr( 0, 120 )+'...'
                );


            }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("some error");
                }

            });

            // console.log(data=>other-unknown-keywords);
            console.log(dataset);
            return false;
        } );


    } );


</script>