<?php
    session_start();
    require("config.php");
    if(isset($_SESSION["id"])) {
        header("Location: dashboard.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sure</title>
    <link rel="stylesheet" href="/crud_php/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/crud_php/assets/bootstrap/css/datatable.css">
    <link rel="stylesheet" href="/crud_php/assets/bootstrap/style.css">
    <link rel="stylesheet" href="/crud_php/assets/font-awesome/css/all.min.css">
</head>
<body class="bg-dark text-white">
    <nav class="navbar sticky-top navbar-expand-lg bg-dark" id="navbar">
        <div class="container-fluid">
            <img src="assets/images/logo-small.png" class="me-3" alt="">
            <a class="navbar-brand text-light" href="#">JNV Jamnagar Alumni Association</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto w-100 justify-content-end">
                    <li class="nav-item">
                        <button type="button" class="btn btn-dark text-white" onclick="home()">Home</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-dark text-white" onclick="register()">Register</button>
                    </li>                 
                </ul>
            </div>
        </div>
    </nav>
    <div class="container p-5 form-wrap bg-dark text-white">
    <?php
        if(isset($_POST["submit"])) {
            if(isset($_POST["email"])) {
                $email = $_POST["email"];
            }
            if(isset($_POST["password"])) {
                $password = md5($_POST["password"]);
            }
            $email_check = "select id from customers where email = '$email'";
            $password_check = "select id from customers where password = '$password'";
            $result_email_check = $conn->query($email_check);
            if($result_email_check->num_rows > 0) {
                $result_password_check = $conn->query($password_check);
                if($result_password_check->num_rows > 0) {
                    $row = $result_password_check->fetch_assoc();
                    $_SESSION["id"] = $row["id"];
                    header("Location: dashboard.php");
                } else {
                    $_SESSION["password_error"] = "Invalid Credentials";
                }
            } else {
                $_SESSION["email_existance_error"] = "Email dosen't exists!";
            }
        }
    ?>
        <div class="formTitle text-center">
            <h1>Log In</h1>
        </div>
        <div class="formBody text-center mt-5">
            <form id="form" action="login.php" method="post">
                <!-- email -->
                <div class="form-group ">
                    <label for="email" id="emailLabel" class="col-2 text-start">Email</label>
                    <input type="email" name="email" id="email" class="col-4" >
                </div>
                <span id="emailError" class="error-validate"><?php if(isset($_SESSION["email_existance_error"])) { echo $_SESSION["email_existance_error"]; unset($_SESSION["email_existance_error"]); }?></span>
                <div class="p-3"></div>
                <!--  enter password -->
                <div class="form-group " >   
                    <label for="password" id="passwordLabel" class="col-2 text-start ">Password</label>
                    <input type="password" name="password" id="password" class="col-4 ">
                </div>
                <span id="passwordError" class="error-validate"><?php if(isset($_SESSION["password_error"])) { echo $_SESSION["password_error"]; unset($_SESSION["password_error"]); }?></span>
                <div class="p-3"></div>
                <!--  submit -->
                <div class="form-group">
                    <input type="submit" name="submit" id="submit" class="col-3">
                </div>
            </form>
        </div>                    
    </div>
    <button id="back-to-top-btn" class="btn btn-primary btn-lg back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>
</body>
<script src="/crud_php/assets/bootstrap/js/popper.min.js"></script>
<script src="/crud_php/assets/bootstrap/js/jquery-3.6.3.min.js"></script>
<script src="/crud_php/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/crud_php/assets/bootstrap/js/jquery-validate.min.js"></script>
<script src="/crud_php/assets/font-awesome/js/fontawesome.min.js"></script>
<script src="/crud_php/assets/bootstrap/common.js"></script>
<script src="/crud_php/assets/bootstrap/login.js"></script>
</html>