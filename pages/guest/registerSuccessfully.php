<?php
    include("../../conn.php");
    session_start();

    $email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Successfully Page</title>
    <link rel="stylesheet" href="../../styles/guest.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include("header.php") ?>

    <main class="register">
        <div class="backButtonPart">
            <div><button id='btnBackToRegisterPage3' class='btnExitPage'><a href="registerPage3.php"><i class="fa-solid fa-arrow-left" style="color: #fff;"></i></a></button></div>
        </div>
        <div class="userRegisterHeader">
            <h1>User Registration</h1>
            <div class="registerTitlePart"><h3 class="registerTitle">Register Successfully🎉</h3></div>
        </div>
        <div class="successfullyInfo">
            <div class="successInfoShow">
                <h3>Your ID is</h3>
                <input type="text" id="newId" value="" readonly>
            </div>
        </div>
        <div class="successfullyInfo">
            <div class="successInfoShow">
                <h3>Password</h3>
                <input type="text" id="password" value="" readonly>
            </div>
        </div>
        <p>
            Try to explore our platform right now!
        </p>
        <h2>
            <a href="login.php">Log In Page</a>
        </h2>
    </main>


</body>
</html>