<?php

function engagespark_curl($number, $message) {
	$url = 'https://api.engagespark.com/v1/sms/contact';

	//create a new cURL resource
	$ch = curl_init($url);

	//setup request to send json via POST
	$data = array(
	    'orgId' => '10042',
	    'to' => $number,
	    'from' => 'hansedido',
	    'message' => $message,
	);
	$payload = json_encode($data);

	//attach encoded JSON string to the POST fields
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

	//set the content type to application/json
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Authorization:Token 074ff46351517aff2ec25f43a8ee767f19c3d349',
	    'Content-type:application/json'
	));

	//return response instead of outputting
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//execute the POST request
	$result = curl_exec($ch);

	//close cURL resource
	curl_close($ch);
	
	var_dump($result);
}

?>