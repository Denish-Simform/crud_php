<?php
    session_start();
    if(isset($_SESSION['expire']) && $_SESSION['expire'] < time()) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['expire'] = time() + 30;
    require("config.php");
    if(isset($_GET["email"]) && $_GET["reset_token"]) {
        date_default_timezone_set('Asia/kolkata');
        $date = date("Y-m-d H:i:s");
        $email = $_GET["email"];
        $reset_token = $_GET["reset_token"];
        $sql = "select * from customers where email = '$email' AND reset_token = '$reset_token' AND reset_expdate >= '$date'";
        $result = $conn->query($sql);
        if($result->num_rows == 1) {
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
        <div class="formTitle text-center">
            <h1>Enter Password</h1>
        </div>
        <div class="formBody text-center mt-5">
            <form id="form" action="updatepasswordaction.php" method="post">
                <input type='hidden' id='hiddenEmail' name="hiddenEmail" for='hiddenEmail' value='<?php echo $email;?>'>
                <!-- password -->
                <div class="form-group ">
                    <label for="password" id="passwordLabel" class="col-2 text-start">Enter Password</label>
                    <input type="password" name="password" id="password" class="col-4">
                </div>
                <span id="passwordError" class="error-validate"></span>
                <div class="p-3"></div>
                <!--  confirm password -->
                <div class="form-group " >   
                    <label for="cnfpassword" id="cnfpasswordLabel" class="col-2 text-start ">Confirm Password</label>
                    <input type="password" name="cnfpassword" id="cnfpassword" class="col-4">
                </div>
                <span id="cnfpasswordError" class="error-validate"></span>
                <!--  submit -->
                <div class="form-group">
                    <input type="submit" name="submit" id="submit" class="col-3">
                </div>
                <!--  back -->
                <div class="form-group">
                    <input type="button" name="Back" id="back" value='Back' class="col-3" onclick='goBack()'>
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
<script src="/crud_php/assets/bootstrap/updatepassword.js"></script>
</html>                   
<?php
        } else {
            echo "
                <script>
                    alert('Link is expired, please try again');
                    window.location.href='login.php';
                </script>
            ";
        }
    } else {
        header("Location: login.php");
    }
?>