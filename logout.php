<?php
    session_start();
    if(isset($_SESSION['expire']) && $_SESSION['expire'] < time()) {
        session_unset();
        session_destroy();
    }
    $_SESSION['expire'] = time() + 30;
    if(isset($_COOKIE["id"])) {
        unset($_COOKIE["id"]);
        setcookie("id", "", time()-1800);
        // session_destroy();
    }
    if(isset($_SESSION["id"])) {
        unset($_SESSION["id"]);
        session_destroy();
    }
    header("Location: index.php");
?>