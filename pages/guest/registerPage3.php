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
    <title>Register Password</title>
    <link rel="stylesheet" href="../../styles/guest.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include("header.php") ?>

    <main class="register">
        <div class="backButtonPart">
            <div><button id='btnBackToRegisterPage2' class='btnExitPage'><a href="registerPage2.php"><i class="fa-solid fa-arrow-left" style="color: #fff;"></i></a></button></div>
        </div>
        <div class="userRegisterHeader">
            <h1>User Registration</h1>
            <div class="registerTitlePart"><i class="fa-solid fa-circle-info" style="color: #194a7a"></i><h3 class="registerTitle">Password Setting Page</h3></div>
        </div>
        <form action="#" method="POST" class="registerPassword">
            <div class="registerPasswordInput">
                <label for="registerPassword1">Password</label>
                <input type="password" name="registerPassword1" id="registerPassword1">
            </div>
            <div class="registerPasswordInput">
                <label for="registerPassword2">Confirm Password</label>
                <input type="password" name="registerPassword2" id="registerPassword2">
            </div>
            <div class="btnSubmitInformations">
                <button id="btnSubmitInformation">Confirm </button>
            </div>
        </form>
    </main>


</body>
</html>