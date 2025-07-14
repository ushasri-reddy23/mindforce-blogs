<?php

    session_start();

    if(isset($_SESSION["id"])){

        $id = $_SESSION["id"];
        $name = $_SESSION["name"];
        $image = $_SESSION["image"];

        require('../../config.php');

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
                <h2 class="page-title">Manage Blogs</h2>

                <table>
                    <thead>
                        <th>S. No.</th>
                        <th>Blog Title</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th colspan="2">Action</th>
                    </thead>
                    <tbody>

                        <?php
                            $blogs = mysqli_query($db, "SELECT * FROM blogs WHERE author = '$name'");
                            if(!$blogs){
                                die("Invalid Query !!!".mysqli_error($db));
                            }
                            else{
                                $count = 1;
                                while($row = mysqli_fetch_assoc($blogs)){
                                    echo "
                                        <tr>
                                            <td>$count</td>
                                            <td>$row[title]</td>
                                            <td><img src='../../db-images/blogs/$row[image]' alt=''></td>
                                            <td>$row[category]</td>
                                            <td><a href='./edit.php?id=$row[id]' class='edit'>Edit</a></td>
                                            <td><a href='./delete.php?id=$row[id]' class='delete' onclick='return checkDelete()'>Delete</a></td>
                                        </tr>
                                    ";
                                    $count = $count + 1;
                                }                                
                            }
                        ?>
                        
                    </tbody>
                </table>


            </div>

        </div>

    </div>

    <script>

        function checkDelete(){
            return confirm("Are you sure you want to delete the blog ?");
        }

    </script>

</body>

</html>

<?php
    }
    else{
        header("Location: ../../index.php");
    }
?>  