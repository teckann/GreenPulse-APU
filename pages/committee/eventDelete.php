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
        echo "<script>alert('You can only delete events you created!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $newStatus = ($eventData['event_status'] == 'Active') ? 'Inactive' : 'Active';
    
    $sqlUpdate = "UPDATE events SET event_status = '$newStatus' WHERE event_id = '$eventID'";

    if (mysqli_query($conn, $sqlUpdate)) {
        $action = ($newStatus == 'Inactive') ? 'Deactivated' : 'Reactivated';
        addLog($conn, $_SESSION['userID'], "Delete Event: $eventID");
        
        $message = ($newStatus == 'Inactive') ? 'Event deactivated successfully!' : 'Event reactivated successfully!';
        echo "<script>alert('$message'); window.location.href='eventMain.php';</script>";
    } else {
        echo "<script>alert('Error updating event status!'); window.location.href='eventMain.php';</script>";
    }
?>