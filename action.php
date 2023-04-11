<?php
    require("config.php");
    $dirName = "assets/storedImages/";
    if(isset($_POST["submit"])) { 
        extract($_POST);
        $password = md5($password);
        $paymentOption = $payment1 . "," . $payment2 . "," . $payment3;
        $paymentOption = trim($paymentOption, ",");
        $paymentDetails = array();
        if(isset($cname) && isset($cnumber)) {
            $paymentDetails += array("credit"=>array("cname"=>$cname, "cnumber"=>$cnumber));
        }
        if(isset($dname) && isset($dnumber)) {
            $paymentDetails += array("debit"=>array("dname"=>$dname, "dnumber"=>$dnumber));
        }
        if(isset($uname) && isset($uid)) {
            $paymentDetails += array("upi"=>array("uname"=>$uname, "uid"=>$uid));
        }
        $paymentInfo = serialize($paymentDetails);
        $dataArr = array("name"=>$name, "phone"=>$phone, "email"=>$email, "password"=>$password, "gender"=>$gender, "paymentmethod"=>$paymentOption, "paymentinfo"=>$paymentInfo, "country"=>$country, "state"=>$state);
        checkEmail($email,$conn,$dataArr,$id);
        if($id == "") {  
            // Insert
            $insert = "insert into customers (name, phone, email, password, gender, paymentmethod, paymentinfo, country, state) value ('$name', $phone, '$email', '$password', '$gender', '$paymentOption', '$paymentInfo', '$country', '$state') "; // insert data into customers 
            if($conn->query($insert) === TRUE){
                echo "Data inserted successfully";
            } else {
                echo $conn->error;
            }
            $lastId = $conn->insert_id;
        } else {
            // Update
            $update = "update customers set name = '$name', phone = $phone, email = '$email', paymentmethod = '$paymentOption', paymentinfo = '$paymentInfo', gender = '$gender', country = '$country', state = '$state' where id = $id";
            if($conn->query($update) === TRUE) {
                echo "Data updated successfully";
            } else {
                echo $conn->error;
            }
            $lastId = $id;
        }            
        if(count(array_filter($_FILES["image"]["name"])) > 0) {
            $imgCount = count($_FILES["image"]["name"]);
            $oldimgArr = [];
            $deleteImagefromFolder = "select imagename as image from customerimages where cid = $lastId";
            $result = $conn->query($deleteImagefromFolder);
            while($row = $result->fetch_assoc()) {
                array_push($oldimgArr, $row["image"]);
            };
            $deleteImagesfromDatabase = "delete from customerimages where cid = $lastId";
            // delete from customerimages
            if($conn->query($deleteImagesfromDatabase) === TRUE){
                echo "Images deleted successfully";
            }
            // delete images from folder
            if(!empty($oldimgArr)) {
                foreach($oldimgArr as $img) {
                    if(file_exists("assets/storedImages/$img")) {
                        unlink("assets/storedImages/$img");
                        echo "Record Deleted Successfully";
                    }
                }    
            }
            for($i = 0; $i < $imgCount; $i++) {
                $uploadImage = "insert into customerimages (cid, imagename) value ($lastId, '" . $_FILES["image"]["name"][$i] . "')";
                if($conn->query($uploadImage) === TRUE){
                    if(move_uploaded_file($_FILES["image"]["tmp_name"][$i], $dirName . basename($_FILES["image"]["name"][$i]))) {
                        chmod($dirName . basename($_FILES["image"]["name"][$i]), 0777);
                    } else {
                        die("File is not Uploaded");            
                    }
                    echo "Images uploaded successfully";
                } else {
                    echo "Image not uploaded";
                }
            }    
        }
        header("Location:register.php");
    } elseif($_SERVER['REQUEST_METHOD'] === 'GET') { 
        // For DELETE
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $sqlGetImage = "select GROUP_CONCAT(imagename) as image from customerimages where cid = $id";
            // Delete images from images/ folder
            $result = $conn->query($sqlGetImage);
            $row = $result->fetch_array();
            $images = $row[0];
            $imgArr = explode(",", $images);
            $sqlDelete = "delete from customers where id = $id";
            // Delete data from customers + customerimages
            if($conn->query($sqlDelete) === true) {
                foreach($imgArr as $img) {
                    if(file_exists("assets/storedImages/$img")) {
                        unlink("assets/storedImages/$img");
                        echo "Record Deleted Successfully";
                    }
                }
                header("Location:register.php");
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
    } else {
        header("Location:register.php");
    }
    function checkEmail($email,$conn,$dataArr,$id) {
        $checksql = "select id, email from customers where email = '". $email . "'";
        if($result = $conn->query($checksql)){
            $row = $result->fetch_assoc();
            if($id != "") { 
                // called while update
                if($result->num_rows > 0 && $row['id'] != $id) {
                    $_SESSION["dataArr"] = $dataArr;
                    $_SESSION["emailError"] = "$email already exists";
                    header("Location:register.php?id=$id");
                    exit();
                }          
            } else {
                // called while insert 
                if($result->num_rows > 0) {
                    $_SESSION["dataArr"] = $dataArr;
                    $_SESSION["emailError"] = "$email already exists";
                    header("Location:register.php");
                    exit();
                }
            }
        };
    }
?> 