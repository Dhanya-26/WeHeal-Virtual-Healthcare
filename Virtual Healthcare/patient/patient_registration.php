<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="../assets/icon.png" rel="icon">

    <title>Patient Registration</title>
</head>
<style>
    a {
        color: #56baed;
        display:inline-block;
        text-decoration: none;
        font-weight: 400;
        padding: 2.5px 0;
    }
</style>
<?php
include("../data/connection.php");

if (isset($_POST["submit"])) {
    $d_id = $_POST['id'];
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $contact = ($_POST['contact']);
    $DOB = $_POST['DOB'];
    $gender = $_POST['gender'];
    $pswd = $_POST['pswd'];
    $pswd_len = strlen($pswd);


    $insert_into_credentials = "INSERT INTO credentials(email, password)VALUES('$email', '$pswd')";
        if($result = mysqli_query($db, $insert_into_credentials)) {
            $id = mysqli_insert_id($db);
            $insert_into_personal_details = "INSERT INTO personal_details(f_name, l_name, contact, DOB, gender, login_id) 
                                        VALUES('$f_name', '$l_name', '$contact', '$DOB', '$gender', '$id')";
            if($result = mysqli_query($db, $insert_into_personal_details)) {
                $pid = mysqli_insert_id($db);
                $insert_into_patient_details = "INSERT INTO patient_details(p_id) 
                                        VALUES('$pid')";
                if(mysqli_query($db, $insert_into_patient_details))
                    $run = $success_msg = "Thank You For Registration!";
            }
        }



}

?>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

<nav class="navbar navbar-light" style="background-color: #00000063;">
    <div class="container-fluid">
        <a href="../index.html" class="navbar-brand logo">
            <img src="../assets/LOLOL.png" class="d-inline-block align-text-top" alt="Logo" height="50px" width="50px">
        </a>
        <a class="navbar-brand" href="../index.html"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
        <a class="navbar-brand" href="../wehealaboutus.html"><i class="fa fa-users"></i>About Us</a>
        <a class="navbar-brand" href="../wehealservices.html"><i class="fa fa-cog" aria-hidden="true"></i>Services</a>
    </div>
</nav>

<div class="container" style="height: 100%; margin-top: 300px; margin-bottom: 300px;">
    <div class="container" style="display: flex; flex-direction:column; justify-content: center; align-items: center; height: 100%;">
        <div class="page-header" style="text-align: center; display: flex; justify-content: left;">
            <p class="lead"
               style="font-weight: bold; font-size: 30px; text-align: left; padding-top: 50px;">
                Registration
            </p>
        </div>

        <form class="col-sm-8 needs-validation" style="background-color: #e5e4e2; padding: 40px;" action="patient_registration.php" method="POST" novalidate>
            <div class="container-fluid text-center bg-beige col-50">
                <label for="f_name"><i class="fa fa-user"></i><b> First Name :</b></label><br/><br/><input type="text"
                                                                                                    class="form-control"
                                                                                                    size="50"
                                                                                                    placeholder="Enter Your First Name"
                                                                                                    name="f_name"
                                                                                                    required>
                <!--                <div class="invalid-feedback">-->
                <!--                    Please enter your first name.-->
                <!--                </div>-->
                <br/><br/>
                <label for="l_name"><i class="fa fa-user"></i> <b>Last Name: </b></label><br/><br/><input type="text"
                                                                                                  class="form-control"
                                                                                                  size="50"
                                                                                                  placeholder="Enter Your Last Name"
                                                                                                  name="l_name"
                                                                                                  required>
                <!--                <div class="invalid-feedback">-->
                <!--                    Please enter your last name.-->
                <!--                </div>-->
                <br/><br/>
                <label for="email"><b>Email Address:</b></label><br/><br/><input type="email"
                                                                                 placeholder="Enter Your Email Address"
                                                                                 class="form-control" size="50" name="email"
                                                                                 required>
                <!--                <div class="invalid-feedback">-->
                <!--                    Please enter a valid email address.-->
                <!--                </div>-->
                <br/><br/>

                <label for="contact"><b>Contact Number:</b></label><br/><br/><input type="contact" class="form-control"
                                                                                    size="50"
                                                                                    placeholder="Enter Your Contact Number"
                                                                                    name="contact" pattern="[0-9]{10}"
                                                                                    required>
                <!--                <div class="invalid-feedback">-->
                <!--                    Please enter a valid contact number.-->
                <!--                </div>-->
                <br/><br/>

                <label for="DOB"><b>DOB:</b></label><br/><br/><input type="date" class="form-control" size="50" name="DOB"
                                                                     required>
                <!--                <div class="invalid-feedback">-->
                <!--                    Please enter your date-of-birth.-->
                <!--                </div>-->
                <br/><br/>

                <label for="gender"><b>Gender:</b></label><br/><br/><input type="radio" name="gender" value="male"
                                                                           required>Male
                <br/><br/><input type="radio" name="gender" value="female" required>Female
                <!--                <div class="invalid-feedback">-->
                <!--                    Please enter your gender.-->
                <!--                </div>-->
                <br/><br/>

                <label for="pswd"><i class="fa fa-key icon"></i> Create New Password :</label><br/><br/><input
                        type="password" class="form-control" size="50" placeholder="Create Your Password" name="pswd"
                        required>
                <!--                <div class="invalid-feedback">-->
                <!--                    Please enter a valid password.-->
                <!--                </div>-->
                <br/><br/>
                <p><strong>password should be more than 8 characters long</strong></p>
                <input type="submit" class="btn btn-primary text-uppercase focus" name="submit" value="register">
<!--                <a href="../login">-->
                    <br/><br/>
                    <p> Already A Member? <a href="../login">Login</a></p>
                    <p><a href="../index.html">Back to homepage</a></p>
                    <?php
                    if (isset($error_msg)) {
                        echo $error_msg;

                    }
                    if (isset($success_msg)) {
                        echo $success_msg;
                    }

                    ?>
        </form>
    </div>
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
</body>
</html>
