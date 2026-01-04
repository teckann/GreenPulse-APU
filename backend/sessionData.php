<?php
    // continue the session
    session_start();

    // get the data that store at session
    $userID = $_SESSION["userID"];
    $userName = $_SESSION["userName"];
    $role = $_SESSION["role"];

    // always make sure section active, else redirect to guest index page
    if (!isset($_SESSION["userID"])) {
	    header("Location: ../../pages/guest/login.php");
        // header("Location: ../../index.php");
        exit;
	} 
?>