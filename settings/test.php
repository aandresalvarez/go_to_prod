<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/28/17
 * Time: 4:53 PM
 */


/// you should be able to read and (666) write on tsconfig.json to be able to use this functionality.
$rule = "other_or_unknown";
$active = "TEXTO DE PRUEBA";
$type = "Warning";
$file = "tsconfig.json";
$json = json_decode(file_get_contents($file),TRUE);
echo "<pre>";
echo print_r($json);
echo "</pre>";
echo "<pre>";
echo print_r($json[$rule]);
echo "</pre>";
//$json[$rule]= array("active" => $active, "type" => $type);
$json[$rule]['active']=$active;
echo "<pre>";
echo print_r($json,true);
echo "</pre>";
file_put_contents($file, json_encode($json));
