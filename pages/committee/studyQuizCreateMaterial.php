<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") { 
        
      
        if (isset($_POST["formType"]) && $_POST["formType"] === "createNewMaterial") {
            $targetDir = "../../src/moduleMaterials/";
            
            // Handle Material File
            $materialFileName = basename($_FILES["study_material"]["name"]);
            $materialTargetFilePath = $targetDir . $materialFileName;
            $materialFileType = pathinfo($materialTargetFilePath, PATHINFO_EXTENSION);

            // Handle Video File 
            $videoFileName = basename($_FILES["study_video"]["name"]);
            $videoTargetFilePath = $targetDir . $videoFileName;
            $videoFileType = pathinfo($videoTargetFilePath, PATHINFO_EXTENSION);

            $allowDocTypes = array('pdf', 'png'); // CHANGE THIS [PNG] JUST FOR TESTING
            $allowVideoTypes = array('mp4');

            // Validation & Upload Logic
            $uploadOk = 1;

            // Check Material
            if(!in_array(strtolower($materialFileType), $allowDocTypes)){
                echo "<script>alert('Invalid Material file type (PDF/Images only).');</script>";
                $uploadOk = 0;
            }
            
            // Check Video
            if(!in_array(strtolower($videoFileType), $allowVideoTypes)){
                echo "<script>alert('Invalid Video file type (mp4 only).');</script>";
                $uploadOk = 0;
            }

            // If checks pass, move files and Insert DB
            if ($uploadOk == 1) {
                
                // Move Material
                if (move_uploaded_file($_FILES["study_material"]["tmp_name"], $materialTargetFilePath) && 
                    move_uploaded_file($_FILES["study_video"]["tmp_name"], $videoTargetFilePath)) {
                    
                    // File Paths to save in DB (Relative to root)
                    $materialPath = "src/moduleMaterials/" . $materialFileName; 
                    $videoPath = "src/moduleMaterials/" . $videoFileName;

                    // 6. Sanitize Inputs
                    $moduleName = mysqli_real_escape_string($conn, $_POST['module_name']);
                    $moduleDesc = mysqli_real_escape_string($conn, $_POST['module_description']);
                    
                    // 7. Generate Required Data (ID, User, Status)
                    $moduleID = "M" . rand(1000, 9999); // Simple ID generation
                    $creatorID = isset($userID) ? $userID : $_SESSION['user_id'];
                    $status = "Active";

                    // 8. SQL Insert (Matching your SQL Schema)
                    $sql = "INSERT INTO modules (
                                module_id, 
                                user_id,
                                module_name, 
                                module_description, 
                                module_material, 
                                module_video, 
                                module_status
                            ) VALUES (
                                '$moduleID',
                                '$creatorID',
                                '$moduleName',
                                '$moduleDesc',
                                '$materialPath',
                                '$videoPath',
                                '$status'
                            )";

                    if (mysqli_query($conn, $sql)) {
                        echo "<script>
                                alert('Module Created Successfully!'); 
                                window.location.href='studyQuizMain.php';
                              </script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

                } else {
                    echo "<script>alert('Error moving files to server. Check permissions.');</script>";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study & Quiz Create Material</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- NAVIGATION (Same as before) -->
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
            <h1>CREATE MATERIAL</h1>
            <p>UPLOAD STUDY MATERIALS AND VIDEOS.</p>
        </div>
    </div>

    <!-- FORM START -->
    <form action="#" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="formType" value="createNewMaterial">
                
        <section class="event-controls-event-main">
            <div class = "white-color-box">

            <div class = "study-quiz-module-name-box">
                <div class = "study-quiz-title">Module Name</div>
                <input type="text" name="module_name" placeholder="Module Name" class="event-box" required>
            </div>

            <div class = "study-quiz-description-box">
                <div class = "study-quiz-title">Description</div>
                <input type="text" name="module_description" placeholder="Module Description" class="event-box" required>
            </div>

            <div class = "study-quiz-module-upload">
                <div class = "study-quiz-title">Study Material (PDF/Image)</div>
                <input type="file" name="study_material" class="event-big-box" required>
            </div>

            <div class = "study-quiz-module-upload">
                <div class = "study-quiz-title">Study Video (MP4)</div>
                <input type="file" name="study_video" class="event-big-box" required>
            </div>

            
            <button type="submit" class="btnCreateEvent">
                Save Material
            </button>

            <!-- If you want a button to go to next page without saving, use this: -->
            <!-- <button type="button" onclick="window.location.href='studyQuizCreateQuiz.php'">Create Quiz</button> -->

            <div class = "short-tagline">
                Create. Inspire. Impact.
            </div>

            </div>
        </section>
    </form>

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

    <script>
        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', () => {
                toggleMenu();
            });
        });

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