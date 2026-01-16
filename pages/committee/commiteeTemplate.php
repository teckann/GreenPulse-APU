<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee Template</title>
    <link rel="stylesheet" href="../../styles/committee.css">
  
</head>
<body>
    <!-- The whole navigation bar (include the menu icon, logo and profile pic)-->
    <nav class = "navigationBar">
        <div class = "hamburger-menu">
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

    <!--Use <section> like this section got a lot things, pack it together-->
    <!-- This is the "header" part -->
    <!-- <section class="heroSection-event">
        <h1>Event</h1>
        <h1>Management</h1>
        <p>Create and manage green initiative events.</p>
    </section> -->

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