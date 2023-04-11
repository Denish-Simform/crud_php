<?php
    require("config.php");
    function sendMail($email, $unblock_token) {
        $message = "To unblock click the link bellow:
        <a href='http://php.local/crud_php/unblockaction.php?email=$email&unblock_token=$unblock_token'>Unblock me</a>";
        $subject = "To Unblock click the link bellow";
        return mail($email, $subject, $message, "From: bhimanidenish@gmail.com");
    }
    if(isset($_POST["submit"])) {
        if(isset($_POST["email"])) {
            $email = $_POST["email"];
        }
        if(isset($_POST["password"])) {
            $password = md5($_POST["password"]);
        }
        $_SESSION["email"] = $email; 
        // $_SESSION["password"] = "";
        if(isset($_POST["captcha"]) && isset($_SESSION["CAPTCHA_CODE"])) {
            $captcha =  filter_var($_POST["captcha"], FILTER_SANITIZE_STRING);
            if($captcha != $_SESSION["CAPTCHA_CODE"]) {
                $_SESSION["captcha_error"] = "Enter valid captcha";
                header("Location: login.php");
                die();
            }
        }
        $email_check = "select id, password, status from customers where email = '$email'";
        $result_email_check = $conn->query($email_check);
        if($result_email_check->num_rows > 0) {
            $row = $result_email_check->fetch_assoc();
            if($row['status'] != 0) {
                $id = $row['id'];
                if($password == $row['password']) {
                    $_SESSION["id"] = $id;
                    if(isset($_POST["remember"])) {
                        setcookie("id", $id, time()+(30 * 60 * 60 * 60));
                    }
                    $clear_log = "delete from log where id = '$id'";
                    if($conn->query($clear_log)) {
                        echo "Log deleted successfully"; 
                        unset($_SESSION["counter"]);
                        header("Location: dashboard.php");
                    }
                } else {
                    $count_email = "select count(email) as count from log where email = '$email'";
                    $result = $conn->query($count_email);
                    $row_count = $result->fetch_assoc();
                    if(isset($row_count["count"]) && $row_count["count"] > 2) {
                        $unblock_token = bin2hex(random_bytes(16));
                        $user_blocked = "update customers set status=0, unblock_token='$unblock_token' where email = '$email'";
                        if($conn->query($user_blocked)) {
                            if(sendMail($email, $unblock_token) === TRUE) {
                                $_SESSION["blocked"] = "$email is blocked. Check your mail box to unblock this email";
                                unset($_SESSION["counter"]);
                                header("Location: login.php");
                                die();
                            } else {
                                echo "
                                    <script>
                                        alert('Something went wrong. Link is not sent.');
                                        window.location.href='login.php';
                                    </script>               
                                ";        
                            }
                        }
                    }
                    if(isset($_SESSION["counter"])) {
                        ++$_SESSION["counter"];    
                    } else {
                        $_SESSION["counter"] = 1;
                    }
                    $sql = "insert into log (id, email) value ($id, '$email')";
                    if($conn->query($sql)) {
                        $_SESSION["password_error"] = "Invalid Credentials";
                        header("Location: login.php");
                    } else {
                        echo "Record not inserted";
                        die();
                    }
                }
            } else {
                $_SESSION["blocked"] = "$email is blocked. Check your mail box to unblock this email";
                header("Location: login.php");
            }
        } else {
            $_SESSION["email_existance_error"] = "Email dosen't exists!";
            header("Location: login.php");
        }                   
    }
?>