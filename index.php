<?php
    session_start();
    $_SESSION["flag"] = 0;  
    require("config.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sure</title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap/css/datatable.css">
    <link rel="stylesheet" href="/bootstrap/style.css">
    <link rel="stylesheet" href="/font-awesome/css/fontawesome.min.css">
</head>

<body>
    <?php
        if(isset($_GET["id"]) && $_SESSION['flag'] == 0) {   
            $_SESSION['flag'] = 1;
            $id = $_GET["id"];
            $sql = "select * from customers where id = $id";
            $dataArray = array();
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $name = $row['name'];
                    $phone = $row['phone'];
                    $email = $row['email'];
                    $password = $row['password'];
                    $country = $row['country'];
                    $state = $row['state'];
                    $gender = $row['gender'];
                    $images = explode(",", $row['image']);
                    $imglen = count($images);
                    $paymentmethod = explode(",", $row['paymentmethod']);
                    $paymentinfo = unserialize($row['paymentinfo']);
                    foreach ($paymentinfo as $key => $value) {
                        extract($paymentinfo[$key]);
                    }
                }
            }
        }

    ?>
    <div class="container p-5">
        <div class="formTitle text-center">
            <h1>Form</h1>
        </div>
        <div class="formBody text-center">
            <form id="form" action="action.php" method="post" enctype="multipart/form-data">

                <input type="hidden" name="update" id="update" value="<?php if(isset($id))  echo $id; ?>">
                <!-- name -->
                <div class="form-group">
                    <label for="name" id="nameLabel" class="col-2 text-start">Name</label>
                    <input type="text" name="name" id="name" class="col-4" value="<?php if(isset($id))  echo $name;?>">
                </div>
                <span id="nameError" class="error-validate"></span>

                <!-- phone -->
                <div class="form-group">
                    <label for="phone" id="phoneLabel" class="col-2 text-start">Phone Number</label>
                    <input type="number" name="phone" id="phone" class="col-4" value="<?php if(isset($id)) echo $phone;?>">
                </div>
                <span id="phoneError" class="error-validate"></span>

                <!-- email -->
                <div class="form-group">
                    <label for="email" id="emailLabel" class="col-2 text-start">Email</label>
                    <input type="email" name="email" id="email" class="col-4" value="<?php if(isset($id)) echo $email;?>">
                </div>
                <span id="emailError" class="error-validate"></span>

                <!--  enter password -->
                <div class="form-group " >
                    <label for="password" id="passwordLabel" class="col-2 text-start ">Enter Password</label>
                    <input type="password" name="password" id="password" class="col-4 " >
                    <span id="passwordError" class="error-validate "></span>
                </div>

                <!-- confirm password -->
                <div class="form-group ">
                    <label for="cnfpassword" id="cnfpasswordLabel" class="col-2 text-start">Confirm Password</label>
                    <input type="password" name="cnfpassword" id="cnfpassword" class="col-4" >
                </div>
                <span id="cnfpasswordError" class="error-validate"></span>

                <!-- gender -->
                <div class="form-group d-flex justify-content-center">
                    <label for="gender" id="genderLabel" class="col-2 text-start">Gender</label>
                    <div class="col-4 d-flex flex-column">
                        <div class="d-flex">
                            <input type="radio" name="gender" id="male" value="male" class="gender" <?php if(isset($id) && $gender == "male") echo " checked";?>>
                            <label for="male" class="col-2 text-start ms-2">Male</label>
                        </div>

                        <div class="d-flex">
                            <input type="radio" name="gender" id="female" value="female" class="gender" <?php if(isset($id) && $gender == "female") echo " checked";?>>
                            <label for="female" class="col-2 text-start ms-2">Female</label>
                        </div>

                        <div class="d-flex">
                            <input type="radio" name="gender" id="other" value="other" class="gender" <?php if(isset($id) && $gender == "other") echo " checked";?>>
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
                    if(isset($id)) { 
                        $i = 1;
                        foreach($images as $img) {
                            echo "<img src='images/".$img."' alt='retrivedImage' id='showimg$i' class='show-im'>";
                            $i++;
                        }
                    }
                    ?>
                </div>
                <!-- <img src="#" alt="image1"> -->

                <!-- hobbies -->
                <!-- <div class="form-group d-flex justify-content-center">
                    <label for="hobby" id="hobbyLabel" class="col-2 text-start">Hobbies </label>
                    <div class="col-4 d-flex justify-content-start">
                        <select name="hobby[]" id="hobby" class=" select" multiple  >
                            <option value="" selected disabled>-Select Hobby-</option>
                            <option value="draw">Drawing</option>
                            <option value="dance">Dance</option>
                            <option value="instrument">Instrument Playing</option>
                            <option value="read">Reading</option>
                        </select>
                    </div>
                    <span id="hobbyError" class="error-validate"></span>
                </div> -->

                <!-- checkbox -->
                <div class="form-group d-flex justify-content-center">
                    <label for="payment" id="paymentLabel" class="col-2 text-start">Payment Information</label>
                    <div class="col-4 d-flex flex-column">
                        <div class="d-flex">
                            <input type="checkbox" name="payment1" id="credit" value="credit" class="cardDetails" <?php if(isset($id) && in_array("credit", $paymentmethod)) echo ' checked';?>>
                            <label for="credit" class=" text-start ms-2">Credit card</label>
                        </div>

                        <div class="d-flex">
                            <input type="checkbox" name="payment2" id="debit" value="debit" class="cardDetails" <?php if(isset($id) && in_array("debit", $paymentmethod)) echo ' checked'; ?>>
                            <label for="debit" class=" text-start ms-2">Debit card</label>
                        </div>

                        <div class="d-flex">
                            <input type="checkbox" name="payment3" id="upi" value="upi" class="cardDetails" <?php if(isset($id) && in_array("upi", $paymentmethod)) echo ' checked'; ?>>
                            <label for="upi" class=" text-start ms-2">UPI</label>
                        </div>
                    </div>
                </div>
                <span id="paymentError" class="error-validate"></span>
                <!-- payment-interface -->
                <div class="paymentInterface">
                    <!-- credit card -->
                    <div class="credit text-center none" <?php if(isset($id) && in_array("credit", $paymentmethod)) echo ' style="display:block"';?>>
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
                    <div class="debit text-center none" <?php if(isset($id) && in_array("debit", $paymentmethod)) echo ' style="display:block"';?>>
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
                    <div class="upi text-center none" <?php if(isset($id) && in_array("upi", $paymentmethod)) echo ' style="display:block"';?>>
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
                            <option value="australia" <?php if(isset($id) && $country == 'australia') echo " selected"; ?>>Australia</option>
                            <option value="india" <?php if(isset($id) && $country == 'india') echo " selected"; ?>>India</option>
                            <option value="japan" <?php if(isset($id) && $country == 'japan') echo " selected"; ?>>Japan</option>
                            <option value="usa" <?php if(isset($id) && $country == 'usa') echo " selected"; ?>>USA</option>
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
                                if(isset($id)) {
                                    $sqlState = "select s_name from states where c_name = '$country'";
                                    if($result = $conn->query($sqlState)){
                                        while($row = $result->fetch_assoc()) {
                                            if($row['s_name'] == $state) {
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
                    <!-- <input type="button" id="submit" class="col-8" onclick="checkdata()" value="SUBMIT"> -->
                    <input type="submit" name="submit" id="submit" class="col-8">
                    <!-- <div onclick="checkdata()"> dfghjk</div>-->
                </div>
            </form>
        </div>
    </div>

    <?php

        $_SESSION['flag'] = 0;
        session_unset();
        session_destroy();

    ?>

    <div class="table">
        <table id="mytable" class="display">
            <thead>
                <tr>
                    <th>
                        Id
                    </th>

                    <th>
                        Name
                    </th>

                    <th>
                        Phone Number
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Gender
                    </th>

                    <th>
                        Image
                    </th>

                    <th>
                        Payment Methods
                    </th>

                    <th>
                        Country
                    </th>

                    <th>
                        State
                    </th>

                    <th>
                        Actions
                    </th>
                </tr>

            </thead>

            <tbody id="tbody">

            </tbody>
        </table>
    </div>

</body>
<script src="/bootstrap/js/popper.min.js"></script>
<script src="/bootstrap/js/jquery-3.6.3.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootstrap/js/jquery-validate.min.js"></script>
<script src="/font-awesome/js/fontawesome.min.js"></script>
<script src="/bootstrap/js/datatable.js"></script>
<script src="/bootstrap/main.js"></script>

</html>

