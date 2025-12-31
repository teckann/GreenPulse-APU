<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link href="https://fonts.googleapis.com/css2?family=Encode+Sans+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
</head>
</head>
<body>
    <nav class = "navigationBar">

    <div class = "hamburgerMenu">
        <button onclick = "toggleMenu()">
            <img src="../../src/committee/hamburgerMenu.svg" alt="Hamburger Menu">
        </button>
    </div>

    <div class = "logo" onclick = "window.location.href='home.html'">
            <img src="../../src/committee/logo.png" alt="Logo">
    </div>

    <div class = "profile">
        <img src="../../src/committee/profilePicture.jpg" alt="Profile Picture">
    </div>

    </nav>

    <div class = "banner">
        <marquee direction = "right" scrollamount = "10">
            <p>Announcement</p>
        </marquee>
    </div>

        
    <section class="heroSection-event">
        <h1>Event</h1>
        <h1>Management</h1>
        <p>Create and manage green initiative events.</p>
    </section>

    <!-- Can section if want the width align, bcos like pack them tgt le -->
    <section class="eventControls">
        <button class="btnCreateEvent" onclick = "window.location.href='eventCreate.php'">
            Create Event
        </button>

        
            <div class="searchFilterGroup">
                <div class="searchWrapper">
                    <input type="text" placeholder="Search Events..." class="searchInput">
                </div>
                <select class="statusDropdown">
                    <option>All Status</option>
                    <option>Pending</option>
                    <option>Approved</option>
                </select>
            </div>

            <section class = container-event>
            <div class = "content-card-event">

                <div class = "eventImage">
                    <img src="../../src/committee/eventImage.jpg" alt="Event Image">
                </div>

                <div class="points-badge">Points</div>

                <div class = "button" onclick = "window.location.href='eventEdit.php'">
                    <div class = "btnEdit"><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#B7B7B7"><path d="M576-96v-113l210-209q7.26-7.41 16.13-10.71Q811-432 819.76-432q9.55 0 18.31 3.5Q846.83-425 854-418l44 45q6.59 7.26 10.29 16.13Q912-348 912-339.24t-3.29 17.92q-3.3 9.15-10.71 16.32L689-96H576Zm288-243-45-45 45 45ZM624-144h45l115-115-22-23-22-22-116 115v45ZM264-96q-30 0-51-21.15T192-168v-624q0-29.7 21.15-50.85Q234.3-864 264-864h312l192 192v152h-72v-104H528v-168H264v624h240v72H264Zm252-384Zm246 198-22-22 44 45-22-23Z"/></svg></div>
                    <div class = "btnDelete"><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#B7B7B7"><path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z"/></svg></div>
                </div>

                <div class="user-meta">
                    <span>User ID</span>
                    <span>Date</span>
                </div>
                    

        
            <div class = event-row>
                <div class = "eventStatus">
                    <span class = "circle"></span>
                    <span>Event Status</span>
                </div>
                                    
                <div class = "more-section">
                    <span>More</span>
                    <span class = "more"><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#B7B7B7"><path d="M480-216v-336H144v-72h408v408h-72Zm192-192v-336H336v-72h408v408h-72Z"/></svg></span>
                </div>
            </div>
                

                <div class = "eventDetails">
                    <span>Event Details</span>
                    <!-- <span></span> -->
                </div>

               



            </div>

        </section>
        
    </section>


    <!-- Hamburger Menu sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">LOGO</div>
            <button class="close-btn" onclick="toggleMenu()">×</button>
        </div>

        <div class="menu-items">
            <a href="index.php" class="menu-item">
                <div class="menu-icon">🏠</div>
                <span class="menu-text">Home</span>
            </a>
            <a href="treeAdoption.php" class="menu-item">
                <div class="menu-icon">🌳</div>
                <span class="menu-text">Tree Adoption</span>
            </a>
            <a href="merchandises.php" class="menu-item">
                <div class="menu-icon">🛍️</div>
                <span class="menu-text">Merchandises</span>
            </a>
            <a href="eventMain.php" class="menu-item">
                <div class="menu-icon">📅</div>
                <span class="menu-text">Events</span>
            </a>
            <a href="study&Quiz.php" class="menu-item">
                <div class="menu-icon">📚</div>
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