

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
    <?php

        
        $arr = ["name" => "denish", "age" => "21", "height" => "172cm", "weight" => "60kg", "college" => "DEPSTAR", "university" => "CHARUSAT"];
        print_r(count($arr));
        $arr1 = array_chunk($arr,2,true);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        print_r($arr);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        print_r($arr1[0]["name"]);
        $arr2 = [1,2,3,4,5,6];
        echo "<br>";
        echo "<br>";
        echo "<br>";
        $arr3 = array_combine($arr,$arr2);
        print_r($arr3);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        print_r(array_flip($arr3));

    ?>

</body>
</html>