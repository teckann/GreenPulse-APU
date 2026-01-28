<?php
    include("../../conn.php");
    session_start();

    if (isset($_SESSION["safetyQuestion1"])) {
        ?> 
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const safetyQuestion1 = document.querySelector("#safetyQuestion1");
                    const safetyQuestion2 = document.querySelector("#safetyQuestion2");

                    safetyQuestion1.innerText = <?php echo json_encode($_SESSION["safetyQuestion1"]) ?>;
                    safetyQuestion2.innerText = <?php echo json_encode($_SESSION["safetyQuestion2"]) ?>;
                })
            </script>
        <?php
    }
    
    if (isset($_POST["btnVerifySafetyQuestion"])) {
        
        $inputAnswer1 = trim($_POST["safetyQuestion1Input"]);
        $inputAnswer2 = trim($_POST["safetyQuestion2Input"]);

        $_SESSION["answerInput1"] = $inputAnswer1;
        $_SESSION["answerInput2"] = $inputAnswer2;

        

        if (empty($inputAnswer1) || empty($inputAnswer2)) {
            $errorMessage = "All the answer field is required to fill in.";
        }
        else {
            if (($inputAnswer1 == $_SESSION["answer1"]) && ($inputAnswer2 == $_SESSION["answer2"])) {
                header("Location: forgetPasswordPage3.php");
                exit;
            }
            else {
                $errorMessage = "The answer is incorrect, please try again.";
            }
        }

        ?>
            <script>
                alert(<?php echo json_encode($errorMessage) ?>);
                window.location.href = "forgetPasswordPage2.php";
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
            <div><button id='btnBackToLogInPage' class='btnExitPage'><a href="forgetPasswordPage1.php"><i class="fa-solid fa-arrow-left" style="color: #fff;"></i></a></button></div>
        </div>
        <div class="userForgotPasswordHeader">
            <h1>Forget Password</h1>
            <div class="forgetPasswordTitlePart"><i class="fa-solid fa-lock" style="color: #194a7a"></i><h3 class="forgetPasswordTitle">Safety Question Verification</h3></div>
        </div>
        <form action="#" method="POST" class="forgetPasswordForm">
            <div class="SafetyQuestion1Part forgetPasswordPart">
                <h4 class="safetyQuestion1Lbl">Safety Question 1</h4>
                <label for="" id="safetyQuestion1">Question Question</label>
                <div class="safetyQuestion1Part">
                    <input type="text" name="safetyQuestion1Input" id="safetyQuestion1Input" class="safetyQuestions">
                </div>
            </div>
            <div class="SafetyQuestion2Part forgetPasswordPart">
                <h4 class="safetyQuestion2Lbl">Safety Question 2</h4>
                <label for="" id="safetyQuestion2">Question Question</label>
                <div class="safetyQuestion2Part">
                    <input type="text" name="safetyQuestion2Input" id="safetyQuestion2Input" class="safetyQuestions">
                </div>
            </div>
            <div class="btnVerifyIds">
                <button id="btnVerifySafetyQuestion" type="submit" name="btnVerifySafetyQuestion" value="Submit">Verify</button>
            </div>
        </form>
    </main>


</body>
</html>