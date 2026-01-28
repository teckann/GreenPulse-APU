<?php
    include("../../conn.php");
    session_start();

    if (isset($_SESSION["userIdInput"])) {
        ?>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const userIdInput = document.querySelector("#identifyUserIdInput");
                userIdInput.value = <?php echo json_encode($_SESSION["userIdInput"]) ?>;
                });
            </script>
        <?php
    }
    
    if (isset($_POST["btnVerifyUserId"])) {

        $userId = trim(strtoupper($_POST["identifyUserIdInput"]));

        $_SESSION["userIdInput"] = $userId;

        $errorMessage = "";
        

        if (empty($userId)) {
            $errorMessage = "Please fill in the user ID";
        }
        else if (strlen($userId) !== 4) {
            $errorMessage = "User ID only have 4 characters";
        }
        else if (substr($userId, 0, 1) !== 'U' || !ctype_digit(substr($userId, 1))) {
            $errorMessage = "Please fill in right user ID format (e.g. U001).";
        }
        else {
            $sqlSearch = "SELECT * FROM users WHERE user_id = '$userId'";

            $result = mysqli_query($conn, $sqlSearch);

            if (mysqli_num_rows($result) > 0) {
                if ($row = mysqli_fetch_assoc($result)) {
                    $_SESSION["safetyQuestion1"] = $row["safety_question_1"];
                    $_SESSION["safetyQuestion2"] = $row["safety_question_2"];
                    $_SESSION["answer1"] = $row["answer_1"];
                    $_SESSION["answer2"] = $row["answer_2"];
                    $_SESSION["oldPassword"] = $row["password"];

                    if ($_SESSION["safetyQuestion1"] == null) {
                        $errorMessage = "You are not allowed to reset password as your safety question have not set yet, please inform admin.";
                    }
                    else {
                        header("Location: forgetPasswordPage2.php");
                        exit;
                    }
                }
            }
            else {
                $errorMessage = "Your user ID is not found.";
            }
        }

        ?>
            <script>
                alert(<?php echo json_encode($errorMessage) ?>);
                window.location.href = "forgetPasswordPage1.php";
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
            <div><button id='btnBackToLogInPage' class='btnExitPage'><a href="login.php"><i class="fa-solid fa-arrow-left" style="color: #fff;"></i></a></button></div>
        </div>
        <div class="userForgotPasswordHeader">
            <h1>Forget Password</h1>
            <div class="forgetPasswordTitlePart"><i class="fa-solid fa-clipboard-check" style="color: #194a7a"></i><h3 class="forgetPasswordTitle">User ID Verify</h3></div>
        </div>
        <form action="#" method="POST" class="forgetPasswordForm">
            <div class="identifyUserIdPart">
                <h4 class="forgetPasswordUserId">User ID</h4>
                <div class="identifyUserIdInputPart">
                    <input type="text" name="identifyUserIdInput" id="identifyUserIdInput" placeholder="e.g. U001" value="">
                </div>
            </div>
            <div class="btnVerifyIds">
                <button id="btnVerifyUserId" type="submit" name="btnVerifyUserId" value="Submit">Continue</button>
            </div>
        </form>
    </main>


</body>
</html>