<?php
    include("../../conn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Information</title>
    <link rel="stylesheet" href="../../styles/guest.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include("header.php") ?>

    <main class="register">
        <div class="backButtonPart">
            <div><button id='btnBackToLogInPage' class='btnExitPage'><a href="registerPage1.php"><i class="fa-solid fa-arrow-left" style="color: #fff;"></i></a></button></div>
        </div>
        <div class="userRegisterHeader">
            <h1>User Registration</h1>
            <div class="registerTitlePart"><i class="fa-solid fa-envelope" style="color: #194a7a"></i><h3 class="registerTitle"></h3></div>
        </div>
        <div class="registerVideoPart">
            <video autoplay muted loop playsinline width="100%">
                <source src="../../src/elements/RegistrationVideo.mp4" type="video/mp4">
            </video>
        </div>
        <form action="#" method="POST" class="registerEmailForm">
            <div class="registerEmailPart">
                <h4 class="email-title">Email Address</h4>
                <div class="registerEmailInputPart">
                    <input type="text" name="registerEmail" id="registerEmail" placeholder="e.g. TP123456">
                    <p>@mail.apu.edu.my</p>
                </div>
            </div>
            <div class="btnVerifyEmails">
                <button id="btnVerifyEmail">Next Page</button>
            </div>
        </form>
    </main>


</body>
</html>