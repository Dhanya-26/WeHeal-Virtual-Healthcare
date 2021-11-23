<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Appointment</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/693a316d76.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link href="../assets/icon.png" rel="icon">
</head>

<body id="body" class="container" style="background-color:#f5f5f5; padding: 0px; max-width: 100%; height: 90vh">
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


<div class="container" style="height: 100%;">
    <div class="container" style="display: flex; flex-direction:column; justify-content: center; align-items: center; height: 100%;">
        <div class="page-header" style="text-align: center; display: flex; justify-content: left;">
            <p class="lead"
               style="font-weight: bold; font-size: 30px; text-align: left; padding-top: 50px;">
                Book Appointment
            </p>
        </div>

        <form class="col-sm-6 needs-validation" style="background-color: #e5e4e2; padding: 40px;" action="bookappointment.php" method="POST" novalidate>
            <div class="input-group mb-3">
                <label class="input-group-text" for="speciality"><i class="fas fa-stethoscope"></i></label>
                <label class="input-group-text" for="speciality">Speciality</label>
                <select class="form-select" id="speciality" name="speciality" required>
                    <option selected disabled value="">Choose the speciality you need to consult...</option>
                    <option value="dermatologist">Dermatologist</option>
                    <option value="gynecologist">Gynecologist</option>
                    <option value="dentist">Dentist</option>
                    <option value="general">General Medicine</option>
                    <option value="cardiologist">Cardiologist</option>
                    <option value="ENT">ENT</option>
                    <option value="gastroentrologist">Gastro-entrologist</option>
                    <option value="Opthalmology">Opthalmology</option>
                </select>
                <div class="invalid-feedback">
                    Please choose the speciality you need to consult.
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('#speciality').change(function () {
                        $.ajax({
                            type: "POST",
                            url: "get_available_doctors_slots.php",
                            data: {speciality: $("#speciality").val()}
                        }).done(function(doctors){
                            doctors = JSON.parse(doctors);
                            $('#doctor').empty();
                            $('#doctor').append('<option selected disabled value="">Choose the doctor you would like to see...</option>');
                            doctors.forEach(function(doctor){
                                $('#doctor').append('<option value="' + doctor['doctor_id'] + '"> ' + doctor['f_name'] + "  " + doctor['l_name'] + '</option>');
                            })
                        });
                    });
                });
            </script>

            <div class="input-group mb-3">
                <label class="input-group-text" for="doctor"> <i class="fas fa-user-md"></i></label>
                <label class="input-group-text" for="doctor">Doctor</label>
                <select class="form-select" id="doctor" name="doctor" required>
                    <option selected disabled value="">Choose the doctor you would like to see...</option>
                </select>
            </div>
            <div class="invalid-feedback">
                Please choose the doctor you need to consult.
            </div>

            <div class="input-group mb-3">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-calendar"></i>
                </div>
                <label class="input-group-text" for="date"><i class="far fa-calendar-alt"></i></label>
                <label class="input-group-text" for="date">Date of Appointment:</label>
                <input id="date" type="date" class="form-control" size="50" name="date" required>
                <div class="invalid-feedback">
                    Please select a date for the appointment.
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('#date').change(function () {
                        $.ajax({
                            type: "POST",
                            url: "get_available_doctors_slots.php",
                            data: {date: $("#date").val(), doctor: $("#doctor").val()}
                        }).done(function(slots){
                            slots = JSON.parse(slots);
                            $('#timings').empty();
                            $('#timings').append('<option selected disabled value="">Choose a slot...</option>');
                            slots.forEach(function(slot){
                                $('#timings').append('<option value="' + slot['id'] + '"> ' + slot['timings'] + '</option>');
                            })
                        });
                    });
                });
            </script>

            <div class="input-group mb-3">
                <label class="input-group-text" for="timings"><i class="far fa-clock"></i></label>
                <label class="input-group-text" for="timings">Slot Timings:</label>
                <select class="form-select" id="timings" name="timings" required>
                    <option selected disabled value="">Choose a slot...</option>
                </select>
                <div class="invalid-feedback">
                    Please select a time slot for your appointment.
                </div>
            </div>

            <div class="col-12">
                <input class="btn btn-primary" type="submit" id="submit" name="submit" value="Submit">
            </div>
            <script>
                $(document).ready(function() {
                    $('#submit').click(function(event) {
                        event.preventDefault()
                        event.stopPropagation()
                        $isSubmitted = true;
                        $.ajax({
                            type: "POST",
                            url: "get_available_doctors_slots.php",
                            data: {
                                date: $("#date").val(),
                                doctor: $("#doctor").val(),
                                timings : $("#timings").val(),
                                isSubmitted: $isSubmitted
                            }
                        }).done(function(res){
                            alert(res)
                        });
                    });
                });
            </script>
        </form>

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
if (isset($success_msg)) {
    echo $success_msg;
}
?>

</body>
</html>
