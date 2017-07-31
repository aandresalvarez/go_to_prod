<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/19/17
 * Time: 7:12 PM
 */
include_once 'messages.php';

 function IsProjectAdmin(){

    // set username of the current user in project
    $this_user = USERID;

    // Get array of user privileges for a single user in project (will have username as array key)
    $rights = REDCap::getUserRights($this_user);

    // If $rights returns NULL, then user does not have access to this project
    if (empty($rights)) exit("User $this_user does NOT have access to this project.");

    // Check if user can create new records
    if ($rights[$this_user]['record_create'] or SUPER_USER==1) {
        //print "User $this_user CAN create records.\n";

        return true;
    } else {
        exit(lang('USER_RIGHTS'));
    }


}

function TextBreak($question_variable){
    global $Proj;
    // Adding : Intrument Name, instrument

    $label1=$Proj->metadata[$question_variable];
    $label1=$label1['element_label'];
    $label1=REDCap::filterHtml ( $label1 );
    $label1 = wordwrap($label1, 30, "<br />");

return $label1;
}

// Find path to redcap_connect.php
function findRedcapConnect()
{
    $dir = __DIR__;
    while ( !file_exists( $dir . "/redcap_connect.php" ) ) {
        if ($dir == dirname($dir)) {
            throw new Exception("Unable to locate redcap_connect.php");
        } else {
            $dir = dirname($dir);
        }
    }
    return $dir . "/redcap_connect.php";
}


function CleanString($string){

    // first preparing the strings.
    //for $string1
    //remove spaces at the end and convert in lowercase
    $word1=trim(strtolower($string));
    //remove spaces between words
    $word1 = str_replace(' ', '_', $word1);
    //remove tabs
    $word1 = preg_replace('/\s+/','_',$word1);
    $word1 = str_replace('__', '_', $word1);

    return $word1;
}



$protocol_number="3326";

function logIt($msg, $level = "INFO") {
//	global $custom_path;
    $custom_path = "/var/log/redcap/alvaro.log";
    file_put_contents( $custom_path,	date( 'Y-m-d H:i:s' ) . "\t" . $level . "\t" . $msg . "\n", FILE_APPEND );
}
function find_protocol($protocol_number) {
    $apiUrl = "https://api.rit.stanford.edu/irb-validity/api/v1/protocol/3326"; //. $protocol_number;
    return  invokeAPI($apiUrl);

}

function invokeAPI($apiUrl) {
    $jsonToken = json_decode(file_get_contents("classes/token.json"));
    $todaysDate = date('Y-m-d');
    // token is only valid 24 hours so if it was issued yesterday it may need refreshing
    logIt("PROBLEM refreshing API token ".print_r($jsonToken, true)." ".print_r($todaysDate,true) , "ERROR");
    if ( strcmp($todaysDate, $jsonToken->day ) != 0) {
        // dates are different, so refresh the token

        $data = array("refreshToken" => $jsonToken->refreshToken);
        $data_string = json_encode($data);

        $ch = curl_init('https://api.rit.stanford.edu/token/api/v1/refresh');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $jsonTokenStr = curl_exec($ch);
        $jsonToken = json_decode($jsonTokenStr);
        if (isset($jsonToken->refreshToken) && strlen($jsonToken->refreshToken) > 0 &&
            isset($jsonToken->accessToken) && strlen($jsonToken->accessToken) > 0 ) {
            $data = array("day" => $todaysDate, "refreshToken" => $jsonToken->refreshToken, "accessToken" => $jsonToken->accessToken);

            // now write out the resulting refresh and access tokens to the token file
            file_put_contents("classes/token.json", json_encode($data));
        } else {
             logIt("PROBLEM refreshing API token ".print_r($jsonToken, true), "ERROR");
        }
    }
    # Invoke API

    $ch = curl_init( $apiUrl );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$jsonToken->accessToken)
    );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec( $ch );

    return json_decode($response,true);
}


 //print_array(find_protocol($protocol_number));
/*$result=find_protocol($protocol_number);
$personnel = $result['personnel'];

print_array($personnel);*/