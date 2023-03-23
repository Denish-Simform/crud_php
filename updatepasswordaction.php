<?php
    session_start();
    if(isset($_SESSION['expire']) && $_SESSION['expire'] < time()) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['expire'] = time() + 30;
    require("config.php");
    if(isset($_POST["hiddenEmail"]) && isset($_POST["password"])) {
        $email = $_POST["hiddenEmail"];
        $password = md5($_POST["password"]);
        $sql = "update customers set password='$password', reset_expdate=null, reset_token=null where email ='$email'";
        if($conn->query($sql)) {
            echo "
                <script>
                    alert('Password updated successfully');
                    window.location.href='login.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Somethig went wrong, please try again');
                    window.location.href='login.php';
                </script>
            ";
        }
    } else {
        header("Location: login.php");
    }
?>