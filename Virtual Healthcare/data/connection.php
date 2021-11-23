<?php

$db = mysqli_connect('localhost', 'root', '', 'healthcaresystem');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
error_reporting(0);

