<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee Home Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
   
<body>
    <!-- The whole navigation bar (include the menu icon, logo and profile pic)-->
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

    <!--Use <section> like this section got a lot things, pack it together-->
    <section class="heroSection">
        <h1>APU</h1>
        <h1>GREENPULSE</h1>
        <p>Grow greener futures — volunteer, share, celebrate.</p>
    </section>

    <!-- Grey section with cards -->
    <section class="content-section">
        <div class="content-card">
            <div class="card-content">
                <h3>Tree Adoption</h3>
                <p>Add, edit, and delete tree records for management.</p>
                
                <button class="card-button" onclick="window.location.href='availableTreePage.php'">
                    <span>Tree Adoption</span>
                    <span>→</span>
                </button>

            </div>
        </div>

        <div class="content-card">
            <div class="card-content">
                <h3>Merchandises</h3>
                <p>Add, edit, and delete merchandise records for management.</p>
                <button class="card-button" onclick="window.location.href='merchandises.php'">
                    <span>Merchandises</span>
                    <span>→</span>
                </button>
            </div>
        </div>

        <div class="content-card">
            <div class="card-content">
                <h3>Events</h3>
                <p>Add, edit, and delete events records for management.</p>
                <button class="card-button" onclick="window.location.href='eventMain.php'">
                    <span>Events</span>
                    <span>→</span>
                </button>
            </div>
        </div>

        <div class="content-card">
            <div class="card-content">
                <h3>Study & Quiz</h3>
                <p>Add, edit, and delete quiz records for management.</p>
                <button class="card-button" onclick="window.location.href='study&Quiz.php'">
                    <span>Study & Quiz</span>
                    <span>→</span>
                </button>
            </div>
        </div>
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