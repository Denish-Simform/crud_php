<?php
    require("config.php");
    function validationError() {
        header("Location: register.php");
        die();
    }
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
                $lineNumber++;
                if(!preg_match("/[A-Za-z]{4,}/",$row[0])) {
                    $_SESSION["CSVerror"] = "Invalid name at line " . $lineNumber  ;
                    validationError();
                }
                if(!preg_match("/[0-9]{10}/",$row[1])) {
                    $_SESSION["CSVerror"] = "Invalid phone number at line " . $lineNumber  ;
                    validationError();
                }
                if(!in_array($row[2], $storedEmail)) {
                    if(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/",$row[2])) {
                        $email_check = "select * from customers where email ='" . $row[2] . "'";
                        $result = $conn->query($email_check);
                        if($result->num_rows > 0) {
                            $_SESSION["CSVerror"] = "$row[2] email address exist in database";
                            validationError();
                        } else {
                            array_push($storedEmail, $row[2]);
                        }
                    } else {
                        $_SESSION["CSVerror"] = "Invalid email at line " . $lineNumber  ;
                        validationError();
                    }
                } else {
                    $_SESSION["CSVerror"] = "Duplicate email exist in CSV at line " . $lineNumber  ;
                    validationError();
                }
                if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/",$row[3])) {
                    $_SESSION["CSVerror"] = "Invalid password at line " . $lineNumber  ;
                    validationError();
                } else {
                    $row[3] = md5($row[3]);
                }
                if(!preg_match("/Male|male|Female|female/",$row[4])) {
                    $_SESSION["CSVerror"] = "Invalid Gender at line " . $lineNumber  ;
                    validationError();
                } else {
                    $row[4] = strtolower($row[4]);
                }
                if(!isset($row[5])) {
                    $_SESSION["CSVerror"] = "Null encountered at line " . $lineNumber  ;
                    validationError();
                }
                if(!isset($row[6])) {
                    $_SESSION["CSVerror"] = "Null encountered at line " . $lineNumber  ;
                    validationError();
                } else {
                    $row[6] = strtolower(str_ireplace("card", "", $row[6]));
                }
                if(!isset($row[7])) {
                    $_SESSION["CSVerror"] = "Null encountered at line " . $lineNumber  ;
                    validationError();
                } else {
                    $row[7] = strtolower($row[7]);
                }
                if(!isset($row[8])) {
                    $_SESSION["CSVerror"] = "Null encountered at line " . $lineNumber  ;
                    validationError();
                } else {    
                    $row[8] = strtolower($row[8]);
                }
                if(!isset($row[9])) {
                    $_SESSION["CSVerror"] = "Null encountered at line " . $lineNumber  ;
                    validationError();
                } else {
                    $row[9] = strtolower($row[9]);
                    $row[9] = ($row[9] == "active") ? 1 : 0;
                }
                $dataArr[] = array($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9]);
            }
            foreach($dataArr as $data) {
                if(isset($data)) {
                    $sql = "insert into customers (name, phone, email, password, gender, paymentinfo, paymentmethod, country, state, status) value ('$data[0]', $data[1], '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]', $data[9])";
                    if($conn->query($sql)) {
                        echo "row inserted";
                        header("Location: register.php");
                    } else {
                        die("error");
                    }
                }
            }
            fclose($f);
        } else {
            $_SESSION["CSVerror"] = "Please Upload File ";
            header("Location: register.php");
        }
    }
?>