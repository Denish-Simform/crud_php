<?php
    session_start();
    require("config.php");
    $dirName = "images/";
    if(isset($_POST["submit"]) && $_POST["update"] == "") { //For Insert data
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        checkEmail($email,$conn);
        $password = md5($_POST["password"]);
        $confirm_password = md5($_POST["cnfpassword"]);
        $country = $_POST["country"];
        $state = $_POST["state"];
        $gender = $_POST["gender"];
        $img_num = count($_FILES["image"]["name"]);
        $imgArr = array($img_num);
        for($i = 0; $i < $img_num; $i++) {
            $imgArr[$i] = $_FILES["image"]["name"][$i];
            $temp_name = $_FILES["image"]["tmp_name"][$i];
                if(move_uploaded_file($_FILES["image"]["tmp_name"][$i], $dirName . basename($_FILES["image"]["name"][$i]))) {
                    echo $_FILES["image"]["name"][$i];
                    chmod($dirName . basename($_FILES["image"]["name"][$i]), 0777);
                    continue;
                } else {
                    die("File is not Uploaded");            
                }           
        }

        $image = implode(",", $imgArr);
        
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
        $sql = "insert into customers (name, phone, email, password, gender, paymentmethod, paymentinfo, country, state) value ('$name', $phone, '$email', '$password', '$gender', '$paymentOption', '$paymentInfo', '$country', '$state') "; // insert data into customers 
    
        if($conn->query($sql) === TRUE){
            $lastId = $conn->insert_id;
            foreach($imgArr as $imagename) {
                $uploadImage = "insert into customerimages (cid, imagename) value ($lastId, '$imagename')"; // Insert images into customerimages
                if($conn->query($uploadImage) === TRUE){
                    echo "Images uploaded successfully";
                }
            }
            header("Location:index.php");
        } else {
            echo $conn->error;
        }

    } elseif($_SERVER['REQUEST_METHOD'] === 'GET') { // For DELETE
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $sqlGetImage = "select GROUP_CONCAT(imagename) as image from customerimages where cid = $id"; // Delete images from images/ folder
            $result = $conn->query($sqlGetImage);
            $row = $result->fetch_array();
            $images = $row[0];
            $imgArr = explode(",", $images);
            $sqlDelete = "delete from customers where id = $id"; // Delete data from customers + customerimages

            if($conn->query($sqlDelete) === true) {
                foreach($imgArr as $img) {
                    if(file_exists("images/$img")) {
                        unlink("images/$img");
                        echo "Record Deleted Successfully";
                    }
                }
                header("Location:index.php");
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }

    } elseif($_POST["submit"] && count(array_filter($_FILES["image"]["name"])) < 1) {  // UPDATING data without images
            $id = $_POST["update"];
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            checkEmail($email,$conn,$id);
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

            $updateWithoutImage = "update customers set name = '$name', phone = $phone, email = '$email', paymentmethod = '$paymentOption', paymentinfo = '$paymentInfo', gender = '$gender', country = '$country', state = '$state' where id = $id";

            if($conn->query($updateWithoutImage) === TRUE) {
                header("Location:index.php");
            } else {
                echo $conn->error;
            }
        } else {                // UPDATING data with images
            $id = $_POST["update"];
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            checkEmail($email,$conn,$id);
            $country = $_POST["country"];
            $state = $_POST["state"];
            $gender = $_POST["gender"];
            $img_num = count($_FILES["image"]["name"]);
            $imgArr = array($img_num);
            for($i = 0; $i < $img_num; $i++) {
                $imgArr[$i] = $_FILES["image"]["name"][$i];
                $temp_name = $_FILES["image"]["tmp_name"][$i];
                    if(move_uploaded_file($_FILES["image"]["tmp_name"][$i], $dirName . basename($_FILES["image"]["name"][$i]))) {
                        echo $_FILES["image"]["name"][$i];
                        chmod($dirName . basename($_FILES["image"]["name"][$i]), 0777);
                        continue;
                    } else {
                        die("File is not Uploaded ");            
                    }           
            }

            $image = implode(",", $imgArr);

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

            $updateWithImage = "update customers set name = '$name', phone = $phone, email = '$email', paymentmethod = '$paymentOption', paymentinfo = '$paymentInfo', gender = '$gender', country = '$country', state = '$state' where id = $id"; // update data into customers

            $deleteImagefromFolder = "select GROUP_CONCAT(imagename) as image from customerimages where id = $id"; // delete images from images/ folder

            $result = $conn->query($deleteImagefromFolder);
            $row = $result->fetch_assoc();
            $images = $row["image"];
            $imgArrDelete = explode(",", $images);
            foreach($imgArrDelete as $img) {
                if(file_exists("images/$img")) {
                    unlink("images/$img");
                    echo "Record Deleted Successfully";
                }
            }
            if($conn->query($updateWithImage) === TRUE) {
                $lastId = $conn->insert_id;
                foreach($imgArr as $imagename) {
                    $deleteImagesfromDatabase = "delete from customerimages where cid = $lastId"; // delete from customerimages
                    if($conn->query($deleteImagesfromDatabase) === TRUE){
                        echo "Images deleted successfully";
                    }
                    $uploadImage = "insert into customerimages (cid, imagename) value ($lastId, '$imagename')"; // insert new images into customerimages
                    if($conn->query($uploadImage) === TRUE){
                        echo "Images uploaded successfully";
                    }
                }
                header("Location:index.php");
            } else {
                echo $conn->error;
            }
        }

        function checkEmail($email,$conn,$id=0) {
            $checksql = "select id, email from customers where email = '$email'";
            if($result = $conn->query($checksql)){
                $row = $result->fetch_assoc();
                if($id != 0) { // called while insert
                    if($result->num_rows > 0 && $row['id'] != $id) {
                        $_SESSION["emailError"] = "$email already exists";
                        header("Location:index.php?id=$id");
                        exit();
                    }          
                } else { // called while update
                    if($result->num_rows > 0) {
                        $_SESSION["emailError"] = "$email already exists";
                        header("Location:index.php");
                        exit();
                    }
                }

            };
        }
      
?> 