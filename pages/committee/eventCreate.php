<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    if (!isset($_SESSION['userID'])) {
        echo "<script>alert('Please login first!'); window.location.href='../../pages/guest/login.php';</script>";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") { 
        if (isset($_POST["formType"]) && $_POST["formType"] === "createNewEvent") {
            $targetDir = "../../src/eventPosters/";
            $fileName = basename($_FILES["event_poster"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg','gif','pdf', 'mp4');
            if(in_array(strtolower($fileType), $allowTypes)){
                if(move_uploaded_file($_FILES["event_poster"]["tmp_name"], $targetFilePath)){

                    $eventPosterPath = "src/eventPosters/" . $fileName; 
                    $eventTitle = mysqli_real_escape_string($conn, $_POST['event_title']);
                    $eventDateTime = mysqli_real_escape_string($conn, $_POST['event_datetime']);
                    $eventDesc = mysqli_real_escape_string($conn, $_POST['event_description']);
                    $duration = mysqli_real_escape_string($conn, $_POST['event_duration']); 
                    $location = mysqli_real_escape_string($conn, $_POST['event_Location']);
                    $capacity = mysqli_real_escape_string($conn, $_POST['event_capacity']);
                    $pointsGiven = mysqli_real_escape_string($conn, $_POST['event_points']);

                    $creatorID = isset($userID) ? $userID : $_SESSION['user_id'];
                    $eventID = newID($conn, "events", "E"); // use utility.php
                    $availableSpot = $capacity;
                    
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $postedDate = date("Y-m-d"); 
                  
                    $sql = "INSERT INTO events (
                                event_id, 
                                user_id, 
                                event_title, 
                                event_poster, 
                                event_description, 
                                event_datetime, 
                                duration,       
                                location,        
                                capacity,       
                                points_given,    
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
                                '$pointsGiven',
                                '$postedDate'
                            )";

  
                    if (mysqli_query($conn, $sql)) {
                        addLog($conn, $creatorID, "Add New Event: $eventID");
                      
                        echo "<script>
                                alert('Event Created Successfully!'); 
                                window.location.href='eventMain.php';
                              </script>";
                        exit; 
                        
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
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">

</head>
<body>
    <?php include ("header.php");?>


        <div class="header-content">
            <div class="back-icon" onclick="history.back()">
                <i class="fas fa-arrow-left"></i>
            </div>
            
            <div class="heroSection">
                <h1>CREATE NEW EVENT</h1> <p>FILL IN THE DETAILS TO LAUNCH A GREEN INITIATIVE.</p>
            </div>

            <div class="back-icon-hidden" onclick="window.location.href='eventCreate.php'">
                <i class="fas fa-arrow-left"></i>
            </div>
            
            
        </div>

       
        <form action="eventCreate.php" method="POST" enctype="multipart/form-data">
            
            
            <input type="hidden" name="formType" value="createNewEvent">

            <section class="event-controls-event-main">
                <div class = "white-color-box">
                    <div class = "two-column">
                        <div class="input-group">
                            <div class = "row">
                                <label>Event Name</label>
                                <span> *</span>
                            </div>
                            <input type="text" name="event_title" placeholder="e.g. Go Green: Campus Cleanup Day" class="event-box" required>
                        </div>

                        <div class="input-group">
                            <div class = "row">
                                <label>Event Date Time</label>
                                <span> *</span>
                            </div>
                            <input type="datetime-local" name="event_datetime" class="event-box" required>  
                        </div>
                    </div>


                    <div class = "two-column">
                        <div class="input-group">
                            <div class = "row">
                                <label>Location</label>
                                <span> *</span>
                            </div>
                       
                            <input type="text" name="event_Location" placeholder="e.g. Level 3 | APU Campus" class="event-box" required>
                        </div>

                        <div class="input-group">
                            <div class = "row">
                                <label>Duration</label>
                                <span> *</span>
                            </div>
                            
                            <input type="text" name="event_duration" placeholder="e.g. 3h" class="event-box" required>
                        </div>
                    </div>

                    <div class = "two-column">
                        <div class="input-group">
                            <div class = "row">
                                <label>Available Spot</label>
                                <span> *</span>
                            </div>
                           
                            <input type="number" name="event_capacity" placeholder="e.g. 50" class="event-box" required>
                        </div>

                        <div class="input-group">
                            <div class = "row">
                                <label>Points Given</label>
                                <span> *</span>
                            </div>
                           
                            <input type="number" name="event_points" placeholder="e.g. 100" class="event-box" required>
                        </div>
                    </div>


                    <div class="input-group">
                        <div class = "row">
                                <label>Description</label>
                                <span> *</span>
                            </div>
                        <textarea name="event_description" placeholder="Share your event’s green goals and activities..." class="event-big-box" rows="5" required></textarea>
                    </div>

                    
                    <div class="input-group">
                        <div class = "row">
                                <label>Event Poster</label>
                                <span> *</span>
                            </div>
                        <input type="file" name="event_poster" class="event-big-box" required>
                    </div>
         
                  
                    <button type="submit" class="btn-create-event">
                        <p>Create Event</p>
                    </button>
                   

                    <div class = "short-tagline">
                        Create. Inspire. Impact.
                    </div>
                  

                </div>
            </section>
        </form>

    <?php include ("hamburgerMenu.php");?>
</body>
</html>
