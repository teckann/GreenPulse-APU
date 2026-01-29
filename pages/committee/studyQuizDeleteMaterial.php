<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    if (!isset($_GET['module_id'])) {
        echo "<script>alert('No module selected!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $moduleID = mysqli_real_escape_string($conn, $_GET['module_id']);


    $sqlFetch = "SELECT * FROM modules WHERE module_id = '$moduleID'";
    $resultFetch = mysqli_query($conn, $sqlFetch);

    if (mysqli_num_rows($resultFetch) <= 0) {
        echo "<script>alert('Module not found!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $moduleData = mysqli_fetch_assoc($resultFetch);


    if ($moduleData['user_id'] != $_SESSION['userID']) {
        echo "<script>alert('You can only delete events you created!'); window.location.href='eventMain.php';</script>";
        exit;
    }
    $newStatus = ($moduleData['module_status'] == 'Active') ? 'Inactive' : 'Active';
    
    $sqlUpdate = "UPDATE modules SET module_status = '$newStatus' WHERE module_id = '$moduleID'";

    if (mysqli_query($conn, $sqlUpdate)) {
        $action = ($newStatus == 'Inactive') ? 'Deactivated' : 'Reactivated';
        addLog($conn, $_SESSION['userID'], "Delete Module: $moduleID");
        
        $message = ($newStatus == 'Inactive') ? 'Module deactivated successfully!' : 'Event reactivated successfully!';
        echo "<script>alert('$message'); window.location.href='eventMain.php';</script>";
    } else {
        echo "<script>alert('Error updating module status!'); window.location.href='studyQuizMain.php';</script>";
    }
?>