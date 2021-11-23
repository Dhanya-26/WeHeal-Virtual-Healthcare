<?php

include("../data/connection.php");

if ($_POST['isSubmitted'] == true) {
    $appt_date = $_POST['date'];
    $doctor = $_POST['doctor'];
    $slot_id = $_POST['timings'];
//    $patient_id = $_SESSION['id'];
    $patient_id = 1;
    $insert_appointment = "INSERT INTO appointments(`date`,doctor_id,patient_id, slot_id, status) 
                            VALUES('$appt_date', '$doctor', '$patient_id', '$slot_id', 0)";

    if(mysqli_query($db, $insert_appointment)) {
        echo "Success!";
    } else {
        echo "Something went wrong, please try again later.";
    }
}

if (isset($_POST["date"]) && !$_POST['isSubmitted']) {
    $date = $_POST["date"];
    $doctor_id = $_POST["doctor"];
    $slots = array();
    $display_slots = "SELECT id, timings FROM slots WHERE id NOT IN (SELECT slot_id FROM appointments
                            WHERE appointments.doctor_id = '$doctor_id' AND appointments.date = '$date')";
    $slots_query = mysqli_query($db, $display_slots);

    while ($slot = mysqli_fetch_assoc($slots_query)) {
        $slots[] = $slot;
    }
    echo json_encode($slots);
}

if (isset($_POST["speciality"]) && !$_POST['isSubmitted']) {
    $speciality = $_POST["speciality"];
    $doctors = array();
    $display_doctors = "SELECT f_name, l_name, doctor_details.id AS 'doctor_id' FROM doctor_details 
                                    JOIN personal_details ON doctor_details.p_id = personal_details.id 
                                    WHERE doctor_details.speciality = '$speciality'";
    $doctors_query = mysqli_query($db, $display_doctors);

    while ($doctor = mysqli_fetch_assoc($doctors_query)) {
        $doctors[] = $doctor;
    }
    echo json_encode($doctors);
}
