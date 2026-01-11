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
?>