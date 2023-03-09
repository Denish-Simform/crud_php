<?php
session_start();
    require("config.php");
    if(isset($_GET["id"])) {
        
        $_SESSION['flag'] = 1;
        $id = $_GET["id"];
        $sql = "select * from customers where id = $id";
        $dataArray = array();
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $name = $row['name'];
                $phone = $row['phone'];
                $email = $row['email'];
                $password = $row['password'];
                $country = $row['country'];
                $state = $row['state'];
                $gender = $row['gender'];
                $image[] = explode(",", $row['image']);
                $imglen = count($image);
                $paymentmethod[] = explode($row['paymentmethod']);
                $paymentinfo[] = unserialize($row['paymentinfo']);
                $dataArray += array("name" => $name, "phone" => $phone, "email" => $email, );
            }
        }
        $row = $result->fetch_assoc();

    }
?>