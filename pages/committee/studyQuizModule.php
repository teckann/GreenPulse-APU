<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

    $sql = "SELECT * FROM modules";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study & Quiz Module Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png"> -->
</head>
<body>
    <nav class = "navigation-bar">
        <div class = "hamburger-menu">
            <button onclick = "toggleMenu()">
                <img src="../../src/committee/hamburgerMenu.svg" alt="Hamburger Menu">
            </button>
        </div>

        <div class = "logo" onclick = "window.location.href='index.php'">
            <img src="../../src/elements/logo_horizontal.png" alt="Logo">
        </div>

        <div class = "desktopMenu">
            <a href="index.php">Home</a>
            <a href="treeAdoption.php">Tree Adoption</a>
            <a href="merchandises.php">Merchandises</a>
            <a href="eventMain.php">Events</a>
            <a href="studyQuizMain.php">Study & Quiz</a>
        </div>

        <div class = "profile">
            <img src="../../src/committee/profilePicture.jpg" alt="Profile Picture">
        </div>
    </nav>

    <div class = "banner">
        <marquee direction = "right" scrollamount = "10">
            <p>Join our upcoming Recycling Workshop on Dec 30! Learn, create, and make a difference for a greener tomorrow.</p>
        </marquee>
    </div>
    
    <!-- Upper Part -->
    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>STUDY & QUIZ MANAGEMENT</h1>
            <p>MANAGE STUDY MATERIALS AND QUIZZES IN ONE PLACE.</p>

        </div>
    </div>

    <!--START-->

    <section class="event-controls-event-main">
        <div class = "white-color-box">
<div class="event-details-container">
     <?php
                if (mysqli_num_rows($result) <= 0) {
                    die ("<script>alert('No data from database!');</script>");
                }
                else {
                    while ($rows = mysqli_fetch_array($result)){
                ?>
                <!-- Left -->
                <div class="left-side-container">

                    <div class="left-side-info-box">

                        <div class="more-poster">
                            <img src="../../src/eventPosters/poster1.png" alt="Event Poster">
                        </div>
                        <div class="info-row">
                            <span class="info-label">Posted by:</span>
                            <span class="info-value">Alex Rivera</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Date Created:</span>
                            <span class="info-value">Oct 12, 2023</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status:</span>
                            <span class="status-badge active">
                                <span class="circle"></span> ACTIVE
                            </span>
                        </div>
                    </div>

                    
                    
                    
                </div>
                
                <!-- Right -->
                <div class="right-side-container">
                    <!-- Date & Time -->
                    <div class="detail-box">
                        <div class="detail-content">
                            <span class="detail-label">MODULE NAME</span>
                            <span class="detail-value"><?php echo $rows['module_name']?></span>
                        
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="detail-box">
                        <div class="detail-content">
                            <span class="detail-label">STUDY MATERIAL</span>
                            <div class="detail-value">

                            <!--use button, to do it. like click le then go to that route-->
                            <iframe>src="../../<?php echo $rows['module_material']; ?>"</iframe> <!-- PDF format use <iframe>-->

                           
                            </div>
                         
                        </div>
                    </div>

                    <!-- Participation & Points -->

                     <div class="detail-box">
                        <div class="detail-content">
                            <span class="detail-label">STUDY VIDEO</span>
                            <div class="detail-value">

                           <video controls><source src="../../<?php echo $rows['module_video']; ?>"></video> <!-- Video format use <video controls>-->
                            </div>
                         
                        </div>
                    </div>


                    
                    

                    <!-- Description -->
                    <div class="description-container">
                        <div class="detail-icon">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div class="detail-content">
                            <span class="detail-label">EVENT DESCRIPTION</span>
                            <p class="description-text">
                              <?php echo $rows['module_description']; ?>
                            </p>
                        </div>
                    </div>
                </div>


        </div>
                <?php 
        } 
    } 
    ?>
    </section>







    <!--Hamburger Menu sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="../../src/elements/logo_horizontal.png" alt="Logo">
            </div>
            <button class="close-btn" onclick="toggleMenu()">×</button>
        </div>

        <div class="menu-items">
            <a href="index.php" class="menu-item">
                <div class="menu-icon"><i class="fa-solid fa-house"></i></div>
                <span class="menu-text">Home</span>
            </a>

            <a href="treeAdoption.php" class="menu-item">
                <div class="menu-icon"><i class="fa-solid fa-tree"></i></div>
                <span class="menu-text">Tree Adoption</span>
            </a>

            <a href="merchandises.php" class="menu-item">
                <div class="menu-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                <span class="menu-text">Merchandises</span>
            </a>

            <a href="eventMain.php" class="menu-item">
                <div class="menu-icon"><i class="fa-solid fa-calendar-days"></i></div>
                <span class="menu-text">Events</span>
            </a>

            <a href="studyQuizMain.php" class="menu-item">
                <div class="menu-icon"><i class="fa-solid fa-book-open"></i></div>
                <span class="menu-text">Study & Quiz</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <img src="../../src/committee/profilePicture.jpg" class="user-avatar" alt="User Avatar">
            <div class="user-info">
                <div class="user-name">User Name</div>
                <div class="user-id">User ID</div>
            </div>
        </div>
    </div>
   

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <!-- ============================================ -->
    <!-- JAVASCRIPT FOR HAMBURGER MENU - MUST BE AT THE END -->
    <!-- ============================================ -->
    <script>
        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Close menu when clicking on menu items
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', () => {
                toggleMenu();
            });
        });

        // Close menu with ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('active')) {
                    toggleMenu();
                }
            }
        });
    </script>






</body>
</html>