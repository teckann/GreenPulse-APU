<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    // Get event ID from URL
    if (!isset($_GET['event_id'])) {
        echo "<script>alert('No event selected!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $eventID = mysqli_real_escape_string($conn, $_GET['event_id']);

    // Fetch event data
    $sqlFetch = "SELECT * FROM events WHERE event_id = '$eventID'";
    $resultFetch = mysqli_query($conn, $sqlFetch);

    if (mysqli_num_rows($resultFetch) <= 0) {
        echo "<script>alert('Event not found!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $eventData = mysqli_fetch_assoc($resultFetch);

    // Check if current user is the creator
    if ($eventData['user_id'] != $_SESSION['userID']) {
        echo "<script>alert('You can only edit events you created!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["formType"]) && $_POST["formType"] === "editEvent") {
            
            // Check if new poster is uploaded
            $eventPosterPath = $eventData['event_poster']; // Keep old poster by default
            
            if (!empty($_FILES["event_poster"]["name"])) {
                $targetDir = "../../src/eventPosters/";
                $fileName = basename($_FILES["event_poster"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                $allowTypes = array('jpg','png','jpeg','gif','pdf', 'mp4');
                
                if(in_array(strtolower($fileType), $allowTypes)){
                    if(move_uploaded_file($_FILES["event_poster"]["tmp_name"], $targetFilePath)){
                        $eventPosterPath = "src/eventPosters/" . $fileName;
                    }
                }
            }
            
            // Get form data
            $eventTitle = mysqli_real_escape_string($conn, $_POST['event_title']);
            $eventDateTime = mysqli_real_escape_string($conn, $_POST['event_datetime']);
            $eventDesc = mysqli_real_escape_string($conn, $_POST['event_description']);
            $duration = mysqli_real_escape_string($conn, $_POST['event_duration']);
            $location = mysqli_real_escape_string($conn, $_POST['event_Location']);
            $capacity = mysqli_real_escape_string($conn, $_POST['event_capacity']);
            $pointsGiven = mysqli_real_escape_string($conn, $_POST['event_points']);
            
            // Calculate available spots (maintain the difference from original)
            $spotDifference = $eventData['capacity'] - $eventData['available_spot'];
            $availableSpot = $capacity - $spotDifference;

            $postedDate = date("Y-m-d");
            
            // Update query
            $sqlUpdate = "UPDATE events SET 
                            event_title = '$eventTitle',
                            event_poster = '$eventPosterPath',
                            event_description = '$eventDesc',
                            event_datetime = '$eventDateTime',
                            duration = '$duration',
                            location = '$location',
                            capacity = '$capacity',
                            available_spot = '$availableSpot',
                            points_given = '$pointsGiven',
                            posted_date = '$postedDate'
                        WHERE event_id = '$eventID'";
            
            if (mysqli_query($conn, $sqlUpdate)) {
                echo "<script>
                        alert('Event Updated Successfully!'); 
                        window.location.href='eventMain.php';
                      </script>";
                exit;
            } else {
                echo "<script>alert('Error updating event: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navigation-bar">
        <div class="hamburger-menu">
            <button onclick="toggleMenu()">
                <img src="../../src/committee/hamburgerMenu.svg" alt="Hamburger Menu">
            </button>
        </div>

        <div class="logo" onclick="window.location.href='index.php'">
            <img src="../../src/elements/logo_horizontal.png" alt="Logo">
        </div>

        <div class="desktopMenu">
            <a href="index.php">Home</a>
            <a href="treeAdoption.php">Tree Adoption</a>
            <a href="merchandises.php">Merchandises</a>
            <a href="eventMain.php">Events</a>
            <a href="studyQuizMain.php">Study & Quiz</a>
        </div>

        <div class="profile">
            <img src="../../src/committee/profilePicture.jpg" alt="Profile Picture">
        </div>
    </nav>

    <div class="banner">
        <marquee direction="right" scrollamount="10">
            <p>Join our upcoming Recycling Workshop on Dec 30! Learn, create, and make a difference for a greener tomorrow.</p>
        </marquee>
    </div>

    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>EDIT EVENT</h1>
            <p>UPDATE THE DETAILS TO REFINE YOUR GREEN INITIATIVE EVENT.</p>
        </div>
    </div>

    <form action="eventEdit.php?event_id=<?php echo $eventID; ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="formType" value="editEvent">

        <section class="event-controls-event-main">
            <div class="white-color-box">
                
                <div class="two-column">
                    <div class="input-group">
                        <div class="row">
                            <label>Event Name</label>
                            <span> *</span>
                        </div>
                        <input type="text" name="event_title" value="<?php echo htmlspecialchars($eventData['event_title']); ?>" class="event-box" required>
                    </div>

                    <div class="input-group">
                        <div class="row">
                            <label>Event Date Time</label>
                            <span> *</span>
                        </div>
                        <input type="datetime-local" name="event_datetime" value="<?php echo date('Y-m-d\TH:i', strtotime($eventData['event_datetime'])); ?>" class="event-box" required>
                    </div>
                </div>

                <div class="two-column">
                    <div class="input-group">
                        <div class="row">
                            <label>Location</label>
                            <span> *</span>
                        </div>
                        <input type="text" name="event_Location" value="<?php echo htmlspecialchars($eventData['location']); ?>" class="event-box" required>
                    </div>

                    <div class="input-group">
                        <div class="row">
                            <label>Duration</label>
                            <span> *</span>
                        </div>
                        <input type="text" name="event_duration" value="<?php echo htmlspecialchars($eventData['duration']); ?>" class="event-box" required>
                    </div>
                </div>

                <div class="two-column">
                    <div class="input-group">
                        <div class="row">
                            <label>Capacity</label>
                            <span> *</span>
                        </div>
                        <input type="number" name="event_capacity" value="<?php echo $eventData['capacity']; ?>" class="event-box" required>
                    </div>

                    <div class="input-group">
                        <div class="row">
                            <label>Points Given</label>
                            <span> *</span>
                        </div>
                        <input type="number" name="event_points" value="<?php echo $eventData['points_given']; ?>" class="event-box" required>
                    </div>
                </div>

                <div class="input-group">
                    <div class="row">
                        <label>Description</label>
                        <span> *</span>
                    </div>
                    <textarea name="event_description" class="event-big-box" rows="5" required><?php echo htmlspecialchars($eventData['event_description']); ?></textarea>
                </div>

                <div class="input-group">
                    <div class="row">
                        <label>Event Poster</label>
                    </div>
                    <input type="file" name="event_poster" class="event-big-box">
                    <div style="margin-top: 10px;">
                        <small>Current poster: <?php echo basename($eventData['event_poster']); ?></small>
                    </div>
                </div>

                <button type="submit" class="btn-create-event">
                    Update Event
                </button>

                <div class="short-tagline">
                    Refine. Improve. Inspire.
                </div>
            </div>
        </section>
    </form>

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