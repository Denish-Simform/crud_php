<?php
    require 'vendor/autoload.php';
    require "jwt.php";
    use Aws\S3\S3Client;
    $s3Client = new S3Client([
    'version' => 'latest',
    'region'  => 'ap-south-1',
    'credentials' => [
        'key'    => 'AKIAV4YEHYK65VGARAHQ',
        'secret' => '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'
    ]
    ]);
    $folder = "assets/awsImages/";
    if(isset($_POST["upload"])) {
        $bearerToken = $_POST["jwtToken"];
        echo $bearerToken;
        if(is_jwt_valid($bearerToken)) {
            if(isset($_FILES["awsImages"])) {
                $imagename = $_FILES["awsImages"]["name"];
                $tmpname = $_FILES["awsImages"]["tmp_name"];
                if(move_uploaded_file($tmpname, $folder . $imagename)){
                    $bucket = 'crud-customer-images';
                    $filePath = __DIR__ . '/'. $folder . $imagename;
                    echo "<br>";
                    echo "<br>";
                    var_dump($filePath);
                    echo "<br>";
                    echo "<br>";
                    $key = basename($filePath);
                    try {
                        $result = $s3Client->putObject([
                        'Bucket' => $bucket,
                        'Key'    => "images/".$key,
                        'Body'   => fopen($filePath, 'r'),
                        'ACL'    => 'public-read'
                        ]);
                        echo "Image uploaded successfully. Image path is: ". $result->get('ObjectURL');
                        echo "<br>";
                    } catch (Aws\S3\Exception\S3Exception $e) {
                        echo "There was an error uploading the file.\n";
                        echo "<br>";
                        var_dump($e->getMessage());
                    }
                    $_SESSION["AWSsuccess"] = "Your file was uploaded successfully.";
                    header("Location: dashboard.php");
                    die();
                } else{
                    $_SESSION["AWSerror"] = "File is not moved into folder";
                    header("Location: dashboard.php");
                    die();
                }
            } else {
                $_SESSION["AWSerror"] = "File not found";
                header("Location: dashboard.php");
                die();
            }
        } else {
            $_SESSION["AWSerror"] = "Access deneid";
            header("Location: dashboard.php");
            die();
        }
    }
?>