<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

    if (!isset($_GET['event_id'])) {
        echo "<script>alert('No event selected!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $eventID = mysqli_real_escape_string($conn,$_GET['event_id']);
    $sqlEventID = " SELECT * FROM events WHERE event_id = '$eventID'";
    $resultEventID = mysqli_query ($conn,$sqlEventID);

    if (mysqli_num_rows($resultEventID) <= 0) {
        echo "<script>alert('Event not found!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $eventData = mysqli_fetch_assoc($resultEventID);

    // Handle attendance update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_attendance'])) {
        $userID = mysqli_real_escape_string($conn, $_POST['user_id']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        
        $updateSql = "UPDATE attendance SET attendance_status = '$status' 
                      WHERE event_id = '$eventID' AND user_id = '$userID'";
        mysqli_query($conn, $updateSql);
        
        // Redirect to prevent form resubmission
        header("Location: eventAttendance.php?event_id=" . $eventID);
        exit;
    }

    $sql = "SELECT a.*, u.name
    FROM attendance a 
    LEFT JOIN users u ON a.user_id = u.user_id
    WHERE a.event_id = '$eventID' ORDER BY a.event_register_datetime DESC";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Attendance</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
   <?php include ("header.php");?>

    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>EVENT ATTENDANCE</h1>
            <p>CREATE AND MANAGE GREEN INITIATIVE EVENTS.</p>
        </div>
    </div>

<section class="event-controls-event-main">
    <div class="white-color-box">
        <span class="title"> Attendance</span>

        <?php
            if (mysqli_num_rows($result) <= 0) {
                echo "<p style='text-align: center; padding: 20px;'>No attendance records for this event.</p>";
            }
            else {
                $counter = 1;
                while ($rows = mysqli_fetch_array($result)){
            ?>
        
        <div class="attendance-row">
            <span class="numbering"><?php echo $counter++; ?></span>
            <span class="attendance-user-id"><?php echo $rows['user_id']?></span>
            <span class="name"><?php echo $rows['name']?></span>
            <span class="attendance-date-time"><?php echo $rows['event_register_datetime']?></span>
            <div class="attendance-status">
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="user_id" value="<?php echo $rows['user_id']; ?>">
                    <input type="hidden" name="status" value="Present">
                    <button type="submit" name="update_attendance" class="btn-present green-color" 
                            style="<?php echo ($rows['attendance_status'] == 'Present') ? 'font-weight: bold; opacity: 1;' : 'opacity: 0.6;'; ?>">
                        Present
                    </button>
                </form>
                
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="user_id" value="<?php echo $rows['user_id']; ?>">
                    <input type="hidden" name="status" value="Absent">
                    <button type="submit" name="update_attendance" class="btn-absent red-color"
                            style="<?php echo ($rows['attendance_status'] == 'Absent') ? 'font-weight: bold; opacity: 1;' : 'opacity: 0.6;'; ?>">
                        Absent
                    </button>
                </form>
            </div>
        </div>

      <?php 
    } 
} 
?>
    </div>
</section>

    <?php include ("hamburgerMenu.php");?>
</body>
</html>