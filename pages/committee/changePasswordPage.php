<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    if (isset($_POST["btnConfirmChangePassword"])) {
        $newPassword1 = trim($_POST["newPasswordInput1"]);
        $newPassword2 = trim($_POST["newPasswordInput2"]);

        ?>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const input1 = document.querySelector("#newPasswordInput1");
                    const input2 = document.querySelector("#newPasswordInput2");

                    input1.value = <?php echo json_encode($newPassword1); ?>;
                    input2.value = <?php echo json_encode($newPassword2); ?>;
                });
            </script>
        <?php

        $errorMessage = "";

        if (empty($newPassword1) || empty($newPassword2)) {
            $errorMessage = "Please enter all the password fields provided!";
        }
        else if (strlen($newPassword1) < 8) {
            $errorMessage = "New password length must At Least 8 long!";
        }
        else if (!preg_match("/[a-z]/", $newPassword1)) {
            $errorMessage = "New password must contain at least One small letter!";
        }
        else if (!preg_match("/[0-9]/", $newPassword1)) {
            $errorMessage = "New password must contain at least One number!";
        }
        else if (!preg_match("/[A-Z]/", $newPassword1)) {
            $errorMessage = "New password must contain at least One capital letter!";
        }
        else if (!preg_match("/[\W_]/", $newPassword1)) {
            $errorMessage = "New password must contain at least One special character!";
        }
        else if ($newPassword1 != $newPassword2) {
            $errorMessage = "Please ensure both entered passwords are same";
        }
        else {
            $hash_password = password_hash($newPassword1, PASSWORD_DEFAULT);

            $sqlChangePassword = "UPDATE users SET password = '$hash_password' WHERE user_id = '$userID'";

            if (mysqli_query($conn, $sqlChangePassword)) {

                addLog($conn, $userID, "Update Password ($userID)");
                ?> 
                    <script>
                        alert("Password changed successfully.");
                        window.location.href = "index.php";
                    </script>
                <?php
            }
        }

        ?>
            <script>
                alert('<?php echo $errorMessage; ?>');
            </script>
        <?php
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include ("header.php") ?>

    <div id="changePasswordUpperPart">
        <div><button id='btnBackToSecurityMainPage' class='btnExitPopUps'><a href="securityMainPage.php"><i class="fa-solid fa-arrow-left"></i></a></button></div>
        <div id="changePasswordTextPart"><b id="changePasswordText">Password Changing Page</b></div>
    </div>
    <form action="#" method="POST">
        <div id="changePasswordBottomPart">
            <div class="changePasswordInput">
                <div id="newPassword1" class="newPassword">
                    <small>Password must be at least <b>8 charcters long</b> and include at least <b>one  Capital and Small letter</b>,<b> one number,</b> and <b>one character</b></small>
                    <br>
                    <label for="newPasswordInput1">New Password:</label>
                    <input type="password" name="newPasswordInput1" id="newPasswordInput1">
                </div>
                <div id="newPassword2" class="newPassword">
                    <label for="newPasswordInput2">Confirm Your Password Here:</label>
                    <input type="password" name="newPasswordInput2" id="newPasswordInput2">
                </div>
            </div>
            <div class="changePasswordBtns">
                <button class="btnConfirmChangePassword" name="btnConfirmChangePassword">Confirm</button>
            </div>
        </div>
    </form>

    <?php include ("hamburgerMenu.php");?>
</body>
</html>