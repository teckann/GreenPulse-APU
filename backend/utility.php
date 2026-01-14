<?php
    function newID($conn, $tableName, $character) {
        $sql_count = "SELECT COUNT(*) AS total FROM $tableName";
        $result_count = mysqli_query($conn, $sql_count);
        $row = mysqli_fetch_assoc($result_count);
        $total = $row["total"];

        $newID = "";
        $newNumber = $total + 1;

        if ($total == 0) {
            $newID = $character . "001";
        } 
        elseif ($total < 9) {
            $newID = $character . "00" . $newNumber;
        } 
        elseif ($total < 99) {
            $newID = $character . "0" . $newNumber;
        } 
        elseif ($total < 999) {
            $newID = $character .$newNumber;
        }

        return $newID;
    }
    
    function statusColor($status) {
        if ($status === "Active") {
            return "#28a745";
        }
        elseif ($status === "Inactive") {
            return "#dc3545";
        }
    }

    function reformat_dateTime($dateTime) {
        return date("d M Y (g:i A)", strtotime($dateTime));
    }
    
    function timeRemaining($conn, $eventID) {
        $sql = "SELECT event_datetime, duration FROM events WHERE event_id = '$eventID'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $startTime = $row["event_datetime"];
        $duration = $row["duration"];

        $now = time();
        $start = strtotime($startTime);

        $filter = str_replace(['h', 'm'], '', $duration);
        $parts = explode(' ', trim($filter));
        $durationHours = isset($parts[0]) ? (int)$parts[0] : 0;
        $durationMinutes = isset($parts[1]) ? (int)$parts[1] : 0;

        // find the end time
        $end = $start + ($durationHours * 3600) + ($durationMinutes * 60);

        // event havent start
        if ($now < $start) {
            $remaining = $start - $now;
            $days = floor($remaining / 86400);
            $hoursRemain = floor(($remaining % 86400) / 3600);
            return $days . " days " . $hoursRemain . " hours remaining";
        } 
        elseif ($now <= $end) {
            return "In progress";
        } 
        else {
            return "End";
        }
    }
?>