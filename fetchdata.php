<?php
    require("config.php");

    $sql = "select id, name, phone, email, gender, image, paymentmethod, country, state from customers";

    $result = $conn->query($sql);

    function getstr($data) : string {
        if(strpos($data,",") > 0) { 
            $temp = explode(",", $data);
            $str = (string)$temp[0];
            return $str;
        } else {
            return (string)$data;
        }
    }

    function getpaymentmethod($data) : string {
        $tempArr = explode(",", $data);
        $newArr = array();
        foreach($tempArr as $val) {
            if($val == "credit" || $val == "debit") {
                array_push($newArr, ucfirst($val . " Card"));
            } else {
                array_push($newArr, strtoupper($val));
            }
        }
        return implode(",", $newArr);
    }
    $array = array();
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tempRow = array();
            $id = ucfirst($row['id']);
            $name = ucfirst($row['name']);
            $phone = ucfirst($row['phone']);
            $email = ucfirst($row['email']);
            $gender = ucfirst($row['gender']);
            $image = getstr($row['image']);
            $paymentmethod = ucwords(getpaymentmethod($row['paymentmethod']));
            $country = ucfirst($row['country']);
            $state = ucfirst($row['state']);
            $action = $row['id'];
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
    } else {
        echo json_encode(array());
    }
?>