<?php

include "./connexion_rest.php";

$filter_url = $instance_url . "/Contacts/filter";
if (isset($_GET['end'])) $end= $_GET['end'];
else $end = 0;
$filter_arguments = array(
    "filter" => array(
        array(
            '$or' => array(
                array(
                    //name starts with 'a'
                    "first_name" => array(
                        '$starts'=>"A",
                    )
                ),
                array(
                    //name starts with 'b'
                    "last_name" => array(
                        '$contains'=>"b",
                    )
                )
            ),
        ),
    ),
    "offset" => $end,
    'fields' =>
        array (
            0 => 'id',
            1 => 'name',
        ),
    "max_num" => 1,
    "order_by" => "first_name",
    "favorites" => false,
    "my_items" => false,
);

$filter_request = curl_init($filter_url);
curl_setopt($filter_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
curl_setopt($filter_request, CURLOPT_HEADER, false);
curl_setopt($filter_request, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($filter_request, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($filter_request, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($filter_request, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "oauth-token: {$oauth_token}"
));

//convert arguments to json
$json_arguments = json_encode($filter_arguments);
curl_setopt($filter_request, CURLOPT_POSTFIELDS, $json_arguments);

//execute request
$filter_response = curl_exec($filter_request);

//decode json
$filter_response_obj = json_decode($filter_response);

foreach( $filter_response_obj->{'records'} as $key =>$value )
    $name = $filter_response_obj->{'records'}[$key]->{'name'};
//Create Records - POST /<module>
$url = $instance_url . "/Tasks/?name=MyTest&date_entered=2020-09-28T17:15:51+00:00&date_modified=2020-09-28T17:15:51+00:00&modified_user_id=de343b44-032d-11eb-b2b6-023123a8c872&created_by=de343b44-032d-11eb-b2b6-023123a8c872&status=In%20Progress&contact_id=91ba3dac-01ae-11eb-bcea-023123a8c872&contact_name=".$name;


$curl_request = curl_init($url);
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