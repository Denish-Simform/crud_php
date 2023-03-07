<?php
    require("config.php");

    $sql = "select id, name, phone, email, gender, image, paymentmethod, country, state from customers";

    $result = $conn->query($sql);

    function getstr($data) : string{
        if(strpos($data,",") > 0) { 
            $temp = explode(",", $data);
            $str = (string)$temp[0];
            return $str;
        } else {
            return (string)$data;
        }
    }

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tempRow = array();
            $id = ucfirst($row['id']);
            $name = ucfirst($row['name']);
            $phone = ucfirst($row['phone']);
            $email = ucfirst($row['email']);
            $gender = ucfirst($row['gender']);
            // $image = ucfirst(getstr($row['image']));
            $image = "<img src='images/".getstr($row['image'])."' alt='userImage' class='table-image'>";
            $paymentmethod = ucfirst(getstr($row['paymentmethod']));
            $country = ucfirst($row['country']);
            $state = ucfirst($row['state']);
            $action = "<button class='btn-danger action-btn' id='".$id."' ><a href='delete.php?id=".$id."'>Delete</a></button> <button class='btn-primary ms-2 action-btn' id='".$id."' ><a href='update.php?id=".$id."'>Update</a></button>";
            $tempRow += array("id" => $id, "name" => $name, "phone" => $phone, "email" => $email, "gender" => $gender, "image" => $image, "paymentmethod" => $paymentmethod, "country" => $country, "state" => $state, "action" => $action);

            $array[] = $tempRow;
        }

        $dataset = array(
            "echo" => 1,
            "totalrecords" => count($array),
            "totaldisplayrecords" => count($array),
            "data" => $array
        );

        echo json_encode($dataset);
        
    
        
    }
?>