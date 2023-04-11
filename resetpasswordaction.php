<?php
    require("config.php");
    function sendMail($email, $reset_token) {
        $message = "we got a request form you to reset Password! <br>Click the link bellow: <br>
        <a href='http://php.local/crud_php/updatepassword.php?email=$email&reset_token=$reset_token'>reset password</a>";
        $subject = "Reset Password";
        return mail($email, $subject, $message, "From: bhimanidenish@gmail.com");
    }
    if(isset($_POST["resetemail"])) {
        $email = $_POST["resetemail"];
        $sql = "select status from customers where email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row["status"] != 0) {
                $reset_token = bin2hex(random_bytes(16));
                date_default_timezone_set("Asia/Kolkata");
                $date = date("Y-m-d H:i:s");
                $exp_timestamp = strtotime($date.' + 5 minutes');
                $exp_date = date("Y-m-d H:i:s", $exp_timestamp);
                $update_token = "update customers set reset_token='$reset_token', reset_expdate='$exp_date' where email='$email'";
                if($conn->query($update_token) === TRUE && sendMail($email, $reset_token) === TRUE) {
                    $_SESSION["link_sent"] = 'Password reset link is been sent to mail.';
                    header("Location: login.php");
                } else{
                    $_SESSION["link_notsent"] = 'Something went wrong.';
                    header("Location: login.php");
                }
            } else {
                $_SESSION["blocked"] = 'Email is blocked. Please unblock email than try again.';
                header("Location: login.php");
            }                   
        } else {
            $_SESSION["email_existance_error"] = 'User credential not found. Enter valid email address.';
            header("Location: login.php");
        }
    } else {
        header("Location: login.php");
    }
?>