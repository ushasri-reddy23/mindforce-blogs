<?php

    session_start();

    if(isset($_SESSION["id"])){

        $id = $_SESSION["id"];
        $name = $_SESSION["name"];
        $image = $_SESSION["image"];

        require('../../config.php');

        $msg = "";
        
        if($_SERVER["REQUEST_METHOD"] == "GET"){
            if(!isset($_GET["id"])){
                header("Location: index.php");
                exit;
            }

            $id = $_GET["id"];
            $sql = mysqli_query($db, "SELECT * FROM `blogs` WHERE id= '$id' ");
            $row = mysqli_fetch_assoc($sql);

            $title =  $row["title"];
            $description = $row["description"];
            $file = $row["image"];
            $category = $row["category"];
        }

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = $_POST["id"];
            $title = $_POST["title"];
            $description = mysqli_real_escape_string($db, $_POST['description']);
            $category = $_POST["category"];
            
            // File Upload
            $filename = $_FILES["image"]["name"]; 
            $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $file = md5("blogid".$filename).".".$filetype;
            $target = '../../db-images/blogs/';        
            $target_file = $target.basename(md5("blogid".$filename).".".$filetype);

            do{
                if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])){
                    if($filetype == "jpg" || $filetype == "jpeg" || $filetype == "png"){
                        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                            // Insert data into database
                            $sql = mysqli_query($db, "UPDATE `blogs` SET `title`='$title',`description`='$description',
                                                 `image`='$file',`category`='$category' WHERE id=$id");
                            if($sql){
                                // $msg = "SUCCESS";
                                header("Location: index.php");
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

                else{
                    $sql = mysqli_query($db, "UPDATE `blogs` SET `title`='$title',`description`='$description',
                                                `category`='$category' WHERE id=$id");

                    if($sql){
                        // $msg = "SUCCESS";
                        header("Location: index.php");
                        exit;
                    }
                    else{
                        $msg = "Something went wrong".mysqli_error($db);
                    }
                }
            }while(false);
        }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs - June 2025</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">

    <!-- Box Icons Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>


    <!------------------------ MAIN Section ------------------------>
    <div class="main">
        <!------------- Top Search Bar ---------------------->
        <div class="topbar">
            <div class="name">
                Welcome <?php echo $name; ?>
            </div>
            <div class="user">
                
                <?php 
                    echo "<img src='../../db-images/users/$image'>";
                ?>

            </div>
        </div>
        
        <!------------- Admin Content ---------------------->
        <div class="admin-content">
            <div class="button-group">
                <a href="./create.php" class="admin-btn btn-blg">Add Blog</a>
                <a href="./index.php" class="admin-btn btn-blg">Manage Blogs</a>
                <a href="../../index.php" class="admin-btn btn-blg home">Back to Home</a>
            </div>

            <div class="content">
                <h2 class="page-title">Edit the Blog</h2>

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
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div>
                        <label>Title</label>
                        <input type="text" name="title" id="" class="text-input" value = "<?php echo $title; ?>">
                    </div>
                    <div>
                        <label>Description</label>
                        <textarea name="description" id="body">  <?php echo $description; ?>  </textarea>
                    </div>
                    <div>
                        <label>Image</label>
                        <input type="file" name="image" class="text-input" value="<?php echo $file; ?>">
                    </div>
                    <div>
                        <label>Category</label>
                        <input type="text" name="category" id="category" class="text-input" value="<?php echo $category; ?>">
                    </div>
                    <div>
                        <button type="submit" class="admin-btn btn-blg">Edit Post</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

    <!----- CkEditor 5 Script -------------------->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>

    <!----- Custom JS Script -------------------->
    <script src="../js/script.js"></script>

</body>

</html>

<?php
    }
    else{
        header("Location: ../../index.php");
    }
?>     