<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");

    $sql = "SELECT * FROM users WHERE user_id = '$userID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $hashCurrentPassword = $row["password"];

        if ($_POST["formType"] === "updatePassword") {
            $newPassword = $_POST["newPassword"];

            if (password_verify($newPassword, $hashCurrentPassword)) {
                echo "<script>
                        alert('New password must differ from current password');
                        window.location.href = 'updateSecuritySettings.php';
                      </script>";
            }
            else {
                $hashNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $sql_updatePassword = "UPDATE users SET password = '$hashNewPassword'
                                       WHERE user_id = '$userID'";

                if (mysqli_query($conn, $sql_updatePassword)) {
                    echo "<script>
                            alert('--- Successfully Updated Password ---\\nAlways keep your profile details up to date.');
                            window.location.href = 'updateSecuritySettings.php';
                          </script>";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Account Security Settings</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Update Account Security Settings</h1>
            <h2 class="page-subTitle">Ensure your account remains protected</h2>

            <div class="flex-container security-settings-container">
                <a href="profile.php" style="text-decoration: none;" class="back-btn-anchor">
                    <button name="btnBack" class="back-btn" type="submit" value="Back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p>Back</p>
                    </button>
                </a>

                <div class="update-password-container">
                    <div class="new-password-input-container">
                        <form action="" method="POST" id="update-password-form">
                            <input type="text" name="formType" value="updatePassword" hidden>

                            <div class="new-password-input-box">
                                <label for="newPassword">New Password: </label>
                                <input type="password" name="newPassword" id="newPassword">
                                <div class="form-error-text" id="error-new-empty">Please enter new password</div>
                            </div>

                            <div class="new-password-input-box">
                                <label for="confirmPassword">Confirm New Password: </label>
                                <input type="password" name="confirmPassword" id="confirmPassword">
                                <div class="form-error-text" id="error-confirm-empty">Please enter again new password</div>
                                <div class="form-error-text" id="error-diffent">Passwords do not match</div>
                            </div>

                            <button class="update-security-btn" id="btnUpdatePassword">
                                <i class="fa-solid fa-key"></i>
                                <p>Update</p>
                            </button>
                        </form>
                    </div>

                    <div class="newPasswordFormat">
                        <p id="rule-length">
                            <strong>Length: </strong>
                            8-20 characters
                        </p>

                        <p id="rule-upper">
                            <strong>Uppercase: </strong>
                            At least one capital letter (A-Z)
                        </p>

                        <p id="rule-lower">
                            <strong>Lowercase: </strong>
                            At least one small letter (a-z)
                        </p>

                        <p id="rule-number">
                            <strong>Number: </strong>
                            At least one number (0-9)
                        </p>

                        <p id="rule-symbol">
                            <strong>Symbol: </strong>
                            At least one special character (!@#$%^&*)
                        </p>
                    </div>
                </div>
            </div>
        </main>
        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
        <script src="../../scripts/validation_updatePassword.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>