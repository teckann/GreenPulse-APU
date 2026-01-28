<?php
    // continue the session
    session_start();
    
    $userID = $_SESSION["userID"];
    $userName = $_SESSION["userName"];
    $userEmail = $_SESSION["userEmail"];
    $userDOB = $_SESSION["userDOB"];
    $userGender = $_SESSION["userGender"];
    $userCourse = $_SESSION["userCourse"];
    $userNationality = $_SESSION["userNationality"];
    $userContactNumber = $_SESSION["userContactNumber"];
?>