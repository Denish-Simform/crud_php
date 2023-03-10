<?php

    require('config.php');
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $sqlGetImage = "select image from customers where id = $id";
            $result = $conn->query($sqlGetImage);
            $row = $result->fetch_array();
            $images = $row[0];
            $imgArr = explode(",", $images);
            $sqlDelete = "delete from customers where id = $id";

            if($conn->query($sqlDelete) === true) {
                foreach($imgArr as $img) {
                    if(file_exists("images/$img")) {
                        unlink("images/$img");
                        echo "Record Deleted Successfully";
                    }
                }
                header("Refresh:0; Location:index.php");
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
    }
?>