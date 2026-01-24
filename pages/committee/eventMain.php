<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

    $sql = "SELECT * FROM events";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png"> -->
</head>
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
            <h1>EVENT MANAGEMENT</h1>
            <p>CREATE AND MANAGE GREEN INITIATIVE EVENTS.</p>
        </div>
        
        <div class="add-icon" onclick="window.location.href='eventCreate.php'">
            <i class="fas fa-add"></i>
        </div>
    </div>

    <!-- Lower Part  -->
    <section class="event-controls-event-main">
        <div class = "white-color-box">
            <div class="search-filter-group">
                <div class="search-bar">
                    <input type="text" placeholder="Search Events..." class="searchInput">
                </div>
                
            </div>

           
            <section class="container-event">
                 <?php
                if (mysqli_num_rows($result) <= 0) {
                    die ("<script>alert('No data from database!');</script>");
                }
                else {
                    while ($rows = mysqli_fetch_array($result)){
                ?>
                
                <div class="content-card-event"> 

                <!-- Left Side: Image Section -->
                <div class="event-left-section">
                    <div class="event-image">
                        <img src="../../<?php echo $rows['event_poster']; ?>" alt="Event Image">
                    </div>

                    <div class="button">
                        <div class="btn-edit" onclick="window.location.href='eventEdit.php'">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368">
                                <path d="M576-96v-113l210-209q7.26-7.41 16.13-10.71Q811-432 819.76-432q9.55 0 18.31 3.5Q846.83-425 854-418l44 45q6.59 7.26 10.29 16.13Q912-348 912-339.24t-3.29 17.92q-3.3 9.15-10.71 16.32L689-96H576Zm288-243-45-45 45 45ZM624-144h45l115-115-22-23-22-22-116 115v45ZM264-96q-30 0-51-21.15T192-168v-624q0-29.7 21.15-50.85Q234.3-864 264-864h312l192 192v152h-72v-104H528v-168H264v624h240v72H264Zm252-384Zm246 198-22-22 44 45-22-23Z"/>
                            </svg>
                        </div>
                        <div class="btn-delete">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368">
                                <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z"/>
                            </svg>
                        </div>
                    </div>
                </div>



                <!-- Right Side: Details Section -->
                <div class="event-right-section">

                <div class = "event-posted-info">

                <div class = "event-posted">
                        <div class = "event-posted-date-id">Event ID: <?php echo $rows['event_id']?></div>
                    </div>
                <div class = "event-posted">
                        <div class = "event-posted-date-id">Posted by: <?php echo $rows['user_id']?></div>
                    </div>
                    <div class = "event-posted">
                        <div class = "event-posted-date-id"><?php echo $rows['posted_date']?></div>
                    </div>

                    

                </div>

                    <div class = "event-title-row">
                                     <!-- Event Title -->
                        <h2 class="event-title"><?php echo $rows['event_title']; ?></h2>

                        <!-- Event Description -->
                        <p class="event-description">
                            <?php echo $rows['event_description']; ?>
                        </p>
                    </div>

                                    <!-- Status and Points Row -->
                <div class="status-points-row">
                    <div class = "event-status-row">

                     <div class="event-status">
                        <span class="circle"></span>
                        <span>CAPACITY: <?php echo $rows['capacity']?></span>
                    </div>

                    <div class="event-status">
                        <span class="circle"></span>
                        <span>AVAILABLE SPOT: <?php echo $rows['available_spot']?></span>
                    </div>

                    

                    <span class="points-badge"><?php echo $rows['points_given']; ?> pts</span>

                    <div class="event-more" onclick = "window.location.href = 'eventMore.php'">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </div>
   
                        
                    </div>
                </div>
                   


                    <div class="event-meta-row">
                        
                         <div class="meta-item">
                            <span class="meta-label">SCHEDULED DATE</span>
                           <span class="meta-value">
                                <?php echo date('M d, Y - h:i A', strtotime($rows['event_datetime'])); ?>
                            </span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">DURATION</span>
                           <span class="meta-value"><?php echo $rows['duration']; ?></span>
                        </div>


                    </div>


                    <div class="event-meta-row">
                      


                          <div class="meta-item">
                            <span class="meta-label">LOCATION</span>
                            <span class="meta-value"><?php echo $rows['location']; ?></span>
                        </div>
                    </div>




                </div>
                
                </div>
            </section>
        </div>
        <?php 
        } 
    } 
    ?>
    </section>

    <!-- Hamburger Menu -->
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