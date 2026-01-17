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
                            alert('--- Successfully Updated Password ---\\nYour account is now more secure.');
                            window.location.href = 'updateSecuritySettings.php';
                          </script>";
                }
            }
        }

        if ($_POST["formType"] === "updateSecurityQuestion") {
            $newQ1 = $_POST["securityQuestion1"];
            $newQ2 = $_POST["securityQuestion2"];
            $newA1 = trim($_POST["answer1"]);
            $newA2 = trim($_POST["answer2"]);

            if ($newQ1 === $row["safety_question_1"] && $newA1 === $row["answer_1"] && 
                $newQ2 === $row["safety_question_2"] && $newA2 === $row["answer_2"]) {
                
                echo "<script>
                        alert('You look like didn\'t make any changes.');
                        window.location.href = 'updateSecuritySettings.php';
                      </script>";
            }
            else {
                $sql_updateQuestion = "UPDATE users SET 
                                       safety_question_1 = '$newQ1', answer_1 = '$newA1',
                                       safety_question_2 = '$newQ2', answer_2 = '$newA2'
                                       WHERE user_id = '$userID'";

                if (mysqli_query($conn, $sql_updateQuestion)) {
                    echo "<script>
                            alert('--- Successfully Updated Safety Questions ---\\nYour account is now more secure.');
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

                <div class="update-qeustion-container">
                    <form action="" method="POST" id="update-question-form">
                        <input type="text" name="formType" value="updateSecurityQuestion" hidden>

                        <div class="question-input-box">
                            <label for="securityQuestion1">Security Question 1: </label>
                            <select name="securityQuestion1" id="securityQuestion1">
                                <option value="">-- Please Select --</option>
                                <option value="What is your secondary school name?">What is your secondary school name?</option>
                                <option value="What is your mother's middle name?">What is your mother's middle name?</option>
                                <option value="What is your favorite color?">What is your favorite color?</option>
                                <option value="What is your first car brand?">What is your first car brand?</option>
                                <option value="What is the city name were you born in?">What is the city name were you born in?</option>
                            </select>
                            <div class="form-error-text" id="error-question1">Please select question</div>
                        </div>

                        <div class="question-input-box">
                            <label for="answer1">Answer for Question 1: </label>
                            <input type="text" name="answer1" id="answer1" value="<?php echo $row["answer_1"] ?? "" ?>">
                            <div class="form-error-text" id="error-answer1">Please enter answer</div>
                        </div>

                        <div class="question-input-box">
                            <label for="securityQuestion2">Security Question 2: </label>
                            <select name="securityQuestion2" id="securityQuestion2">
                                <option value="">-- Please Select --</option>
                                <option value="What is your secondary school name?">What is your secondary school name?</option>
                                <option value="What is your mother's middle name?">What is your mother's middle name?</option>
                                <option value="What is your favorite color?">What is your favorite color?</option>
                                <option value="What is your first car brand?">What is your first car brand?</option>
                                <option value="What is the city name were you born in?">What is the city name were you born in?</option>
                            </select>
                            <div class="form-error-text" id="error-question2">Please select question</div>
                        </div>

                        <div class="question-input-box">
                            <label for="answer2">Answer for Question 2: </label>
                            <input type="text" name="answer2" id="answer2" value="<?php echo $row["answer_2"] ?? "" ?>">
                            <div class="form-error-text" id="error-answer2">Please enter answer</div>
                        </div>

                        <button class="update-security-btn" id="btnUpdateQuestion">
                            <i class="fa-solid fa-key"></i>
                            <p>Update</p>
                        </button>
                    </form>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const userQ1 = "<?php echo $row["safety_question_1"]; ?>"; 
                            const userQ2 = "<?php echo $row["safety_question_2"]; ?>"; 
                            
                            const selectQ1 = document.getElementById("securityQuestion1");
                            const selectQ2 = document.getElementById("securityQuestion2");

                            if (userQ1) {
                                selectQ1.value = userQ1;
                            }

                            if (userQ2) {
                                selectQ2.value = userQ2;
                            }
                        });
                    </script>
                </div>
            </div>
        </main>
        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
        <script src="../../scripts/validation_securitySettings.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>