<?php
    session_start();
    require("config.php");
    $dirName = "assets/storedImages/";

    if(isset($_POST["submit"])) { 

        $dataVal = array();
        $dataKey = array();

        if(isset($_POST["id"])) {
            $id = $_POST["id"];
        }
        if(isset($_POST["name"])) {
            $name = $_POST["name"];
            array_push($dataVal, $name);
            array_push($dataKey, "name");
        }
        if(isset($_POST["phone"])) {
            $phone = $_POST["phone"];
            array_push($dataVal, $phone);
            array_push($dataKey, "phone");
        }
        if(isset($_POST["email"])) {
            $email = $_POST["email"];
            array_push($dataVal, $email);
            array_push($dataKey, "email");
        }
        if(isset($_POST["password"])) {
            $password = md5($_POST["password"]);
            array_push($dataVal, $password);
            array_push($dataKey, "password");
        }
        if(isset($_POST["country"])) {
            $country = $_POST["country"];
            array_push($dataVal, $country);
            array_push($dataKey, "country");
        }
        if(isset($_POST["state"])) {
            $state = $_POST["state"];
            array_push($dataVal, $state);
            array_push($dataKey, "state");
        }
        if(isset($_POST["gender"])) {
            $gender = $_POST["gender"];
            array_push($dataVal, $gender);
            array_push($dataKey, "gender");
        }
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
        if(isset($paymentMethod)) {
            $paymentOption = implode(",",$paymentMethod);
            array_push($dataVal, $paymentOption);
            array_push($dataKey, "paymentmethod");
            $paymentDetails = array();
            foreach($paymentMethod as $payment) {
                if($payment == "credit") {
                    if(isset($_POST["cname"]) && isset($_POST["cnumber"])) {
                        $paymentDetails += array("credit"=>array("cname"=>$_POST["cname"], "cnumber"=>$_POST["cnumber"]));
                    }
                }
                if($payment == "debit") {
                    if(isset($_POST["dname"]) && isset($_POST["dnumber"])) {
                        $paymentDetails += array("debit"=>array("dname"=>$_POST["dname"], "dnumber"=>$_POST["dnumber"]));
                    }
                }
                if($payment == "upi") {
                    if(isset($_POST["uname"]) && isset($_POST["uid"])) {
                        $paymentDetails += array("upi"=>array("uname"=>$_POST["uname"], "uid"=>$_POST["uid"]));
                    }
                }
            }   
        }
        if(isset($paymentDetails)) {
            $paymentInfo = serialize($paymentDetails);
            array_push($dataVal, $paymentInfo);
            array_push($dataKey, "paymentinfo");
        }

        $dataArr = array_combine($dataKey, $dataVal);

        checkEmail($email,$conn,$dataArr,$id);

        if($_POST["id"] == "") {  // Insert

            $insert = "insert into customers (name, phone, email, password, gender, paymentmethod, paymentinfo, country, state) value ('$name', $phone, '$email', '$password', '$gender', '$paymentOption', '$paymentInfo', '$country', '$state') "; // insert data into customers 
        
            if($conn->query($insert) === TRUE){
                echo "Data inserted successfully";
                // header("Location:register.php");
            } else {
                echo $conn->error;
            }

            $lastId = $conn->insert_id;

        } else { // Update

            $update = "update customers set name = '$name', phone = $phone, email = '$email', paymentmethod = '$paymentOption', paymentinfo = '$paymentInfo', gender = '$gender', country = '$country', state = '$state' where id = $id";

            if($conn->query($update) === TRUE) {
                echo "Data updated successfully";
                // header("Location:register.php");
            } else {
                echo $conn->error;
            }

            $lastId = $id;
        }            

        if(count(array_filter($_FILES["image"]["name"])) > 0) {

            $img_num = count($_FILES["image"]["name"]);
            $imgArr = array($img_num);
            for($i = 0; $i < $img_num; $i++) {
                $imgArr[$i] = $_FILES["image"]["name"][$i];                            
            }
            $image = implode(",", $imgArr);
            $deleteImagefromFolder = "select GROUP_CONCAT(imagename) as image from customerimages where cid = $lastId"; // delete images from images/ folder
            $result = $conn->query($deleteImagefromFolder);
            $row = $result->fetch_assoc();
            if($row["image"] != null) {
                $images = $row["image"];
                $imgArrDelete = explode(",", $images);
                foreach($imgArrDelete as $img) {
                    if(file_exists("assets/storedImages/$img")) {
                        unlink("assets/storedImages/$img");
                        echo "Record Deleted Successfully";
                    }
                }    
            }
                    
            $deleteImagesfromDatabase = "delete from customerimages where cid = $lastId"; // delete from customerimages
            if($conn->query($deleteImagesfromDatabase) === TRUE){
                echo "Images deleted successfully";
            }
            foreach($imgArr as $imagename) {
                $uploadImage = "insert into customerimages (cid, imagename) value ($lastId, '$imagename')"; // Insert images into customerimages
                echo $uploadImage;
                if($conn->query($uploadImage) === TRUE){
                    echo "Images uploaded successfully";
                } else {
                    echo "insert into customerimages (cid, imagename) value ($lastId, '$imagename')";
                }
            }
            for($i = 0; $i<$img_num;$i++) {
                if(move_uploaded_file($_FILES["image"]["tmp_name"][$i], $dirName . basename($_FILES["image"]["name"][$i]))) {
                    chmod($dirName . basename($_FILES["image"]["name"][$i]), 0777);
                } else {
                    die("File is not Uploaded");            
                }  
            }            

            // foreach($_FILES["image"]["name"] as $imagename) {
            //     $uploadImage = "insert into customerimages (cid, imagename) value ($lastId, '$imagename['name']')"; // Insert images into customerimages
            //     if($conn->query($uploadImage) === TRUE){
                    // if(move_uploaded_file($imagename["tmp_name"], $dirName . basename($images["name"]))) {
                        // echo $imagename["name"];
                        // chmod($dirName . basename($imagename["name"]), 0777);
                        // echo "Images uploaded successfully";
                    // } else {
                    //     die("File is not Uploaded");            
                    // }
            //     }            
            // }

        }
        header("Location:register.php");

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
            if($id != "") { // called while update
                if($result->num_rows > 0 && $row['id'] != $id) {
                    $_SESSION["dataArr"] = $dataArr;
                    $_SESSION["emailError"] = "$email already exists";
                    header("Location:register.php?id=$id");
                    exit();
                }          
            } else { // called while insert
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