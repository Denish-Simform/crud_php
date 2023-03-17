<?php
    session_start();
    require("config.php");
    if(isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
        $get_data = "select c.id, c.name, c.phone, c.email, c.gender, c.paymentmethod, c.paymentinfo, c.country, c.state, GROUP_CONCAT(i.imagename) AS image 
        from customers c
        join customerimages i on c.id = i.cid
        where c.id = $id";
        $result = $conn->query($get_data);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
    } else {
        header("Location: login.php");
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
                        <button type="button" class="btn btn-dark text-white" onclick="logout()">Log Out</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="details">
            <div class="fields">
                Name : <?php 
                    if(isset($row["name"])) {
                        echo ucwords($row["name"]);
                    }
                ?>
            </div>
            <div class="fields">
                Email : <?php 
                    if(isset($row["email"])) {
                        echo $row["email"];
                    }
                ?>
            </div>
            <div class="fields">
                Gender : <?php 
                    if(isset($row["gender"])) {
                        echo ucwords($row["gender"]);
                    }
                ?>
            </div>
            <div class="fields">
                Payment Methods : <?php 
                    if(isset($row["paymentmethod"])) {
                        echo ucwords($row["paymentmethod"]);
                    }
                ?>
            </div>
            <div class="fields">
                Payment Details : <?php 
                    if(isset($row["paymentinfo"])) {
                        $paymentinfo = unserialize($row["paymentinfo"]);
                        extract($paymentinfo);
                        if(isset($credit)) {
                            extract($credit); 
                            echo "<pre>";
                            echo "\t\tCredit card : ";
                            if(isset($cname)) {
                                echo "Holder's Name - ". ucfirst($cname) . ", ";
                            }
                            if(isset($cnumber)) {
                                echo "Credit card Number - ". substr_replace($cnumber, str_repeat('*', strlen($cnumber)-4), 4) . "<br>";
                            }
                            echo "</pre>";
                        }
                        if(isset($upi)) {
                            extract($upi); 
                            echo "<pre>";
                            echo "\t\tUPI : ";
                            if(isset($uname)) {
                                echo "Holder's Name - ". ucfirst($uname) . ", ";
                            }
                            if(isset($uid)) {
                                echo "UPI ID - ". substr_replace($uid, str_repeat('*', strlen($uid)-4), 4) . "<br>";
                            }
                            echo "</pre>";
                        }
                        if(isset($debit)) {
                            extract($debit); 
                            echo "<pre>";
                            echo "\t\tDebit card : ";
                            if(isset($dname)) {
                                echo "Holder's Name - ". ucfirst($dname) . ", ";
                            }
                            if(isset($dnumber)) {
                                echo "Debit card Number - ". substr_replace($dnumber, str_repeat('*', strlen($dnumber)-4), 4) . "<br>";
                            }
                            echo "</pre>";
                        }
                    }
                ?>
            </div>
            <div class="fields">
                Country : <?php 
                    if(isset($row["country"])) {
                        echo ucwords($row["country"]);
                    }
                ?>
            </div>
            <div class="fields">
                State : <?php 
                    if(isset($row["state"])) {
                        echo ucwords($row["state"]);
                    }
                ?>
            </div>
            <div class="fields">
                Images : <div class="dashboard_image_container d-flex "><?php 
                    if(isset($row["image"])) {
                        $images = explode(",", $row["image"]);
                        foreach($images as $image) {
                            echo "<img src='assets/storedImages/$image' alt='userimages' class='dashboard_images'>";
                        }
                    }
                ?></div>
            </div>
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
<script src="/crud_php/assets/bootstrap/js/datatable.js"></script>
<script src="/crud_php/assets/bootstrap/common.js"></script>
</html>