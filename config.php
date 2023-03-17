<?php
    $hostname = "localhost";
    $username = "denish";
    $password = "Denish@123";
    $database = "mydatabase";
    $conn = new mysqli($hostname, $username, $password, $database);
    if ($conn->connect_errno) {
        die("Connection error" . $conn->connect_errno);
    }
?> 