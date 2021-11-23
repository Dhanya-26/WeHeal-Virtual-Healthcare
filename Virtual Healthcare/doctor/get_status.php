<?php

include("../data/connection.php");

if(isset($_POST['id'])) {
    $status = $_POST['id'];
    $appt_id = $_POST['appt_id'];
    $display_appointments = "UPDATE appointments SET status = '$status' WHERE appointments.id = '$appt_id'";
    if(mysqli_query($db, $display_appointments))
        echo json_encode("Status changed Successfully!");
    else
        echo json_encode("Something went wrong. Please try again later.");
}