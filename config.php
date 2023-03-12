<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "mydatabase";

    $conn = new mysqli($hostname, $username, $password, $database);

    if ($conn->connect_errno) {
        die("Connection error" . $conn->connect_errno);
    }
?> 