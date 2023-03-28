<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    if(isset($_SESSION['expire']) && $_SESSION['expire'] < time()) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['expire'] = time() + 30;
    require("config.php");
    if(isset($_POST["csvSubmit"])) {
        if(count(array_filter($_FILES["inputCSV"])) > 1) {
            $file = $_FILES["inputCSV"]["tmp_name"];
            $f = fopen($file, "r");
            if($f === false) {
                $_SESSION["CSVerror"] = "File not found";
            }
            $lineNumber = 0;
            $dataArr = [];
            $storedEmail = [];
            while($row = fgetcsv($f)) {
                $lineNumber ++;
                if(!preg_match("/[A-Za-z]{4,}/",$row[0])) {
                    $_SESSION["CSVerror"] = "Invalid name at line " . $lineNumber  ;
                    header("Location: register.php");
                    die();
                }
                if(!preg_match("/[0-9]{10}/",$row[1])) {
                    $_SESSION["CSVerror"] = "Invalid phone number at line " . $lineNumber  ;
                    header("Location: register.php");
                    die();
                }
                if(!in_array($row[2], $storedEmail)) {
                    if(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/",$row[2])) {
                        $email_check = "select * from customers where email ='" . $row[2] . "'";
                        $result = $conn->query($email_check);
                        if($result->num_rows > 0) {
                            $_SESSION["CSVerror"] = "$row[2] email address exist in database";
                            header("Location: register.php");
                            die();
                        } else {
                            array_push($storedEmail, $row[2]);
                        }
                    } else {
                        $_SESSION["CSVerror"] = "Invalid email at line " . $lineNumber  ;
                        header("Location: register.php");
                        die();
                    }
                } else {
                    $_SESSION["CSVerror"] = "Duplicate email exist in CSV at line " . $lineNumber  ;
                    header("Location: register.php");
                    die();
                }
                if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/",$row[3])) {
                    $_SESSION["CSVerror"] = "Invalid password at line " . $lineNumber  ;
                    header("Location: register.php");
                    die();
                }
                if(!preg_match("/Male|male|Female|female/",$row[4])) {
                    $_SESSION["CSVerror"] = "Invalid Gender at line " . $lineNumber  ;
                    header("Location: register.php");
                    die();
                }
                if(!isset($row[5])) {
                    $_SESSION["CSVerror"] = "Null encountered at line " . $lineNumber  ;
                    header("Location: register.php");
                    die();
                }
                if(!isset($row[6])) {
                    $_SESSION["CSVerror"] = "Null encountered at line " . $lineNumber  ;
                    header("Location: register.php");
                    die();
                }
                if(!isset($row[7])) {
                    $_SESSION["CSVerror"] = "Null encountered at line " . $lineNumber  ;
                    header("Location: register.php");
                    die();
                } 
                if(!isset($row[8])) {
                    $_SESSION["CSVerror"] = "Null encountered at line " . $lineNumber  ;
                    header("Location: register.php");
                    die();
                }
                if(!isset($row[9])) {
                    $_SESSION["CSVerror"] = "Null encountered at line " . $lineNumber  ;
                    header("Location: register.php");
                    die();
                }
            }
            rewind($f);
            while ($row = fgetcsv($f)) {
                $dataArr[0] = $row[0];
                $dataArr[1] = $row[1];
                $dataArr[2] = $row[2];
                $dataArr[3] = md5($row[3]);
                $dataArr[4] = strtolower($row[4]);
                $dataArr[5] = $row[5];
                $paymentMethod = explode(",", $row[6]);
                $method = [];
                foreach($paymentMethod as $mode) {
                    if(stripos($mode, "card") > 1) {
                        array_push($method, strtolower(substr(trim($mode), 0, -5)));
                    } else {
                        array_push($method, strtolower(trim($mode)));
                    }
                }
                $dataArr[6] = implode(",", $method);
                $dataArr[7] = strtolower($row[7]);
                $dataArr[8] = strtolower($row[8]);
                if($row[9] == "active" || $row[9] == "Active") {
                    $dataArr[9] = 1; 
                } else {
                    $dataArr[9] = 0; 
                }
                $sql = "insert into customers (name, phone, email, password, gender, paymentinfo, paymentmethod, country, state, status) value ('$dataArr[0]', $dataArr[1], '$dataArr[2]', '$dataArr[3]', '$dataArr[4]', '$dataArr[5]', '$dataArr[6]', '$dataArr[7]', '$dataArr[8]', $dataArr[9])";
                if($conn->query($sql)) {
                    echo "row inserted";
                    header("Location: register.php");
                } else {
                    die("error");
                }
            }
            fclose($f);
        } else {
            $_SESSION["CSVerror"] = "Please Upload File ";
            header("Location: register.php");
        }
    }
?>