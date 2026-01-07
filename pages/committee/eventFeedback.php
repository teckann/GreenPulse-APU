<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Feedback Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    
</head>
</head>
<body>
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
            <p>Announcement</p>
        </marquee>
    </div>

        
    <section class="heroSection-event">
        <h1>Event</h1>
        <h1>Management</h1>
        <p>Create and manage green initiative events.</p>
    </section>

    <div class="container">
        <span class = "title">Event Feedback</span>
        <div class = "event-feedback-outer-box">
            <div class = "feedback-header">
                <span class = "title-feedback">Feedback</span>
                <div class = "date-time">
                    <span class = "title-date">Date</span>
                    <span class = title-time>Time</span>
                </div>
            </div>
            <div class = "event-feedback-inner-box"></div>
        </div>

        <div class = "event-feedback-outer-box">
            <div class = "feedback-header">
                <span class = "title-feedback">Feedback</span>
                <div class = "date-time">
                    <span class = "title-date">Date</span>
                    <span class = title-time>Time</span>
                </div>
            </div>
            <div class = "event-feedback-inner-box"></div>
        </div>

        <div class = "event-feedback-outer-box">
            <div class = "feedback-header">
                <span class = "title-feedback">Feedback</span>
                <div class = "date-time">
                    <span class = "title-date">Date</span>
                    <span class = title-time>Time</span>
                </div>
            </div>
            <div class = "event-feedback-inner-box"></div>
        </div>

                <div class = "event-feedback-outer-box">
            <div class = "feedback-header">
                <span class = "title-feedback">Feedback</span>
                <div class = "date-time">
                    <span class = "title-date">Date</span>
                    <span class = title-time>Time</span>
                </div>
            </div>
            <div class = "event-feedback-inner-box"></div>
        </div>
    </div>


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