<?php

    session_start();

    if(isset($_GET["id"])){
        $id = $_GET["id"];
        // echo $id;
    }

    require('./config.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single-Blog</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/style.css">

    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<body>

    <!------------------------ NAVBAR Section ------------------------>
    <nav class="navbar">
        <div class="logo">
            <img src="images/image-1.jpg">
            <h1>life essentials<h1>
        </div>
        <div class="menu_open">
            <i class='bx bx-menu'></i>
        </div>
        <ul class="links">
            <div class="menu_close">
                <i class='bx bx-x'></i>
            </div>
            <li><a href="./index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="./index.php#blogs-container">Blogs</a></li>

            <?php if(isset($_SESSION["id"])):  ?>
            <li><a href="./admin-panel/blogs/create.php">Create a Blog</a></li>
            <li><a href="./logout.php" style="color:red; font-weight: 500;">LOGOUT</a></li>

            <?php else: ?>
            <li><a href="./login.php">Login</a></li>

            <?php endif; ?>  
            
        </ul>
    </nav>


    <!------------------------ SINGLE BLOG Section ------------------------>
    <div class="single-blog">
        <div class="container">

            <?php
                $blog = mysqli_query($db,"SELECT * FROM `blogs` WHERE id=$id");

                if(!$blog){
                    die("Invalid Query !!!".mysqli_error($db));
                }
                else{
                    $row = mysqli_fetch_assoc($blog);

                    // Original date string
                    $original_date = $row["createdat"];

                    // Converting the Original date string to a DateTime object
                    $original_date = new DateTime($original_date);

                    // Format the DateTime object into the desired string format
                    $new_date = $original_date->format("Y-m-d");

                    echo "
                        <h1>$row[title]</h1>
                        <img src='./db-images/blogs/$row[image]' alt=''>
                        <div class='description'>$row[description]</div>
                        <div class='author'>
                            <h2>Blog by : $row[author]</h2>
                            <h3>Posted on : $new_date</h3>
                        </div>
                    ";
                }
            ?>

        </div>
    </div>

    <!------------------------ FOOTER Section ------------------------>
    <<footer class="footer">
        <div class="container">
            <div class="row">

                <div class="footer-col">
                    <h4>Company</h4>
                    <ul>
                         <li><a href="#">about us</a></li>
                        <li><a href="#">our services</a></li>
                        <li><a href="#">privacy policy</a></li>
                        <li><a href="#">terms and services</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                   <h4>Quick Links</h4>
            <ul>
                <li><a href="./index.php">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#blogs-container">Blogs</a></li>
                <?php if (!isset($_SESSION["id"])): ?>
                    <li><a href="./login.php">Login</a></li>
                <?php else: ?>
                    <li><a href="./admin-panel/blogs/create.php">Create Blog</a></li>
                    <li><a href="./logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
                </div>

                <div class="footer-col">
                    <h4>Resources</h4>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Help & Support</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Follow us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>

                    </div>

                </div>
                <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> Life Essentials. All rights reserved.</p>
    </div>
            </div>

        </div>
        </div>
    </footer>

    <!-- Custom Js Script -->
    <script src="./js/script.js"></script>


</body>

</html>