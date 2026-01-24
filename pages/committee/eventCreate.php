<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    // 1. ONLY RUN THIS CODE IF THE FORM IS SUBMITTED
    // $_SERVER["REQUEST_METHOD"] means the how the page be request [POST or GET] 
    // POST = Submit Form
    // GET = Get data
    if ($_SERVER["REQUEST_METHOD"] === "POST") { 

        // 2. CHECK WHICH FORM WAS SENT (The hidden input)
        // isset = check is a variable existed and got data or not (null count as got data)
        // $_POST["formType"] === "createNewEvent") = check the form i submmited is this or not

        // This all is to prevent error 
        if (isset($_POST["formType"]) && $_POST["formType"] === "createNewEvent") {
            
            // --- A. FILE UPLOAD HANDLING ---
            $targetDir = "../../src/eventPosters/";
            // Why the poster is save to server folder? not directly to database?
            // If to database, then the database size will be too big.
            // So we use $targetDir = "../../src/eventPosters/"; = to save to server first, then we use this ../../src/eventPosters/ (route), to know where is the poster

            $fileName = basename($_FILES["event_poster"]["name"]);
            // ["event_poster"] = name from -> <input type="file" name="event_poster" class="event-big-box" required> 
            // ["name"] = the name of the user choose this picture
            // basename = i only want the picture name, dw C:\Users\Cynthia\Desktop


            $targetFilePath = $targetDir . $fileName;
            // This is like 2 = 1 + 1
            // $targetFilePath ("../../src/eventPosters/poster1.png") = $targetDir (../../src/eventPosters/) .(+) $fileName (poster1.png)

            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            // pathinfo = return (dirname) → "../../src/eventPosters"
            //          = return (basename) → "poster1.png"
            //          = return (extension) → "png"
            //          = return (filename) → "poster1"
            // PATHINFO_EXTENSION = i only want (png)
            // so $fileType = png
            
            $allowTypes = array('jpg','png','jpeg','gif','pdf', 'mp4');
            
            // Check if file is in valid format
            // strtolower = make the string to lower case
            // if(in_array(strtolower($fileType), $allowTypes)){ = check if the $fileType is same as the $allowTypes
            if(in_array(strtolower($fileType), $allowTypes)){
                if(move_uploaded_file($_FILES["event_poster"]["tmp_name"], $targetFilePath)){
                // the flow of php is: if you upload normal data, then ok php can get the data from $_POST
                // but if you uploaded video or picture, then the video or pic will send to server first, then put in a temperory file (tmp_name) [the route for the temporary file]
                // then use move_uploaded_file() to see move vid and pic want go to which file
                // if no write [move_uploaded_file] then the temporary file will be deleted, vid and pic cannot be uploaded
                // so now we need to move the "event poster" in "tmp_name" to "$targetFilePath" that we defined just now

                    $eventPosterPath = "src/eventPosters/" . $fileName; 
                    
                    // --- B. PREPARE DATA ---
                    // Note: We use mysqli_real_escape_string for security  
                    // $_POST['event_title'] = when the user submit the data, the data will send to 'event-title', then we get the data using $_POST to save the data to $eventTitle
                    // mysqli_real_escape_string($conn = to prevent SQL injection. ie: if a user entered ['); DROP TABLE events; --] then the SQL will drop the table
                    // we need to $conn to see which symbol will cause SQL injection
                    $eventTitle = mysqli_real_escape_string($conn, $_POST['event_title']);
                    $eventDateTime = mysqli_real_escape_string($conn, $_POST['event_datetime']);
                    $eventDesc = mysqli_real_escape_string($conn, $_POST['event_description']);
                    
                    // MAPPING HTML NAMES TO DB COLUMNS (Based on your SQL)
                    $duration = mysqli_real_escape_string($conn, $_POST['event_duration']); 
                    $location = mysqli_real_escape_string($conn, $_POST['event_Location']);
                    $capacity = mysqli_real_escape_string($conn, $_POST['event_capacity']);
                    $pointsGiven = mysqli_real_escape_string($conn, $_POST['event_points']);

                    
                    // if got $userID then use that userID, if no then use user id from $_SEESION
                    $creatorID = isset($userID) ? $userID : $_SESSION['user_id'];

                    // Generate Event ID (Simple auto-increment simulation or random string)
                    // You can improve this logic later, but for now let's just use a random ID
                    $eventID = "E" . rand(1000, 9999); 

                    // Set initial available spots equal to capacity
                    $availableSpot = $capacity;
                    
                    $postedDate = date("Y-m-d"); // Today's date

                    // --- C. SQL QUERY (UPDATED TO MATCH YOUR SCHEMA) ---
                    $sql = "INSERT INTO events (
                                event_id, 
                                user_id, 
                                event_title, 
                                event_poster, 
                                event_description, 
                                event_datetime, 
                                duration,        -- DB Column name
                                location,        -- DB Column name
                                capacity,        -- DB Column name
                                available_spot, 
                                points_given,    -- DB Column name
                                posted_date
                            ) VALUES (
                                '$eventID',
                                '$creatorID',
                                '$eventTitle',
                                '$eventPosterPath',
                                '$eventDesc',
                                '$eventDateTime',
                                '$duration',
                                '$location',
                                '$capacity',
                                '$availableSpot',
                                '$pointsGiven',
                                '$postedDate'
                            )";

                    // Execute Query
                    if (mysqli_query($conn, $sql)) {
                        echo "<script>
                                alert('Event Created Successfully!'); 
                                window.location.href='eventMain.php';
                            </script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                } else {
                    echo "<script>alert('Error uploading file. Check folder permissions.');</script>";
                }
            } else {
                echo "<script>alert('Invalid file type. Only JPG, PNG, GIF, MP4 allowed.');</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navigation (Keeping your existing nav structure) -->
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

    <!-- Banner -->
    <div class = "banner">
        <marquee direction = "right" scrollamount = "10">
            <p>Join our upcoming Recycling Workshop on Dec 30! Learn, create, and make a difference for a greener tomorrow.</p>
        </marquee>
    </div>

    
    <!-- hero -->
    <div class="header-content">
            <div class="back-icon" onclick="history.back()">
                <i class="fas fa-arrow-left"></i>
            </div>
            
            <div class="heroSection">
                <h1>CREATE NEW EVENT</h1> <p>FILL IN THE DETAILS TO LAUNCH A GREEN INITIATIVE.</p>
            </div>
        </div>

        <!-- 
        1. Added enctype="multipart/form-data" (Required for files)
        2. Added formType="createNewEvent" (Required for PHP to identify the form)
        if add file must include enctype="multipart/form-data
        -->
        <form action="eventCreate.php" method="POST" enctype="multipart/form-data">
            
            <!-- Why need hidden? Bcos idw let user to see it, but I need to let php know so i hidden-->
            <!-- This info i want let php know: name="formType" value="createNewEvent" -->
            <input type="hidden" name="formType" value="createNewEvent">

            <section class="event-controls-event-main">
                <div class = "white-color-box">

                    <div class = "two-column">
                        <div class="input-group">
                            <label>Event name</label>
                            <input type="text" name="event_title" placeholder="Enter the event name" class="event-box" required>
                        </div>

                        <div class="input-group">
                            <label>Event Date Time</label>
                            <input type="datetime-local" name="event_datetime" class="event-box" required>  
                        </div>
                    </div>


                    <div class = "two-column">
                        <div class="input-group">
                            <label>Location</label>
                            <!-- Name matches PHP: $_POST['event_Location'] -->
                            <input type="text" name="event_Location" placeholder="S-08-01" class="event-box" required>
                        </div>

                        <div class="input-group">
                            <label>Duration</label>
                            <!-- Name matches PHP: $_POST['event_duration'] -->
                            <input type="text" name="event_duration" placeholder="2 hours" class="event-box" required>
                        </div>
                    </div>

                    <div class = "two-column">
                        <div class="input-group">
                            <label>Available Spots</label>
                            <!-- Name matches PHP: $_POST['event_capacity'] -->
                            <input type="number" name="event_capacity" placeholder="50" class="event-box" required>
                        </div>

                        <div class="input-group">
                            <label>Points Given</label>
                            <!-- Name matches PHP: $_POST['event_points'] -->
                            <input type="number" name="event_points" placeholder="100" class="event-box" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Description</label>
                        <textarea name="event_description" placeholder="Event Description" class="event-big-box" rows="5" required></textarea>
                    </div>

                    <div class="input-group">
                        <label>Event Poster</label>
                        <input type="file" name="event_poster" class="event-big-box" required>
                    </div>
                    
                    <button type="submit" class="btnCreateEvent">
                        Create Event
                    </button>

                    <div class = "short-tagline">
                        Create. Inspire. Impact.
                    </div>

                </div>
            </section>
        </form>

    <!-- Scripts -->
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
