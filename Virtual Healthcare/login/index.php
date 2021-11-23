<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://kit.fontawesome.com/693a316d76.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <title>Login Page</title>
</head>
<style>
    <?php
        session_start();
        include ('index.css');
    ?>
</style>
<body class="container" style="background-color: #F8F8FF; padding: 0px; max-width: 100%; height: 90vh;">

<?php
error_reporting(0);
include("../data/connection.php");
if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $email = $_POST['email'];
    if (empty($email) || empty ($password)) {
        $error_msg = "Please fill in empty fields";
    } else {
        $d_query = "SELECT * from credentials where  email='$email'  AND password='$password'";
        $check = mysqli_query($db, $d_query);
        if (mysqli_num_rows($check) > 0) {
            $checked_row = mysqli_fetch_assoc($check);
            $_SESSION['email'] = $checked_row['email'];
            $_SESSION['password'] = $checked_row['password'];
            $_SESSION['is_doctor'] = $checked_row['is_doctor'];
            $login_id = $checked_row['id'];

            if($_SESSION['is_doctor']) {
                $details = "SELECT doctor_details.id from doctor_details JOIN personal_details ON doctor_details.p_id = personal_details.id
                                    WHERE personal_details.login_id = '$login_id'";
            } else {
                $details = "SELECT patient_details.id from patient_details JOIN personal_details ON patient_details.p_id = personal_details.id
                                    WHERE personal_details.login_id = '$login_id'";
            }

            $fetch_id = mysqli_query($db, $details);
            if (mysqli_num_rows($fetch_id) > 0) {
                $fetch_id_row = mysqli_fetch_assoc($fetch_id);
                $_SESSION['id'] =  $fetch_id_row['id'];
            } else {
                $invalid_msg = "Invalid email/password";
            }
            echo $_SESSION['id'];
            if($_SESSION['is_doctor']) {
                echo "<script> window.location='../doctor/doctor_home_page.php' </script> ";
            } else {
                echo "<script> window.location='../patient/patient_home_page.php' </script> ";
            }

        } else {
            $invalid_msg = "Invalid email/password";
        }
    }
}
?>
<nav class="navbar navbar-light" style="background-color: #00000063;">
    <div class="container-fluid">
        <a href="../index.html" class="navbar-brand logo">
            <img src="../assets/LOLOL.png" class="d-inline-block align-text-top" alt="Logo" height="50px" width="50px">
        </a>
        <a class="navbar-brand" href="../index.html"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
        <a class="navbar-brand" href="../wehealaboutus.html"><i class="fa fa-users"></i>About Us</a>
        <!-- <a href="why/why.html">Why VirtualHealth<i class="fa fa-question" aria-hidden="true"></i></a> -->
        <a class="navbar-brand" href="../wehealservices.html"><i class="fa fa-cog" aria-hidden="true"></i>Services</a>
        <a class="navbar-brand" href="../wehealcontact.html"><i class="fa fa-comments-o" aria-hidden="true"></i>Contact Us</a>
        <!--        <a class="navbar-brand" href="../login"><i class="fa fa-address-card-o" aria-hidden="true"></i>Login</a>-->
    </div>
</nav>

<div class="wrapper fadeInDown">
    <div class="form-content">
        <div class="form-header">
            <h3 class="text-center">Login</h3>
        </div>
        <form class="needs-validation" action="index.php" method="post" novalidate>
            <div class="form-floating" id="input-box">
                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                <label for="floatingInput">Email address</label>
                <div class="invalid-feedback">
                    Please enter a valid email address.
                </div>
            </div>
            <div class="form-floating" id="input-box">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
                <div class="invalid-feedback">
                    Please enter your password.
                </div>
            </div>
            <input type="submit" id="submit" name="submit" value="Sign In">
        </form>
        <div class="form-footer">
            <p style="text-align:center">
                <span style="color:#67697C; padding:20px 0;">If you are a doctor, </span><a href=../doctor/doctor_registration.php>Register here</a></br>
                <span style="color:#67697C; padding:20px 0;">If you are a patient, </span><a href=../patient/patient_registration.php>Register here</a></br>
                <a  href="../index.html"><strong>Back To Home
                        Page</strong></a>
            </p>
        </div>
        <script>
            (function () {
                'use strict'
                let forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms)
                    .forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>

    </div>
</div>

<?php
if (isset($error_msg)) {
    echo $error_msg;
}
if (isset($invalid_msg)) {
    echo $invalid_msg;
}
?>


</body>
</html>
