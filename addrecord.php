<?php

include "./connexion_rest.php";

//Create Records - POST /<module>
$url = $instance_url . "/Contacts/";
//Set up the Record details
$record = array(
    'first_name' => 'Aurelie',
	'last_name' => 'Cousin',
	'primary_address_street' => 'La vieille Route',
    'primary_address_city' => 'Valliquerville',
	'primary_address_postalcode' => '76190',
    'email' => array(
        array(
            'email_address' => 'monadresse@sugar.com',
            'primary_address' => true
        )
    ),
);

$curl_request = curl_init("https://sg-exotest.demo.sugarcrm.eu/rest/v11/Tasks/?name=MyTest&date_entered=2020-09-28T17:15:51+00:00&date_modified=2020-09-28T17:15:51+00:00&modified_user_id=de343b44-032d-11eb-b2b6-023123a8c872&created_by=de343b44-032d-11eb-b2b6-023123a8c872&status=In%20Progress&contact_id=91ba3dac-01ae-11eb-bcea-023123a8c872&contact_name=" . $name);
curl_setopt($curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
curl_setopt($curl_request, CURLOPT_HEADER, false);
curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_request, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($curl_request, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "oauth-token: {$oauth_token}"
));

//convert arguments to json
$json_arguments = json_encode($record);
curl_setopt($curl_request, CURLOPT_POSTFIELDS, $json_arguments);
//execute request
$curl_response = curl_exec($curl_request);
//decode json
$createdRecord = json_decode($curl_response);

//print_r($createdRecord);
curl_close($curl_request);
?>