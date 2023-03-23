<?php
    session_start();
    if(isset($_SESSION['expire']) && $_SESSION['expire'] < time()) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['expire'] = time() + 30;
    require("config.php");
    if(isset($_GET["email"]) && $_GET["unblock_token"]) {
        $email = $_GET["email"];
        $unblock_token = $_GET["unblock_token"];
        $sql = "update customers set status=1, unblock_token=null where email='$email' AND unblock_token='$unblock_token' AND status=0";
        if($conn->query($sql)) {
            $delete_log = "delete from log where email='$email'";
            if($conn->query($delete_log)) {
                $_SESSION["unblock_message"] = "'$email' is been unblocked";
                header("Location: login.php");
            } else {
                echo "
                    <script>
                        alert('Log is not deleted.');
                        window.location.href='login.php';
                    </script>               
                ";
            }
        } else {
            $_SESSION["unblock_error"] = "Something went wrong. Try again";
            header("Location: login.php");
        }
    } else {
        header("Location: login.php");
    }
?>