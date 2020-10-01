<?php
$instance_url = "https://sg-exotest.demo.sugarcrm.eu/rest/v11";
$username = "melissa";
$password = "3s%oHgbXEShC8ViX";

//Login - POST /oauth2/token
$auth_url = $instance_url . "/oauth2/token";

$oauth2_token_arguments = array(
    "grant_type" => "password",
    "client_id" => "melissa",
    "client_secret" => "passwordM$*",
    "username" => $username,
    "password" => $password,
);
$auth_request = curl_init($auth_url);
curl_setopt($auth_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
curl_setopt($auth_request, CURLOPT_HEADER, false);
curl_setopt($auth_request, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($auth_request, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($auth_request, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($auth_request, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json"
));

//convert arguments to json
$json_arguments = json_encode($oauth2_token_arguments);
curl_setopt($auth_request, CURLOPT_POSTFIELDS, $json_arguments);

//execute request
$oauth2_token_response = curl_exec($auth_request);

//decode oauth2 response to get token
$oauth2_token_response_obj = json_decode($oauth2_token_response);
$oauth_token = $oauth2_token_response_obj->access_token;

//convert arguments to json
$json_arguments = json_encode($oauth2_token_arguments);
curl_setopt($auth_request, CURLOPT_POSTFIELDS, $json_arguments);

//execute request
$oauth2_token_response = curl_exec($auth_request);

//get token to expire
$oauth2_token_response_obj = json_decode($oauth2_token_response);
$oauth_token = $oauth2_token_response_obj->access_token;
?>