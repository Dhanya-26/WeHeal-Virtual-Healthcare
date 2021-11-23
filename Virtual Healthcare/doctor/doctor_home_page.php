<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Smart medical service</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../assets/icon.png" rel="icon">

<body id="body-container" class="container" style="background-color: #F8F8FF; padding: 0px; max-width: 100%; height: 90vh;">

<?php
session_start();
include("../data/connection.php");
$doctor_id = $_SESSION['id'];
?>
<script>
    $(document).ready(function() {
        $(".dropdown-item").on('click', function(){
            id = $(this).attr('id');
            appt_id = $(this).attr("appt_id")
            itemText = "";
            buttonText = "";
            if(id == '1') {
                itemText = "Reject";
                buttonText = "Confirmed";
                className = "btn btn-success dropdown-toggle show";
            }
            else {
                itemText = "Confirm";
                buttonText = "Rejected";
                className = "btn btn-danger dropdown-toggle show";
            }
            $(this).parents('.dropdown').find('button').text(buttonText);
            $(this).parents('.dropdown').find('button').attr("class", className);

            $('.dropdown-item').empty();
            $('.dropdown-item').text(itemText);

            if(id == '1') {
                $('.dropdown-item').attr('id', '2');
            }
            else {
                $('.dropdown-item').attr('id', '1');
            }

            $.ajax({
                type: "POST",
                url: "get_status.php",
                data: {
                    id: $(this).attr('id'),
                    appt_id: $(this).attr("appt_id")
                }
            }).done(function(status){
                status = JSON.parse(status)
                alert(status);
            });
        });
    });
</script>
<nav class="navbar navbar-light" style="background-color: #00000063;">
    <div class="container-fluid">
        <a href="../index.html" class="navbar-brand logo">
            <img src="../assets/LOLOL.png" class="d-inline-block align-text-top" alt="Logo" height="50px" width="50px">
        </a>
        <a class="navbar-brand" href="../index.html"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
        <a class="navbar-brand" href="../wehealaboutus.html"><i class="fa fa-users"></i>About Us</a>
        <a class="navbar-brand" href="../wehealservices.html"><i class="fa fa-cog" aria-hidden="true"></i>Services</a>
        <a class="navbar-brand" href="../index.html"><i class="fa fa-address-card-o" aria-hidden="true"></i>Logout</a>
    </div>
</nav>

<div class="container" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <?php
    $display_doctor_profile = "SELECT *, doctor_details.id AS 'doctor_id' FROM doctor_details 
                                JOIN personal_details ON doctor_details.p_id = personal_details.id 
                                JOIN credentials ON credentials.id = personal_details.login_id
                                WHERE doctor_details.id = '$doctor_id'";
    $doctor_profile_query = mysqli_query($db, $display_doctor_profile);
    while ($profile = mysqli_fetch_assoc($doctor_profile_query)) {
    ?>
    <div class="card mb-3" style="margin: 80px 0;" >
        <div class="row g-0">
            <div class="col-md-4">
                <img class="card-img" src="../assets/back2.jpg" alt="Doctor's photo" style="max-width: 400px; max-height: 800px;">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Doctor Profile</h5>
                    <p class="card-text">
                        <?php
                        echo "ID :  " . $profile["doctor_id"] . " <br />";
                        echo "Name : " . $profile['f_name'] . "  " . $profile['l_name'] . " <br />";
                        echo "Email Address :  " . $profile['email'] . " <br />";
                        echo "Contact Number :  " . $profile['contact'] . " <br />";
                        echo "Date of Birth :  " . $profile['dob'] . " <br />";
                        echo "Speciality:  " . $profile['speciality'] . "</br>";
                        echo "Qualification:  " . $profile['qualifications'] . "</br>";
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php
    $display_appointments = "SELECT *, appointments.id AS appt_id  FROM appointments JOIN patient_details on appointments.patient_id = patient_details.id
                                JOIN personal_details on patient_details.p_id = personal_details.id
                                JOIN slots on appointments.slot_id = slots.id WHERE appointments.doctor_id = '$doctor_id'";
    $appointments_query = mysqli_query($db, $display_appointments);
    while ($appointments = mysqli_fetch_assoc($appointments_query)) {
    ?>
    <h2 style="margin-top:50px;">Your Appointments</h2>
    </table>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Patient Id</th>
            <th scope="col">Name</th>
            <th scope="col">Appointment Date</th>
            <th scope="col">Appointment Time</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row"><?php echo $appointments['patient_id']; ?></th>
            <td><?php echo $appointments['f_name'] . " " . $appointments['l_name']; ?></td>
            <td><?php echo $appointments['date']; ?></td>
            <td><?php echo $appointments['timings']; ?></td>
            <td>
                <?php

                switch ($appointments['status']) {
                    case '0': $status = "Pending";
                        $otherStatus = array(1 => "Confirm", 2 => "Reject");
                        $className = "btn btn-warning dropdown-toggle";
                        break;
                    case '1': $status = "Confirmed";
                        $otherStatus = array( 2 => "Reject");
                        $className = "btn btn-success dropdown-toggle";
                        break;
                    case '2': $status = "Rejected";
                        $otherStatus = array(1 => "Confirm");
                        $className = "btn btn-danger dropdown-toggle";
                        break;
                    default: $status = "Pending";
                        $otherStatus = array(1 => "Confirm", 2 => "Reject");
                        $className = "btn btn-warning dropdown-toggle";
                        break;
                }
                ?>
                <div class="dropdown">
                        <?php
                            echo '<button id="status" class="' . $className . '" type="button"  data-bs-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">';
                            echo $status;
                        ?>
                    </button>
                    <ul id="otherStatus" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php
                        foreach ($otherStatus as $id => $status) {
                            echo '<li><a  class="dropdown-item" href="#" id="' . $id . '" appt_id="' .  $appointments['appt_id'] . '">' . $status . '</a></li>';
                        }}
                        ?>
                    </ul>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>


</body>
</html>
