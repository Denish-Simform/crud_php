<?php
    session_start();
    if(isset($_SESSION['expire']) && $_SESSION['expire'] < time()) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['expire'] = time() + 30;
    $hostname = "localhost";
    $username = "denish";
    $password = "Denish@123";
    $database = "mydatabase";
    $conn = new mysqli($hostname, $username, $password, $database);
    if ($conn->connect_errno) {
        die("Connection error" . $conn->connect_errno);
    }
?> 