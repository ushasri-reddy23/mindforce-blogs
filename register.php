<?php

    require('./config.php');

    $msg = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST["username"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $gender = $_POST["gender"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];

        // creating userid
        $userid = md5(substr($name,0,3).substr($phone,0,3).random_int(10000,99999));
        // echo $userid;

        // File Upload
        // Accessing the image
        $filename = $_FILES["image"]["name"];
        // echo $filename."<br>";

        // Extracting filetype
        // $filetype = $_FILES["image"]["type"];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        // Changing the filename
        // $file1 = "userid".$filename;
        // echo $file1."<br>";
        // $file2 = md5("userid".$filename); //md5() encryption method
        // echo $file2."<br>";
        $file = md5("userid".$filename).".".$filetype;
        // echo $file."<br>";

        // Moving the image to db-images folder
        $target = './db-images/users/';        
        $target_file = $target.basename(md5("userid".$filename).".".$filetype);
        // echo $target_file;

        do{
            if(empty($name) || empty($email) || empty($phone) || empty($gender) || empty($file) || empty($password) || empty($cpassword)){
                $msg = "All Fields are required";
            }elseif($password != $cpassword){
                $msg = "Password should match";
            }
            else{
                if($filetype == "jpg" || $filetype == "jpeg" || $filetype == "png" ){
                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                        
                        // Insert data into database
                        $sql = mysqli_query($db, "INSERT INTO `users`(`name`, `phone`, `email`, `gender`, `image`, `password`, `userid`) 
                                                     VALUES ('$name','$phone','$email','$gender','$file','$password','$userid')");

                        if($sql){
                            // $msg = "SUCCESS";
                            header("Location: login.php");
                            exit;
                        }
                        else{
                            $msg = "Something went wrong".mysqli_error($db);
                        }

                    }else{
                        $msg = "Image not moved";
                    }
                }
                else{
                    $msg = "Image type not Accepted";
                }
            }

        }while(false);

    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs - June 2025</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/forms.css">

    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>

    <div class="wrapper">
        <h1>Signup</h1>

        <!-- error message -->
        <?php

            if(!empty($msg)){
                echo "
                    <div class='message'>
                        <h4><strong>$msg</strong></h4>
                    </div>
                ";
            }

        ?>

        <form action="#" method="POST" enctype="multipart/form-data">
            <input type="text" placeholder="Username" name="username">
            <input type="text" placeholder="Email" name="email">
            <input type="text" placeholder="Phone" name="phone">
            <div class="gender">
                <div>
                    <input type="radio" name="gender" value="Male">Male
                </div>
                <div>
                    <input type="radio" name="gender" value="Female">Female
                </div>
            </div>
            Upload your Image <input type="file" name="image">
            <input type="password" placeholder="Password" name="password">
            <input type="password" placeholder="Re-Enter Password" name="cpassword">

            <button type="submit">Signup</button>
        </form>

        <div class="member">
            Already a member? <a href="./login.php">
                Login Here
            </a>
        </div>

        <div class="member">
            <a href="./index.php">
                Back to Home
            </a>
        </div>
    </div>

</body>

</html>