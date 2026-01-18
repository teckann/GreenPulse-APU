<?php
    include("../conn.php");
    include("sessionData.php");
    include("utility.php");

    if ($role == "admin" || $role == "committee" || $role == "volunteer") {
        // greeting message
        echo "<script> alert('Welcome, ". $name ."'); </script>";

        // update last login day to database
        $todayDateTime = date("Y-m-d H:i:s");
        $sql = "UPDATE users SET last_login = '$todayDateTime' WHERE user_id = '$userID'";
        mysqli_query($conn, $sql);

        // record action into log
        // addLog($conn, $userID, "Successful Login");

        // main logic - redirection
        if ($role == "admin") {
            header("Location: ../pages/admin/index.php");
            exit;
        }
        else if ($role == "committee") {
            header("Location: ../pages/committee/index.php");
            exit;
        }
        else if ($role == "volunteer") {
            header("Location: ../pages/volunteer/index.php");
            exit;
        }
    }
?>