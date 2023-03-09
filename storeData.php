<?php
    require("config.php");
    $dirName = "images/";
    if(isset($_POST["submit"])) {
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        $confirm_password = md5($_POST["cnfpassword"]);
        $country = $_POST["country"];
        $state = $_POST["state"];
        $gender = $_POST["gender"];
        $img_num = count($_FILES["image"]["name"]);
        // echo "<br>";
        // echo "<br>";
        // echo $img_num;
        // echo "<br>";
        // echo "<br>";
        $img_arr = array($img_num);
        for($i = 0; $i < $img_num; $i++) {
            $img_arr[$i] = $_FILES["image"]["name"][$i];
            $temp_name = $_FILES["image"]["tmp_name"][$i];
            // echo "<br>";
            // echo "<br>";
            // echo $temp_name;
            // echo "<br>";
            // echo "<br>";
                if(move_uploaded_file($_FILES["image"]["tmp_name"][$i], $dirName . basename($_FILES["image"]["name"][$i]))) {
                    echo $_FILES["image"]["name"][$i];
                    chmod($dirName . basename($_FILES["image"]["name"][$i]), 0777);
                    continue;
                } else {
                    echo "File is not Uploaded";            
                }           
        }
        // echo "<br>";
        // echo "<br>";
        // var_dump($img_arr);
        // echo "<br>";
        // echo "<br>";

        $image = implode(",", $img_arr);
        

        $paymentMethod = array();
        if(isset($_POST["payment1"])) {
            array_push($paymentMethod, $_POST["payment1"]);
        }
        if(isset($_POST["payment2"])) {
            array_push($paymentMethod, $_POST["payment2"]);
        }
        if(isset($_POST["payment3"])) {
            array_push($paymentMethod, $_POST["payment3"]);
        }
        $paymentDetails = array();
        foreach($paymentMethod as $payment) {
            if($payment == "credit") {
                $paymentDetails += array("credit"=>array("cname"=>$_POST["cname"], "cnumber"=>$_POST["cnumber"]));
            }
            if($payment == "debit") {
                $paymentDetails += array("debit"=>array("dname"=>$_POST["dname"], "dnumber"=>$_POST["dnumber"]));
            }
            if($payment == "upi") {
                $paymentDetails += array("upi"=>array("uname"=>$_POST["uname"], "uid"=>$_POST["uid"]));
            }
        }
        $paymentInfo = serialize($paymentDetails);
        
        $paymentOption = implode(",",$paymentMethod);
        $sql = "insert into customers (name, phone, email, password, gender, image, paymentmethod, paymentinfo, country, state) value ('$name', $phone, '$email', '$password', '$gender', '$image','$paymentOption', '$paymentInfo', '$country', '$state') ";
    
        if($conn->query($sql) === TRUE){
            header("Location:index.html");
        //     echo serialize($paymentDetails);
        // echo "<br>";
        // echo "<br>";
        // print($paymentInfo);
        } else {
            echo $conn->error;
        }
    }
?> 