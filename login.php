<?php 
    require("config.php");

    if(isset($_COOKIE["id"]) || isset($_SESSION["id"])) {
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
        <div class="formTitle text-center">
            <h1>Log In</h1>
        </div>
        <div class="formBody text-center mt-5">
            <form id="form" action="loginaction.php" method="post">
                <!-- email -->
                <div class="form-group ">
                    <label for="email" id="emailLabel" class="col-2 text-start">Email</label>
                    <input type="email" name="email" id="email" class="col-4" 
                        <?php 
                            if(isset($_SESSION["email"])) { 
                                echo "value='".$_SESSION["email"]."'";
                                unset($_SESSION["email"]);
                            }
                        ?>
                    >
                </div>
                <span id="unblockMessage" class="text-success">
                    <?php 
                        if(isset($_SESSION["unblock_message"])) {
                            echo $_SESSION["unblock_message"];
                            unset($_SESSION["unblock_message"]);
                        } elseif(isset($_SESSION["link_sent"])) {
                            echo $_SESSION["link_sent"];
                            unset($_SESSION["link_sent"]);
                        }
                    ?>
                </span>
                <span id="emailError" class="error-validate">
                    <?php 
                        if(isset($_SESSION["email_existance_error"])) {
                            echo $_SESSION["email_existance_error"];
                            unset($_SESSION["email_existance_error"]);
                        } elseif(isset($_SESSION["blocked"])) {
                            echo $_SESSION["blocked"];
                            unset($_SESSION["blocked"]);
                        } elseif(isset($_SESSION["unblock_error"])) {
                            echo $_SESSION["unblock_error"];
                            unset($_SESSION["unblock_error"]);
                        } elseif(isset($_SESSION["link_notsent"])) {
                            echo $_SESSION["link_notsent"];
                            unset($_SESSION["link_notsent"]);
                        }
                    ?>
                </span>
                <div class="p-3"></div>
                <!--  enter password -->
                <div class="form-group " >   
                    <label for="password" id="passwordLabel" class="col-2 text-start ">Password</label>
                    <input type="password" name="password" id="password" class="col-4"
                        <?php 
                            // if(isset($_SESSION["password"])) { 
                            //     echo "value='".$_SESSION["password"]."'";
                            //     unset($_SESSION["password"]);
                            // }
                        ?>
                    >
                </div>
                <span id="passwordError" class="error-validate">
                    <?php
                        if(isset($_SESSION["password_error"])) {
                            echo $_SESSION["password_error"];
                            unset($_SESSION["password_error"]);
                        }
                    ?>
                </span>
                <!--  Forget Password -->
                <div class="forget-password">
                    <a href="#" data-target="#pwdModal" data-toggle="modal">Forget Password?</a>
                </div>
                <div class="p-3"></div>
                <!--  remember me -->
                <div class="form-group " >   
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" id="rememberLabel" class="text-start ">Remember me</label>
                </div>
                <div class="p-3"></div>
                <span class="counter" id="counter">
                    <?php 
                        if(isset($_SESSION["counter"]) && $_SESSION["counter"] < 3) { 
                            echo (3 - $_SESSION["counter"]) . " attempts remaining";
                        }
                    ?>
                </span>
                <?php
                    if(isset($_SESSION["counter"]) && $_SESSION["counter"] >= 3) {
                        echo "<div class='captcha-div mb-3'><img src='captcha.php' alt='captcha'><input type='text' name='captcha' id='captcha'></div>";
                    }
                ?>
                <span id="captchaError" class="error-validate">
                    <?php 
                        if(isset($_SESSION["captcha_error"])) { 
                            echo $_SESSION["captcha_error"]; 
                            unset($_SESSION["captch_error"]); 
                        }
                    ?>
                </span>
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
    <!--modal-->
    <div id="pwdModal" class="modal fade text-dark" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="p-1">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h1 class="text-center">Reset Password</h1>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="text-center">                          
                                    <p>If you have forgotten your password you can reset it here.</p>
                                    <div class="panel-body">
                                        <form action="resetpasswordaction.php" method="post" id="resetform">
                                            <fieldset>
                                                <div class="form-group">
                                                    <input class="form-control input-lg" placeholder="E-mail Address" name="resetemail" type="email" id='resetemail'>
                                                </div>
                                                <input class="btn btn-lg btn-primary btn-block" value="Send Mail" type="button" onclick='sendMail()'>
                                            </fieldset>                
                                        </form>
                                    </div>                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>	
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/crud_php/assets/bootstrap/js/popper.min.js"></script>
<script src="/crud_php/assets/bootstrap/js/jquery-3.6.3.min.js"></script>
<script src="/crud_php/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/crud_php/assets/bootstrap/js/jquery-validate.min.js"></script>
<script src="/crud_php/assets/font-awesome/js/fontawesome.min.js"></script>
<script src="/crud_php/assets/bootstrap/common.js"></script>
<script src="/crud_php/assets/bootstrap/login.js"></script>
</html>