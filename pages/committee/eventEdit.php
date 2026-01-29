<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    if (!isset($_GET['event_id'])) {
        echo "<script>alert('No event selected!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $eventID = mysqli_real_escape_string($conn, $_GET['event_id']);

    $sqlFetch = "SELECT * FROM events WHERE event_id = '$eventID'";
    $resultFetch = mysqli_query($conn, $sqlFetch);

    if (mysqli_num_rows($resultFetch) <= 0) {
        echo "<script>alert('Event not found!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $eventData = mysqli_fetch_assoc($resultFetch);

    if ($eventData['user_id'] != $_SESSION['userID']) {
        echo "<script>alert('You can only edit events you created!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["formType"]) && $_POST["formType"] === "editEvent") {
            
            $eventPosterPath = $eventData['event_poster'];
            
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
            
            $eventTitle = mysqli_real_escape_string($conn, $_POST['event_title']);
            $eventDateTime = mysqli_real_escape_string($conn, $_POST['event_datetime']);
            $eventDesc = mysqli_real_escape_string($conn, $_POST['event_description']);
            $duration = mysqli_real_escape_string($conn, $_POST['event_duration']);
            $location = mysqli_real_escape_string($conn, $_POST['event_Location']);
            $capacity = mysqli_real_escape_string($conn, $_POST['event_capacity']);
            $pointsGiven = mysqli_real_escape_string($conn, $_POST['event_points']);
            
            $sqlAttendance = "SELECT COUNT(*) as total_attendees FROM attendance WHERE event_id = '$eventID'";
            $resultAttendance = mysqli_query($conn, $sqlAttendance);
            $currentAttendees = 0;
            
            if ($resultAttendance) {
                $rowAttendance = mysqli_fetch_assoc($resultAttendance);
                $currentAttendees = $rowAttendance['total_attendees'];
            }
            $availableSpot = $capacity - $currentAttendees;

            if ($availableSpot < 0) {
                $availableSpot = 0;
            }

            $postedDate = date("Y-m-d");
            
            $sqlUpdate = "UPDATE events SET 
                            event_title = '$eventTitle',
                            event_poster = '$eventPosterPath',
                            event_description = '$eventDesc',
                            event_datetime = '$eventDateTime',
                            duration = '$duration',
                            location = '$location',
                            capacity = '$capacity',
                            points_given = '$pointsGiven',
                            posted_date = '$postedDate'
                        WHERE event_id = '$eventID'";
            
            if (mysqli_query($conn, $sqlUpdate)) {
                addLog($conn, $_SESSION['userID'], "Update Event Information: $eventID");
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
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include ("header.php");?>
    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>EDIT EVENT</h1>
            <p>UPDATE THE DETAILS TO REFINE YOUR GREEN INITIATIVE EVENT.</p>
        </div>

        <div class="back-icon-hidden" onclick="window.location.href='eventCreate.php'">
            <i class="fas fa-arrow-left"></i>
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

    <?php include ("hamburgerMenu.php");?>
</body>
</html>