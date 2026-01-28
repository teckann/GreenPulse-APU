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
    <title>Register Information</title>
    <link rel="stylesheet" href="../../styles/guest.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include("header.php") ?>

    <main class="register">
        <div class="backButtonPart">
            <div><button id='btnBackToRegisterPage1' class='btnExitPage'><a href="registerPage1.php"><i class="fa-solid fa-arrow-left" style="color: #fff;"></i></a></button></div>
        </div>
        <div class="userRegisterHeader">
            <h1>User Registration</h1>
            <div class="registerTitlePart"><i class="fa-solid fa-circle-info" style="color: #194a7a"></i><h3 class="registerTitle">Information Collection Page</h3></div>
        </div>
        <form action="#" method="POST" class="registerInformationForm">
            <div class="registerInformationInput">
                <label for="registerName">Name</label>
                <input type="text" name="registerName" placeholder="Enter Name">
            </div>
            <div class="registerInformationInput">
                <label for="registerDOB">Date Of Birth</label>
                <input type="date" name="registerDOB" id="registerDOB">
            </div>
            <div class="registerInformationInput">
                <label for="registerGender">Gender</label>
                <select name="registerGender" id="registerGender">
                    <option value="">--Please Select--</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
            <div class="registerInformationInput">
                <label for="course">Course Name</label>
                <?php include("../general/course.php"); ?>
            </div>
            <div class="registerInformationInput">
                <label for="nationality">Nationality</label>
                <?php include("../general/nationality.php"); ?>
            </div>
            <div class="registerInformationInput">
                <label for="contactNumber">Contact Number</label>
                <input type="text" name="contactNumber" id="contactNumber" placeholder="0123456789">
            </div>
            <div class="btnSubmitInformations">
                <button id="btnSubmitInformation">Next Page</button>
            </div>
        </form>
    </main>


</body>
</html>