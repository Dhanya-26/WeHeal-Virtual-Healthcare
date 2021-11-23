<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> -->
<head><title>Smart medical service</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../assets/icon.png" rel="icon">
</head>

<body id="body-container" class="container" style="background-color: #F8F8FF; padding: 0px; max-width: 100%; height: 90vh;">

<nav class="navbar navbar-light" style="background-color: #00AEAE;">
    <div class="container-fluid">
        <a href="../index.html" class="navbar-brand logo">
            <img src="../assets/LOLOL.png" class="d-inline-block align-text-top" alt="Logo" height="50px" width="50px">
        </a>
        <a class="navbar-brand" href="../index.html"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
        <a class="navbar-brand" href="../wehealaboutus.html"><i class="fa fa-users"></i>About Us</a>
        <!-- <a href="why/why.html">Why VirtualHealth<i class="fa fa-question" aria-hidden="true"></i></a> -->
        <a class="navbar-brand" href="../wehealservices.html"><i class="fa fa-cog" aria-hidden="true"></i>Services</a>
        <a class="navbar-brand" href="../patient/bookappointment.php"><i class="fa fa-comments-o" aria-hidden="true"></i>Book Appointment</a>
        <a class="navbar-brand" href="../index.html"><i class="fa fa-address-card-o" aria-hidden="true"></i>Logout</a>
    </div>
</nav>

<div class="container" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <?php

    session_start();
    include("../data/connection.php");
    $patient_id = $_SESSION['id'];

    $display_patient_profile = "SELECT *, patient_details.id AS 'patient_id' FROM patient_details
                                            JOIN personal_details ON patient_details.p_id = personal_details.id
                                            JOIN credentials ON credentials.id = personal_details.login_id
                                            WHERE patient_details.id = '$patient_id'";
    $patient_profile_query = mysqli_query($db, $display_patient_profile);
    while ($profile = mysqli_fetch_assoc($patient_profile_query)) {
    ?>
    <div class="card mb-3" style="margin: 80px 0;">
        <div class="row g-0">
            <div class="col-md-4">
                <img class="card-img" src="../assets/patient.png" alt="patient's photo" style="max-width: 400px; max-height: 800px;">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Patient Profile</h5>
                    <p class="card-text">
                        <?php
                        echo "ID :  " . $profile["patient_id"] . " <br />";
                        echo "Name : " . $profile['f_name'] . "  " . $profile['l_name'] . " <br />";
                        echo "Email Address :  " . $profile['email'] . " <br />";
                        echo "Contact Number :  " . $profile['contact'] . " <br />";
                        echo "Date of Birth :  " . " <br />" . $profile['dob'] . " <br />";
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php
    $display_appointments = "SELECT * FROM appointments JOIN doctor_details on appointments.doctor_id = doctor_details.id 
                            JOIN personal_details on doctor_details.p_id = personal_details.id 
                            JOIN slots on appointments.slot_id = slots.id
                            WHERE appointments.patient_id =  '$patient_id'";
    $appointments_query = mysqli_query($db, $display_appointments);
    while ($appointments = mysqli_fetch_assoc($appointments_query)) {
    ?>
    <h2 style="margin-top:50px;">Your Appointments</h2>
    </table>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Doctor Id</th>
            <th scope="col">Doctor Name</th>
            <th scope="col">Appointment Date</th>
            <th scope="col">Appointment Time</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row"><?php echo $appointments['doctor_id']; ?></th>
            <td><?php echo $appointments['f_name'] . " " . $appointments['l_name']; ?></td>
            <td><?php echo $appointments['date']; ?></td>
            <td><?php echo $appointments['timings']; ?></td>
            <td><?php
                switch ($appointments['status']) {
                    case '0': echo "Pending";
                        break;
                    case '1': echo "Confirmed";
                        break;
                    case '2': echo "Rejected";
                        break;
                    default: echo "Pending";
                        break;
                }

                }
                ?></td>
        </tr>
        </tbody>
    </table>
</div>


</body>
</html>
