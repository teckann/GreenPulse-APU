<?php
    include("../conn.php");
    include("sessionData.php");

    if ($role == "admin" || $role == "committee" || $role == "volunteer") {
        // greeting message
        echo "<script> alert('Welcome, ". $name ."'); </script>";

        // update last login day to database
        $todayDateTime = date("Y-m-d H:i:s");
        $sql = "UPDATE users SET last_login = '$todayDateTime' WHERE user_id = '$userID'";
        mysqli_query($conn, $sql);

        // add this event into log activity
        $logEvent = "Successful Login";

        // count the total records
        $sql_count = "SELECT COUNT(*) AS total FROM log";
        $result_count = mysqli_query($conn, $sql_count);
        $row = mysqli_fetch_assoc($result_count);
        $total = $row["total"];

        // generate Log ID
        $logID = "";
        $newNumber = $total + 1;

        if ($total == 0) {
            $logID = "L001";
        } 
        elseif ($total < 9) {
            $logID = "L00" .$newNumber;
        } 
        elseif ($total < 99) {
            $logID = "L0" .$newNumber;
        } 
        elseif ($total < 999) {
            $logID = "L" .$newNumber;
        }

        // add into database
        // * FINISH (runable code)
        // ! Uncomment it once all features done
        // $sql_addLog = "INSERT INTO log (log_id, user_id, log_event, log_datetime)
        //                VALUES ('$logID', '$userID', '$logEvent', '$todayDateTime')";
        // mysqli_query($conn, $sql_addLog);

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