<?php
    require("/config.php");

    if(isset($_POST["submit"])) {
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["cnfpassword"];
        $gender = $_POST["gender"];
        $img_num = count($_FILES["image"]);
        $img_arr = array($img_num);
        // var_dump($_FILES["image"]);
        echo $img_num;
    }
    $sql = "insert into customers (name, phone, email, password, gender, images, paymentInfo, country, state) values () ";
?> 