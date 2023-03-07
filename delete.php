<?php

    require('config.php');
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql = "delete from customers where id = $id";

            if($conn->query($sql) === true) {
                header("Location:index.html");
                echo "Record Deleted Successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
    }
?>