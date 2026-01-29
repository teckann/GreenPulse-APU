<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    $sqlSafetyQuestion = "SELECT * FROM users WHERE user_id = '$userID'";

    $result = mysqli_query($conn, $sqlSafetyQuestion);

    if ($row = mysqli_fetch_assoc($result)) {
        $safetyQuestion1 = $row["safety_question_1"];
        $safetyQuestion2 = $row["safety_question_2"];

        if ($safetyQuestion1 == "") {
            $safetyQuestion1 = "-";
        }
        if ($safetyQuestion2 == "") {
            $safetyQuestion2 = "-";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include ("header.php");?>
    <div id="safetyMainPageUpperPart">
        <div><button id='btnBackToMainPage' class='btnExitPopUps'><a href="index.php"><i class="fa-solid fa-arrow-left"></i></a></button></div>
        <div id="safetyVerityTextPart"><b id="safetyVerityText">Password Verification</b></div>
    </div>
    <div id="safetyMainPageBottomPart">
        <div id="securityPasswordPart">
            <h2 class="securityTitle"><i class="fa-solid fa-lock"></i>     <b>Password</b></h2>
            <div id="securityPasswordHash"><b>********************</b></div>
            <button id="securityChangePasswordBtn"><a href="changePasswordPage.php">Change Password</a></button>
        </div>
        <div id="securitySafetyQuestionPart">
            <h2 class="securityTitle"><b><i class="fa-solid fa-circle-question">           </i>Safety Question</b></h2>
            <div class="safetyQuestions">
                <div><p>Question 1: <span id="safetyQuestion1Display"><?php echo $safetyQuestion1; ?></span></p></div>
                <div><p>Question 2: <span id="safetyQuestion2Display"><?php echo $safetyQuestion2; ?></span></p> </div>
            </div>
            <button id="securityChangeSafetyQuestionBtn"><a href="changeSafetyQuestionPage.php">Change Safety Question</a></button>
        </div>
    </div>
    <?php include ("hamburgerMenu.php");?>
</body>
</html>