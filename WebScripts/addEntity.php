<?php
header('Content-Type: application/json');

$apiLink = "https://api.api.ai/v1/";
$entity = $_GET['entity'];
$thing = $_GET['object'];
$apiKey = $_GET['api'];
$entityLink = $apiLink."entities/".$entity."/entries?v=20150910";
$data_string = "[{\"value\": \"$thing\",\"synonyms\": [\"$thing\"]}]";

// Initiate curl
$ch = curl_init();

// Set The Response Format to Json
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json','Authorization:Bearer '.$apiKey));
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//send post fields data
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
// Set the url
curl_setopt($ch, CURLOPT_URL,$entityLink);

// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);
echo $result;
?>
