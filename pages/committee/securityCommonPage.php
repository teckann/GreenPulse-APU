<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    $sql= "SELECT * FROM users WHERE user_id = '$userID'";

    $result = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $hash_password = $row["password"];
    }

    if (isset($_POST["btnConfirmVerify"])) {

        $passwordInput = $_POST["passwordInput"];

        if (password_verify($passwordInput, $hash_password)) {
            ?>
                <script>
                    window.location.href = "securityMainPage.php";
                </script>
            <?php
        }
        else {
            ?>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const errorHint = document.querySelector("#passwordHint");
                        errorHint.style.display = "block";
                    })
                </script>
            <?php
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Checking Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include ("header.php");?>
    <div id="safetyVerifyUpperPart">
        <div><button id='btnBackToMainPage' class='btnExitPopUps'><a href="index.php"><i class="fa-solid fa-arrow-left"></i></a></button></div>
        <div id="safetyVerityTextPart"><b id="safetyVerityText">Password Verification</b></div>
    </div>
    <form action="#" method="POST">
        <div id="safetyVerifyBottomPart">
            <div class="safetyVerifyDescription">
                <p>For safety purpose, you are required to fill in password before you enter safety settings page.</p>
            </div>
            <div class="safetyVerifyContainer">
                <div>
                    <label for="passwordInput">Enter your password here</label>
                    <input type="password" name="passwordInput" id="passwordInput">
                    <small class="errorMessages" id="passwordHint">Password incorrect, please try again.</small>
                </div>
                <div>
                    <button class="safetyPasswordInput" name="btnConfirmVerify">Verify</button>
                </div>
            </div>
        </div>
    </form>
    <?php include ("hamburgerMenu.php");?>
</body>
</html>

