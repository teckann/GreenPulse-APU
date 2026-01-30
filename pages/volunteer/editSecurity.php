<?php

    include("../../conn.php");

    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];

$errorMessage = ""; 

$sql_security_data = "SELECT password, safety_question_1, safety_question_2 
                       FROM users WHERE user_id = '$userID'";


$securityData = mysqli_fetch_assoc(mysqli_query($conn, $sql_security_data));


if (isset($_POST["savePasswordChange"])) {

    $oldPass = $_POST["oldPassword"];
    $newPass = $_POST["newPassword"];
    $confirmPass = $_POST["confirmNewPassword"];

    if (!password_verify($oldPass, $securityData['password'])) {
        $errorMessage = "Incorrect Old Password.";
        $_POST["changingPassword"] = true;

    }else {
        $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);
        $sql_update_new_pass = "UPDATE users SET password = '$hashedNewPass' 
                                 WHERE user_id = '$userID'";
        

        if (mysqli_query($conn, $sql_update_new_pass)) {
            header('Location: security.php');
        }else {
            echo "Error: " . $sql_update_new_pass . "<br>" . mysqli_error($conn);
        }
    }

}

if (isset($_POST["saveQuestionChange"])) {
    $q1 = mysqli_real_escape_string($conn, $_POST["securityQuestion1"]);
    $a1 = mysqli_real_escape_string($conn, $_POST["safeAnswer1"]);
    $q2 = mysqli_real_escape_string($conn, $_POST["securityQuestion2"]);
    $a2 = mysqli_real_escape_string($conn, $_POST["safeAnswer2"]);

    $sql_update_safety_question = "UPDATE users SET 
                                    safety_question_1 = '$q1', answer_1 = '$a1',
                                    safety_question_2 = '$q2', answer_2 = '$a2'
                                    WHERE user_id = '$userID'";
    
    if (mysqli_query($conn, $sql_update_safety_question)) {

        header('Location: security.php');
        
    } else {
        echo "Error: " . $sql_update_safety_question . "<br>" . mysqli_error($conn);
    }
}

$safetyQuestion = [
    "What is your secondary school name?",
    "What is your mother's middle name?",
    "What is your favorite color?",
    "What is your first car brand?",
    "What is the city name were you born in?"
];


function generateOptions($list, $oldQuestion) {
    $toPrint = '';
    foreach ($list as $q) {
        if($q === $oldQuestion){
            $selected = 'selected';
        }else{
            $selected = '';
        }
        
        $toPrint .= '<option value="'.$q.'" '.$selected.'>'.$q.'</option>';
    }
    return $toPrint;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">


    <title>Edit Security</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <script src="../../scripts/volunteer_security.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <?php include("header.php") ?>

    <div class="profileHead">
        <div>
            <a href="security.php" class="backEvent">
                <i class="fa-solid fa-arrow-left"></i>
            </a> 
            <span class="securityPageTitle">Change Password</span>
        </div>
    </div>


    <div class="securityContainer">
        <?php 
        
        if (isset($_POST["changingPassword"]) || isset($_POST["savePasswordChange"])){ ?>
            
            <form action="" method="post">
                <div class="oneSecuritySection">
                    <h2 class="securitySectionTitle">Old Password</h2>
                    <div class="securityLine">
                        <div class="oneSecurityInput">
                            <input type="password" name="oldPassword" required>
                            
                        </div>
                        
                    </div>
                    
                    <span class="errorMessage" id="emOldPass"><?php echo $errorMessage ?></span>
                </div>

                <div class="oneSecuritySection">
                    <h2 class="securitySectionTitle">New Password</h2>
                    <div class="securityLine">
                        <div class="oneSecurityInput">
                            <input type="password" id="newPassInput" name="newPassword" required>
                            
                        </div>
                        
                    </div>
                    <span class="errorMessage" id="emNewPass"></span>
                </div>

                <div class="oneSecuritySection">
                    <h2 class="securitySectionTitle">Confirm New Password</h2>
                    <div class="securityLine">
                        <div class="oneSecurityInput">
                            <input id="conPassInput" type="password" name="confirmNewPassword" required>
                            
                        </div>
                        
                    </div>
                    <span class="errorMessage" id="emConPass"></span>
                </div>

                <div class="deleteSection">
                    <button id="changePassBtn" type="submit" disabled name="savePasswordChange" value="haha" class="editSecurityBtn">Save The Change</button>
                    
                </div>
            </form>
        <?php
        }elseif (isset($_POST["changingSafetyQuestion"]) || isset($_POST["saveQuestionChange"])){ ?>

            <form action="" method="post">
                
                <div class="oneSecuritySection">
                    <h2 class="securitySectionTitle">Question 1</h2>
                    <div class="securityLine">
                        <div class="oneSecurityInput">
                            <select required name="securityQuestion1" id="q1">
                                <?php echo generateOptions($safetyQuestion, $securityData['safety_question_1']); ?>
                            </select>
                            
                        </div>
                        
                    </div>
                    <span class="errorMessage" id="emQ1"></span>
                </div>

                <div class="oneSecuritySection">
                    <h2 class="securitySectionTitle">Answer 1</h2>
                    <div class="securityLine">
                        <div class="oneSecurityInput">
                            <input required autocomplete="off" type="text" name="safeAnswer1" value="" placeholder="Enter new answer">
                        </div>
                        
                    </div>
                    <span class="errorMessage" id="emA1"></span>
                </div>

                <br><br>

                <div class="oneSecuritySection">
                    <h2 class="securitySectionTitle">Question 2</h2>
                    <div class="securityLine">
                        <div class="oneSecurityInput">
                            <select required name="securityQuestion2" id="q2">
                                <?php echo generateOptions($safetyQuestion, $securityData['safety_question_2']); ?>
                            </select>
                        </div>
                        
                    </div>
                    <span class="errorMessage" id="emQ2"></span>
                </div>

                <div class="oneSecuritySection">
                    <h2 class="securitySectionTitle">Answer 2</h2>
                    <div class="securityLine">
                        <div class="oneSecurityInput">
                            <input required autocomplete="off" type="text" name="safeAnswer2" value="" placeholder="Enter new answer">
                        </div>
                        
                    </div>
                    <span class="errorMessage" id="emA2"></span>
                </div>

                <div class="deleteSection">
                    <button disabled id="changeQuestionBtn" type="submit" name="saveQuestionChange" value="haha" class="editSecurityBtn">Save The Change</button>
                    
                </div>
            </form>


        <?php } ?>



    </div>
</body>
</html>