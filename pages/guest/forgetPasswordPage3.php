<?php
    include("../../conn.php");
    session_start();
    
    if (isset($_POST["btnSubmitPassword"])) {
        
        $newPassword1 = trim($_POST["resetPassword1"]);
        $newPassword2 = trim($_POST["resetPassword2"]);
        
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
        else if (password_verify($newPassword1, $_SESSION["oldPassword"])) {
            $errorMessage = "The new password cannot same as old one.";
        }
        else {

            $_SESSION["hash_password"] = password_hash($newPassword1, PASSWORD_DEFAULT);

            $sqlUpdatePassword = "UPDATE users SET password = '{$_SESSION['hash_password']}' WHERE user_id = '{$_SESSION["userIdInput"]}'";

            if (mysqli_query($conn, $sqlUpdatePassword)) {

                addLog($conn, $_SESSION["userIdInput"], "Reset Password ({$_SESSION['userIdInput']})");

                ?>
                    <script>
                        alert('Password change successfully!');
                        window.location.href = "login.php";
                    </script>
                <?php
                exit;
            }
        }

        ?>
            <script>
                alert('<?php echo $errorMessage; ?>');
                window.location.href = "forgetPasswordPage3.php";
            </script>
        <?php
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="../../styles/guest.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include("header.php") ?>

    <main class="forgetPassword">
        <div class="backButtonPart">
            <div><button id='btnBackToLogInPage' class='btnExitPage'><a href="forgetPasswordPage2.php"><i class="fa-solid fa-arrow-left" style="color: #fff;"></i></a></button></div>
        </div>
        <div class="userForgotPasswordHeader">
            <h1>Forget Password</h1>
            <div class="forgetPasswordTitlePart"><i class="fa-solid fa-lock" style="color: #194a7a"></i><h3 class="forgetPasswordTitle">Reset Password</h3></div>
        </div>
        <form action="#" method="POST" class="forgetPasswordForm">
            <div class="resetPasswordInputs">
                <small>Password must be at least <b>8 charcters long</b> and include at least <b>one  Capital and Small letter</b>,<b> one number,</b> and <b>one character</b></small>
            </div>
            <div class="resetPasswordInputs">
                <label for="resetPassword1">Password</label>
                <input type="password" name="resetPassword1" id="resetPassword1">
            </div>
            <div class="resetPasswordInputs">
                <label for="resetPassword2">Confirm Password</label>
                <input type="password" name="resetPassword2" id="resetPassword2">
            </div>
            <div class="btnSubmitPasswords">
                <button id="btnSubmitPassword" name="btnSubmitPassword">Confirm </button>
            </div>
        </form>
    </main>


</body>
</html>