<?php
    require("config.php");
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
<body class="bg-dark">
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
                        <button type="button" class="btn btn-dark text-white" onclick="login()">
                            <?php 
                                if(isset($_SESSION["id"])) {
                                    echo "Profile";
                                } else {
                                    echo "Log In";
                                }
                            ?>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
        if(isset($_GET["id"])) {   
            if(isset($_SESSION["dataArr"])) {
                $option = $_SESSION["dataArr"];
                unset($_SESSION['dataArr']);
            } else {
                $id = $_GET["id"];
                $sql = "select c.id, c.name, c.phone, c.email, c.gender, c.paymentmethod, c.paymentinfo, c.country, c.state, GROUP_CONCAT(i.imagename) AS image 
                from customers c
                join customerimages i on c.id = i.cid
                where c.id = $id";
                $dataArray = array();
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                    $option = $result->fetch_assoc();
                }
            }
        } elseif(isset($_SESSION["dataArr"])) {
            $option = $_SESSION["dataArr"];
            unset($_SESSION['dataArr']);
        }
    ?>
    <div class="container p-5 form-wrap bg-dark text-white border border-light rounded">
        <div class="formTitle text-center">
            <h1>Registration</h1>
        </div>
        <div class="formBody text-center mt-5">
            <form id="form" action="action.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id" value="<?php if(isset($option["id"]))  echo $option["id"]; ?>">
                <!-- name -->
                <div class="form-group">
                    <label for="name" id="nameLabel" class="col-2 text-start">Name</label>
                    <input type="text" name="name" id="name" class="col-4" value="<?php if(isset($option["name"]))  echo $option["name"];?>">
                </div>
                <span id="nameError" class="error-validate"></span>
                <!-- phone -->
                <div class="form-group">
                    <label for="phone" id="phoneLabel" class="col-2 text-start">Phone Number</label>
                    <input type="number" name="phone" id="phone" class="col-4" value="<?php if(isset($option["phone"])) echo $option["phone"];?>">
                </div>
                <span id="phoneError" class="error-validate"></span>
                <!-- email -->
                <div class="form-group">
                    <label for="email" id="emailLabel" class="col-2 text-start">Email</label>
                    <input type="email" name="email" id="email" class="col-4" value="<?php if(isset($option["email"])) echo $option["email"];?>">
                </div>
                <span id="emailError" class="error-validate"><?php if(isset($_SESSION['emailError'])) echo $_SESSION['emailError']; unset($_SESSION['emailError']);?></span>
                <!--  enter password -->
                <div class="form-group " >   
                    <label for="password" id="passwordLabel" class="col-2 text-start ">Enter Password</label>
                    <input type="password" name="password" id="password" class="col-4 " <?php if(isset($option["id"])) echo "disabled";?>>
                </div> 
                <span id="passwordError" class="error-validate "></span>
                <!-- confirm password -->
                <div class="form-group ">
                    <label for="cnfpassword" id="cnfpasswordLabel" class="col-2 text-start">Confirm Password</label>
                    <input type="password" name="cnfpassword" id="cnfpassword" class="col-4" <?php if(isset($option["id"])) echo "disabled";?>>
                </div>
                <span id="cnfpasswordError" class="error-validate"></span>
                <!-- gender -->
                <div class="form-group d-flex justify-content-center">
                    <label for="gender" id="genderLabel" class="col-2 text-start">Gender</label>
                    <div class="col-4 d-flex flex-column">
                        <div class="d-flex">
                            <input type="radio" name="gender" id="male" value="male" class="gender" <?php if(isset($option["gender"]) && $option["gender"] == "male") echo " checked";?>>
                            <label for="male" class="col-2 text-start ms-2">Male</label>
                        </div>
                        <div class="d-flex">
                            <input type="radio" name="gender" id="female" value="female" class="gender" <?php if(isset($option["gender"]) && $option["gender"] == "female") echo " checked";?>>
                            <label for="female" class="col-2 text-start ms-2">Female</label>
                        </div>
                        <div class="d-flex">
                            <input type="radio" name="gender" id="other" value="other" class="gender" <?php if(isset($option["gender"]) && $option["gender"] == "other") echo " checked";?>>
                            <label for="other" class="col-2 text-start ms-2">Other</label>
                        </div>
                    </div>
                </div>
                <span id="genderError" class="error-validate"></span>
                <!-- image -->
                <div class="form-group">
                    <label for="image" id="imageLabel" class="col-2 text-start">Image</label>
                    <input type="file" name="image[]" id="image" class="col-4" multiple accept="image/*">
                </div>
                <span id="imageError" class="error-validate"></span>
                <div class="imageContainer">
                    <?php 
                    if(isset($option["image"])) { 
                        $images = explode(",", $option['image']);
                        $i = 1;
                        foreach($images as $img) {
                            echo "<img src='assets/storedImages/".$img."' alt='retrivedImage' id='showimg$i' class='show-im'>";
                            $i++;
                        }
                    }
                    ?>
                </div>
                <!-- checkbox -->
                <div class="form-group d-flex justify-content-center">
                    <label for="payment" id="paymentLabel" class="col-2 text-start">Payment Information</label>
                    <div class="col-4 d-flex flex-column">
                        <div class="d-flex">
                            <input type="checkbox" name="payment1" id="credit" value="credit" class="cardDetails" <?php if(isset($option["paymentmethod"]) && in_array("credit", explode(",", $option["paymentmethod"]))) echo ' checked';?>>
                            <label for="credit" class=" text-start ms-2">Credit card</label>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" name="payment2" id="debit" value="debit" class="cardDetails" <?php if(isset($option["paymentmethod"]) && in_array("debit", explode(",", $option["paymentmethod"]))) echo ' checked'; ?>>
                            <label for="debit" class=" text-start ms-2">Debit card</label>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" name="payment3" id="upi" value="upi" class="cardDetails" <?php if(isset($option["paymentmethod"]) && in_array("upi", explode(",", $option["paymentmethod"]))) echo ' checked'; ?>>
                            <label for="upi" class=" text-start ms-2">UPI</label>
                        </div>
                    </div>
                </div>
                <span id="paymentError" class="error-validate"></span>
                <!-- payment-interface -->
                <div class="paymentInterface">
                    <?php
                        if(isset($option["paymentinfo"])) {
                            $paymentinfo = unserialize($option["paymentinfo"]);
                            foreach ($paymentinfo as $key => $value) {
                                extract($paymentinfo[$key]);
                            }
                        }
                    ?>
                    <!-- credit card -->
                    <div class="credit text-center <?php if(isset($option["paymentmethod"]) && in_array("credit", explode(",", $option["paymentmethod"]))) echo 'block'; else echo 'none';?>" >
                        <h3>Credit Card</h3>
                        <!-- creditname -->
                        <div class="form-group">
                            <label for="cname" id="cnameLabel" class="col-2 text-start">Holder's Name</label>
                            <input type="text" name="cname" id="cname" class="col-4" value="<?php if(isset($cname)) echo $cname;?>">
                        </div>
                        <span id="cnameError" class="error-validate"></span>
                        <!-- creditcardnumber -->
                        <div class="form-group">
                            <label for="cnumber" id="cnumberLabel" class="col-2 text-start">Credit Card Number</label>
                            <input type="number" name="cnumber" id="cnumber" class="col-4" value="<?php if(isset($cnumber)) echo $cnumber; ?>">
                        </div>
                        <span id="cnumberError" class="error-validate"></span>
                    </div>
                    <!-- debit card -->
                    <div class="debit text-center <?php if(isset($option["paymentmethod"]) && in_array("debit", explode(",", $option["paymentmethod"]))) echo 'block'; else echo 'none';?>" >
                        <h3>Debit Card</h3>
                        <!-- debitname -->
                        <div class="form-group">
                            <label for="dname" id="dnameLabel" class="col-2 text-start">Holder's Name</label>
                            <input type="text" name="dname" id="dname" class="col-4" value="<?php if(isset($dname)) echo $dname;?>">
                        </div>
                        <span id="dnameError" class="error-validate"></span>
                        <!-- debitcardnumber -->
                        <div class="form-group">
                            <label for="dnumber" id="dnumberLabel" class="col-2 text-start">Debit Card Number</label>
                            <input type="number" name="dnumber" id="dnumber" class="col-4" value="<?php if(isset($dnumber)) echo $dnumber; ?>">
                        </div>
                        <span id="dnumberError" class="error-validate"></span>
                    </div>
                    <!-- upi -->
                    <div class="upi text-center <?php if(isset($option["paymentmethod"]) && in_array("upi", explode(",", $option["paymentmethod"]))) echo 'block'; else echo 'none';?>" >
                        <h3>UPI</h3>
                        <!-- upiname -->
                        <div class="form-group">
                            <label for="uname" id="unameLabel" class="col-2 text-start">Holder's Name </label>
                            <input type="text" name="uname" id="uname" class="col-4" value="<?php if(isset($uname)) echo $uname;?>">
                        </div>
                        <span id="unameError" class="error-validate"></span>
                        <!-- debitcardnumber -->
                        <div class="form-group">
                            <label for="uid" id="uidLabel" class="col-2 text-start">UPI Id </label>
                            <input type="text" name="uid" id="uid" class="col-4" value="<?php if(isset($uid)) echo $uid; ?>">
                        </div>
                        <span id="uidError" class="error-validate"></span>
                    </div>
                </div>
                <!-- Country -->
                <div class="form-group d-flex justify-content-center">
                    <label for="country" id="countryLabel" class="col-2 text-start">Country </label>
                    <div class="col-4 d-flex justify-content-start">
                        <select name="country" id="country" class="">
                            <option value="" selected disabled>-Select Country-</option>
                            <option value="australia" <?php if(isset($option["country"]) && $option["country"] == 'australia') echo " selected"; ?>>Australia</option>
                            <option value="india" <?php if(isset($option["country"]) && $option["country"] == 'india') echo " selected"; ?>>India</option>
                            <option value="japan" <?php if(isset($option["country"]) && $option["country"] == 'japan') echo " selected"; ?>>Japan</option>
                            <option value="usa" <?php if(isset($option["country"]) && $option["country"] == 'usa') echo " selected"; ?>>USA</option>
                        </select>
                    </div>
                </div>
                <span id="countryError" class="error-validate"></span>
                <!-- States -->
                <div class="form-group d-flex justify-content-center">
                    <label for="state" id="stateLabel" class="col-2 text-start">State </label>
                    <div class="col-4 d-flex justify-content-start">
                        <select name="state" id="state" class="">
                            <option value="" selected disabled>-Select State-</option>
                            <?php 
                                if(isset($option["state"])) {
                                    $sqlState = "select s_name from states where c_name = '" . $option['country'] . "'";
                                    if($result = $conn->query($sqlState)){
                                        while($row = $result->fetch_assoc()) {
                                            if($row['s_name'] == $option["state"]) {
                                                echo "<option value=".$row['s_name']." selected>".ucfirst($row['s_name'])."</option>";
                                            } else {
                                                echo "<option value=".$row['s_name']." >".ucfirst($row['s_name'])."</option>";
                                            }
                                        }
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <span id="stateError" class="error-validate"></span>
                <!-- submit -->
                <div class="form-group">
                    <input type="submit" name="submit" id="submit" class="col-3">
                    <input type="reset" name="reset" id="reset" class="col-3" onclick="resetForm()">
                </div>
            </form>
        </div>
    </div>
    <div class="bg-dark text-white">
        <div class="container text-center p-5 border border-light rounded mt-5 mb-5">
            <h1>Bulk Registration</h1>
            <form action="insertCSV.php" method="post" id="formCSV" class="mt-5" enctype="multipart/form-data">
                <div id="autoLoadCSV" class="form-group">
                    <label for="inputCSV" class="col-2 text-start ">Upload CSV file</label>
                    <input type="file" id="inputCSV" name="inputCSV" class="col-4" accept=".csv">
                    <button type="submit" name="csvSubmit" class="btn-primary" id="csvSubmit">Upload</button>
                </div>
                <span id="inputCSVError" class="error-validate">
                    <?php 
                        if(isset($_SESSION["CSVerror"])) {
                            echo $_SESSION["CSVerror"];
                            unset($_SESSION["CSVerror"]);
                        }
                    ?>
                </span>
            </form>    
        </div>
        <table id="mytable" class="display">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Image</th>
                    <th>Payment Methods</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
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
<script src="/crud_php/assets/bootstrap/register.js"></script>
<script src="/crud_php/assets/bootstrap/common.js"></script>
</html>