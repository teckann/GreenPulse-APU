<?php

    include("../../conn.php");

    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];

    $sql_security_data = "SELECT password, safety_question_1, safety_question_2 
                       FROM users WHERE user_id = '$userID'";

    $securityData = mysqli_fetch_assoc(mysqli_query($conn, $sql_security_data));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">


    <title>Security</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <?php include("header.php") ?>

    <div class="profileHead">
        <div>
            <a href="profile.php" class="backEvent">
                <i class="fa-solid fa-arrow-left"></i>
            </a> 
            <span class="securityPageTitle">Account Security</span>
        </div>
    </div>

    <div class="securityContainer">

        <div class="securitySection">
            <h2 class="securitySectionTitle">Password</h2>
            
            <div class="securityLine">
                <div class="securityLabel">Password</div>
                <div class="securityText" id="passwordText">
                    ***************
                </div>
            </div>

            <div class="securityBtnContainer">
                <form action="editSecurity.php" method="post">
                    <button type="submit" class="securityBtn" name="changingPassword">
                        Change Password
                    </button> 
                </form>
            </div>
        </div>

        <div class="securitySection">
            <h2 class="securitySectionTitle">Safety Question</h2>
            
            <div class="securityLine" id="lineQuestion1">
                <div class="securityLabel">Question 1</div>
                <div class="securityText">
                    <?php echo $securityData["safety_question_1"] ?>
                </div>
            </div>

            <div class="securityLine" id="lineQuestion2">
                <div class="securityLabel">Question 2</div>
                <div class="securityText">
                    <?php echo $securityData["safety_question_2"] ?>
                </div>
            </div>

            <div class="securityBtnContainer" >
                <form action="editSecurity.php" method="post">
                    <button type="submit" class="securityBtn" name="changingSafetyQuestion">
                        Change Question
                    </button>
                </form>
            </div>
        </div>

        <div class="deleteSection">
            <button class="deleteAccountBtn">Delete Account</button>
        </div>

    </div>
</body>
</html>