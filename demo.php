<?php

    if(isset($_POST["submit"])){
        echo basename($_FILES["image1"]['name']);
        echo '<br>';
        print_r($_FILES['image1']);
    }

    // move_uploaded_file($)
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>welcome to php</h1>
    <form action="<?php echo html_entity_decode($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="image1" id="file">
        <input type="submit" value="Submit" name="submit">
    </form>

</body>
</html>