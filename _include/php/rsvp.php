<?php

function rsvp_submission()
{
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
    $result = $wpdb->get_row($query);

    if ($result == null) {
        $response['error'] = true;
        $response['ecode'] = 'NOT_FOUND';
        exit(json_encode($response));
    }

    // Update attendance value
    $update_query = "UPDATE $table_name SET attendance = " . $data["attendance"] . ", message = '" . $data["message"] . "' WHERE id = %d";
    $wpdb->query($wpdb->prepare($update_query, $result->id));

    // Send confirmation email
    $message = file_get_contents(get_template_directory() . '/emails/rvsp/confirmation.html');

    mail($result->email, "[han-sed-i-do] Attendance Confirmation", $message);

    exit(json_encode($response));
}

rsvp_submission();

?>