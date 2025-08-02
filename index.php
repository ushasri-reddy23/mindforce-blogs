<?php   

    session_start();

    require('./config.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs - June 2025</title>

    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="./css/style.css">

    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>


    <!------------------------ NAVBAR Section ------------------------>
    <nav class="navbar">
        <div class="logo">
            <h2>MindForce-Blogs</h2>
            

        </div>



        <div class="menu_open">
            <i class="fas fa-bars"></i>

        </div>

        <ul class="links">
            
            
            <div class="menu_close">
                <i class="fas fa-times"></i>
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

            <!-- <li><a href="#" class="logout">LOGOUT</a></li> -->
            
        </ul>
        
    </nav>
            

    <!------------------------ BANNER Section ------------------------>
    <div class="slide-container">
        <div class="slide">
            <img src="./images/Screenshot 2025-07-24 135650.png" alt="">
            <div class="caption">QUICK THINKING</div>

        </div>

        <div class="slide">
            <img src="./images/Screenshot 2025-07-24 140224.png" alt="">
            <div class="caption">LOGICAL REASONING</div>

        </div>

        <div class="slide">
            <img src="./images/Screenshot 2025-07-24 140454.png" alt="">
            <div class="caption">MEMORY POWER</div>
        </div>

        
        <div class="slide">
            <img src="./images/Screenshot 2025-07-24 140559.png" alt="">
            <div class="caption">EMOTIONAL CONTROL</div>

        </div>   
        

        <span class="arrow prev" onclick="controller(-1)">&#10094;</span>
        <span class="arrow next" onclick="controller(1)">&#10095;</span>
    </div>
<!-- ---------------About us--------------- -->

    <section class="about" id="about">
    <div class="about-container">
      <div class="about-left">
        <div class="square">
          <img src="./images/ushasri.jpg" alt="Profile Image" />
        </div>
      </div>

      <div class="about-right">
        <h1>About <span>Me</span></h1>
        <h2>Exploring India, One Iconic Place at a Time</h2>
        <p>Heyy! I’m Ushasri.
This is a 4player mental strength game I created with passion , where each team has one member representing a core skill: Quick Thinking, Logical Reasoning, Creativity, and Emotional Control. Players face challenges based on their strongest trait, and teams must work together using each mind’s unique power. As someone deeply committed to mental growth, I designed this game to turn focus, self-awareness, and resilience into something fun, challenging, and meaningful. For me, it’s not just a game .it’s a reflection of who I am and what I believe in.        <a href="#contact" class="btn">Read More</a>
      </div>
    </div>
  </section>

    <!------------------------ BLOGS Section ------------------------>
    <div class="blogs-container" id="blogs-container">

        <div class="blogs">
            <!-- Heading -->
            <div class="heading">

                <h1>Blogs</h1>
                <h4>Technology, wellness, Nutrition ,student growth , and travel,  — five voices, one journey toward better living.</h4>
                
            </div>
            <!-- Blog -->
            <div class="cards">

                <?php

                    $blogs = mysqli_query($db, "SELECT * FROM `blogs`");
 
                    if(!$blogs){
                        die("Invalid Query !!!".mysqli_error($db));
                    }
                    if (mysqli_num_rows($blogs) === 0) {
                        echo "<p>No blogs found.</p>";
                    }

                    else{
                        while($row = mysqli_fetch_assoc($blogs)){
                            echo "
                                <div class='card'>
                                    <img src='./db-images/blogs/{$row['image']}' alt=''>
                                    <p class='tagline'>{$row['category']}</p>
                                    <h4 class='title'>{$row['title']}</h4>
                                    <p class='content'>To read the complete blog click on Read More below.....</p>
                                    <a href='./single-blog.php?id={$row['id']}'>Read More</a>
                                </div>
                            ";
                        }
                    }
                ?>

            </div>
        </div>
    </div>

    <!------------------------ FOOTER Section ------------------------>
    <footer class="footer">
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