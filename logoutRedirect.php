<?php
    // continue the session first
    session_start();

    // remove the data
    $_SESSION["userID"] = NULL;
    $_SESSION["userName"] = NULL;
    $_SESSION["role"] = NULL;
    
    // remove the session
    unset($_SESSION["userID"]);
    unset($_SESSION["userName"]);
    unset($_SESSION["role"]);

    // close the session
    session_destroy();

    // pop-up message
    echo "<script> alert('Logout Successful') </script>";
    header("Location: index.php");
    exit;
?>