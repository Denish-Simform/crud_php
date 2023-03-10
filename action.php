<?php
    require("config.php");
    $dirName = "images/";
    if(isset($_POST["submit"]) && $_POST["update"] == "") {
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        $confirm_password = md5($_POST["cnfpassword"]);
        $country = $_POST["country"];
        $state = $_POST["state"];
        $gender = $_POST["gender"];
        $img_num = count($_FILES["image"]["name"]);
        $img_arr = array($img_num);
        for($i = 0; $i < $img_num; $i++) {
            $img_arr[$i] = $_FILES["image"]["name"][$i];
            $temp_name = $_FILES["image"]["tmp_name"][$i];
                if(move_uploaded_file($_FILES["image"]["tmp_name"][$i], $dirName . basename($_FILES["image"]["name"][$i]))) {
                    echo $_FILES["image"]["name"][$i];
                    chmod($dirName . basename($_FILES["image"]["name"][$i]), 0777);
                    continue;
                } else {
                    die("File is not Uploaded");            
                }           
        }

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
            header("Refresh:0; Location:index.php");
        } else {
            echo $conn->error;
        }

    } elseif($_SERVER['REQUEST_METHOD'] === 'GET') { // For DELETE
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $sqlGetImage = "select image from customers where id = $id";
            $result = $conn->query($sqlGetImage);
            $row = $result->fetch_array();
            $images = $row[0];
            $imgArr = explode(",", $images);
            $sqlDelete = "delete from customers where id = $id";

            if($conn->query($sqlDelete) === true) {
                foreach($imgArr as $img) {
                    if(file_exists("images/$img")) {
                        unlink("images/$img");
                        echo "Record Deleted Successfully";
                    }
                }
                header("Refresh:0; Location:index.php");
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }

    } else {  // For UPDATE 

        if($_FILES["image"] == null) {  // UPDATING data without images
            $id = $_POST["update"];
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $country = $_POST["country"];
            $state = $_POST["state"];
            $gender = $_POST["gender"];
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

            $updateWithoutImage = "update customers set name = '$name', phone = $phone, email = '$email', paymentmethod = '$payementOption', paymentinfo = '$paymentInfo', gender = '$gender', country = '$country', state = '$state' where id = $id";

            if($conn->query($updateWithoutImage) === TRUE) {
                header("Refresh:0; Location:index.php");
            } else {
                echo $conn->error;
            }
        } else {                // UPDATING data with images
            $id = $_POST["update"];
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $country = $_POST["country"];
            $state = $_POST["state"];
            $gender = $_POST["gender"];
            $img_num = count($_FILES["image"]["name"]);
            $img_arr = array($img_num);
            for($i = 0; $i < $img_num; $i++) {
                $img_arr[$i] = $_FILES["image"]["name"][$i];
                $temp_name = $_FILES["image"]["tmp_name"][$i];
                    if(move_uploaded_file($_FILES["image"]["tmp_name"][$i], $dirName . basename($_FILES["image"]["name"][$i]))) {
                        echo $_FILES["image"]["name"][$i];
                        chmod($dirName . basename($_FILES["image"]["name"][$i]), 0777);
                        continue;
                    } else {
                        die("File is not Uploaded");            
                    }           
            }

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

            $updateWithImage = "update customers set name = '$name', phone = $phone, email = '$email', paymentmethod = '$payementOption', paymentinfo = '$paymentInfo', gender = '$gender', country = '$country', state = '$state', image = '$image' where id = $id";

            $deleteImage = "select image from customers where id = $id";
            $result = $conn->query($updateWithImage);
            $row = $result->fetch_array();
            $images = $row[0];
            $imgArr = explode(",", $images);
            foreach($imgArr as $img) {
                if(file_exists("images/$img")) {
                    unlink("images/$img");
                    echo "Record Deleted Successfully";
                }
            }
            if($conn->query($updateWithImage) === TRUE) {
                header("Refresh:0; Location:index.php");
            } else {
                echo $conn->error;
            }
        }
        
    }
?> 