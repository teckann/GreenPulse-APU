<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
   
</head>
<body>
    <div class = "top-spacing">
    </div>

    </div>
        <nav class = "navigationBar">

        <div class = "hamburgerMenu">
            <button onclick = "toggleMenu()">
                <img src="../../src/committee/hamburgerMenu.svg" alt="Hamburger Menu">
            </button>
        </div>

        <div class = "logo" onclick = "window.location.href='index.php'">
                <img src="../../src/committee/logo.png" alt="Logo">
        </div>

        <div class = "desktopMenu">
                <a href="index.php">Home</a>
                <a href="treeAdoption.php">Tree Adoption</a>
                <a href="merchandises.php">Merchandises</a>
                <a href="eventMain.php">Events</a>
                <a href="study&Quiz.php">Study & Quiz</a>
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


        
        <section class="heroSection">
            <h1>Event</h1>
            <h1>Management</h1>
            <p>Create and manage green initiative events.</p>
        </section>

        <!-- STARTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT -->
        <section class="eventControls-create">
            
            <div class = "container-margin">
                <div class="container">
                    <div class="input-group">
                        <label>Event name</label>
                        <div class="event-box">Recycling Workshop</div>
                    </div>
                    
                    <div class = "two-column">
                        <div class="input-group">
                            <label>Event Date</label>
                            <div class="event-box">December 30, 2025</div>
                        </div>

                        <div class="input-group">
                            <label>Duration</label>
                        <div class="event-box" >2 hours</div>

                        </div>
                    </div>

                    <div class = "two-column">
                        <div class="input-group">
                            <label>Location</label>
                            <div class="event-box">Auditorium 3</div>
                        </div>

                        <div class="input-group">
                            <label>Available Spot</label>
                        <div class="event-box">100</div>

                        </div>
                    </div>

                    <div class="input-group">
                        <label>Points Given</label>
                        <div class="event-box">50</div>
                    </div>

                    <div class="input-group">
                        <label>Description</label>
                        <div class="event-big-box"> An interactive, hands-on session designed to educate participants about proper waste management and inspire creativity by transforming discarded materials into new, useful products.</div>
                    </div>

                    <div class="input-group">
                        <label>Event Poster</label>
                        <div class="event-big-box"></div>
                    </div>



                    <button class="btnCreateEvent">
                        Create Event
                    </button>

                    <div class = "short-tagline">
                        Create. Inspire. Impact.
                    </div>
                </div>
            </div>
        </section>


    <!-- Hamburger Menu sidebar -->
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

            <a href="study&Quiz.php" class="menu-item">
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