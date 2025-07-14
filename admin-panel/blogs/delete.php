<?php

    session_start();

    if(isset($_SESSION["id"])){
        require('../../config.php');

        if(isset($_GET["id"])){
            $id = $_GET["id"];
            // echo $id;
            $sql = mysqli_query($db, "DELETE FROM `blogs` WHERE id= '$id' ");

            if($sql){
                header("Location: index.php");
                exit;
            }
            else{
                die("Something went wrong".mysqli_error($db));
            }
        }

    }
    else{
        header("Location: ../../index.php");
        exit;
    }

?>