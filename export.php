<?php

include "./connexion_rest.php";

//Identify records to export - POST /<module>/filter

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
        0 => 'name',
        1 => 'primary_address_street',
        2 => 'primary_address_city',
        3 => 'primary_address_state',
        4 => 'primary_address_postalcode',
		5 => 'primary_address_country',
        6 => 'email',
    ),
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


$end = $filter_response_obj->{'next_offset'};

foreach( $filter_response_obj->{'records'} as $key =>$value )
{
  echo $key . ': <br />';
  echo $name = $filter_response_obj->{'records'}[$key]->{'name'} . "<br>";
  echo $primary_address_street = $filter_response_obj->{'records'}[$key]->{'primary_address_street'} . "<br>";
  echo $primary_address_city = $filter_response_obj->{'records'}[$key]->{'primary_address_city'} . "<br>";
  echo $primary_address_state = $filter_response_obj->{'records'}[$key]->{'primary_address_state'} . "<br>";
  echo $primary_address_postalcode = $filter_response_obj->{'records'}[$key]->{'primary_address_postalcode'} . "<br>";
  echo $primary_address_country = $filter_response_obj->{'records'}[$key]->{'primary_address_country'} . "<br>";
  echo $email = $filter_response_obj->{'records'}[$key]->{'email'}[0]->{'email_address'} . "<br><br><br>";
}
if ($filter_response_obj->{'next_offset'} != -1)
echo "<a href='export.php?end=".$end."'>Page suivante</a>";
else
echo "<a href='export.php'>Retour</a>";	
?>