<?php
    try {
        $db_server = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "greenpulse_apu";
        $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
    }
    catch (mysqli_sql_exception) {
        echo "Exception: Database connection failed!";
    }
?>