<?php 

    $server = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'login';

    $conn = mysqli_connect($server, $user, $password, $dbname);

    if (!$conn) {
        die("connection feiled" . mysqli_connect_error());
    }
