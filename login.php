<?php

    require('./config.php');

    $msg = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST["email"];
        $password = $_POST["password"];

        do{
            if(empty($email) || empty($password)){
                $msg = "All fields are required";
            }
            else{

                $sql = mysqli_query($db, "SELECT * FROM `users` WHERE email = '$email' ");
                // print_r($sql);
                // echo "<br>";
                $row = mysqli_fetch_assoc($sql);
                // print_r($row);
                // echo "<br>";    
                // echo mysqli_num_rows($sql);

                if(mysqli_num_rows($sql) > 0){
                    if($password != $row["password"]){
                        $msg = "Wrong Password";
                    }
                    else{
                        // $msg = "SUCCESS";

                        session_start();
                        $_SESSION["id"] = $row["id"];
                        $_SESSION["name"] = $row["name"];
                        $_SESSION["image"] = $row["image"];
                        header("Location: index.php");
                        exit;
                    }
                }
                else{
                    $msg = "User not Registered";
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

    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="./css/forms.css">

    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>

    <div class="wrapper">
        <h1>Login</h1>

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

        <form action="#" method="POST">

            <input type="text" placeholder="Enter Email" name="email">
            
            <input type="password" placeholder="Enter Password" name="password">

            <button type="submit">Login</button>

        </form>

        <div class="member">
            Not a member? <a href="./register.php">
                Register Now
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