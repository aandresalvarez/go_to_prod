<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 5/8/17
 * Time: 1:19 PM
 */


if ( !$_SERVER['REQUEST_METHOD'] == 'POST'  ) {
    exit();
}

$file = "tsconfig.json";
$json = json_decode(file_get_contents($file),TRUE);
//$json[$rule]= array("active" => $active, "type" => $type);





if (!empty($_POST["other-unknown-recommended-values"])) { $json['other_or_unknown']['recommended_values']=trim($_POST["other-unknown-recommended-values"]); }
if (!empty($_POST["other-unknown-keywords"])) { $json['other_or_unknown']['keywords']=trim($_POST["other-unknown-keywords"]); }
if (!empty($_POST["other-unknown-similarity"])) { $json['other_or_unknown']['similarity']=trim($_POST["other-unknown-similarity"]); }
if (!empty($_POST["other-unknown-alert-level"])) { $json['other_or_unknown']['type']=trim($_POST["other-unknown-alert-level"]); }
if (!empty($_POST["other-active-selected"])) { $json['other_or_unknown']['active']=trim($_POST["other-active-selected"]); }



file_put_contents($file, json_encode($json));