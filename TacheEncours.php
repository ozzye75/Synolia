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
    $id = $filter_response_obj->{'records'}[$key]->{'id'};

$urlbis = "/Tasks/filter";

$filter_url = $instance_url . $urlbis;

//Setup request to only return some fields on module
$filter_arguments = array(
    "filter" => array(
        array(
            '$and' => array(
                array(
                    "status" => array(
                        '$not_equals'=> "Completed",
                    )
                ),
				array(
                    "contact_id" => array(
                        '$equals'=> $id,
                    )
                )
            ),
        ),
    ),
    "offset" => 0,
    'fields' => 
    array (
        0 => 'name',
        1 => 'status',
        2 => 'contact_id',
        3 => 'contact_name'
    ),
    "order_by" => "name",
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
$curl_response = curl_exec($filter_request);
//decode json
$record = json_decode($curl_response);

/*foreach( $record->{'tasks'}->{records} as $key =>$value )
{
  echo $value . ': <br />';
  echo $name = $record->{'tasks'}->{records}[$key]->{'name'} . "<br>";
  echo $status = $record->{'tasks'}->{records}[$key]->{'status'} . "<br>";
}*/

//display the created record
echo "<pre>";
print_r($record);
echo "</pre>";
?>