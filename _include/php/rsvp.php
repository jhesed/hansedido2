<?php
header("Access-Control-Allow-Origin: *");
require "db_config.php";
require "itextmo.php";

/* Handles RSVP reservation logic */

// Initialization
$table_name = "jh_guests";
$response = array(
    'error' => false
);
$data = array();

// Retrieve parameters
$data['first_name'] = strtolower(trim($_POST['first-name']));
$data['last_name'] = strtolower(trim($_POST['last-name']));
$data['message'] = trim($_POST['message']);
$data['attendance'] = intval($_POST["attendance"]);
$response['attendance'] = $data['attendance'];

// Basic validation
if ($data['first_name'] == '' || $data['last_name'] == '') {
    $data['error'] = true;
    exit(json_encode($data));
}

// Data validation
$query = "SELECT * FROM $table_name WHERE first_name = '" . $data["first_name"] . "' and last_name = '" . $data["last_name"] . "'";
$result = $mysqli->query($query)->fetch_object();

if ($result == null) {
    $response['error'] = true;
    $response['ecode'] = 'NOT_FOUND';
    exit(json_encode($response));
}
if ($result->attendance == 1 || $result->attendance == 2) {
    $response['error'] = true;
    $response['ecode'] = 'DUPLICATE';
    exit(json_encode($response));   
}

if ($data["attendance"] == 2) {
    $message = file_get_contents('../../emails/rsvp/rejection.html');
    $text_message = "We regret that you won't be able to attend our wedding. See you some other time! - hansedido";
}
else {
    $message = file_get_contents('../../emails/rsvp/confirmation.html');
    $text_message = "Thank you for confirming your attendance at our wedding. See you at Feb 25! - hansedido";
}
$message = str_replace('{USER}', ucwords($data["first_name"]), $message);

// Update attendance value
$update_query = "UPDATE $table_name SET attendance = " . $data["attendance"] . ", message = '" . $data["message"] . "' WHERE id = " . $result->id;

$mysqli->query($update_query);    

// Send confirmation email
$headers = "From: " . strip_tags("rsvp@hansedido.com") . "\r\n";
$headers .= "Reply-To: ". strip_tags("rsvp@hansedido.com") . "\r\n";
$headers .= "CC: jhesed.tacadena@gmail.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$subject = "[han-sed-i-do] Attendance Confirmation";

if ($result->email != null or $result->email != ""){
    mail($result->email, $subject, $message, $headers);
}

if ($result->mobile != null or $result->mobile != ""){
    // itexmo_curless($result->mobile, $text_message);
    itexmo_curl($result->mobile, $text_message);
}

exit(json_encode($response));

?>