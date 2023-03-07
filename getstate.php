<?php 
    require("config.php");
    if(isset($_REQUEST["POST_METHOD"])){
        
    }
    if(!empty($_POST['data'])) {
        $country = $_POST['data'];
        $sql = "select s_name from states where c_name = \"".$country . "\"";     
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            echo "<option value='' selected disabled >-Select State-</option>";

            while($row = $result->fetch_assoc()) {
                echo "<option value='".$row['s_name']."'>".ucfirst($row['s_name'])."</option><br>";
            }
        }
    }
?>
  