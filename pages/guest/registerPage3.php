<?php
    include("../../conn.php");
    include("../../backend/utility.php");

    session_start();

    if(isset($_SESSION["password1"])) {
        ?>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const passwordInput1 = document.querySelector("#registerPassword1");
                    const passwordInput2 = document.querySelector("#registerPassword2");

                    passwordInput1.value = <?php echo json_encode($_SESSION["password1"]); ?>;
                    passwordInput2.value = <?php echo json_encode($_SESSION["password2"]); ?>;
                })
            </script>
        <?php
    }

    if (isset($_POST["btnSubmitPassword"])) {
        
        $newPassword1 = trim($_POST["registerPassword1"]);
        $newPassword2 = trim($_POST["registerPassword2"]);

        $_SESSION["password1"] = $newPassword1;
        $_SESSION["password2"] = $newPassword2;
        
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

            $_SESSION["hash_password"] = password_hash($newPassword1, PASSWORD_DEFAULT);

            $newId = newID($conn, "users", "U");

            $_SESSION["newUserID"] = $newId;

            $date = date('Y-m-d');
            
            $sqlCreateAccount = "INSERT INTO users (`user_id`, `name`, `nationality`, `gender`, `date_of_birth`, `contact_number`, `education_email`, `course_name`, `registration_date`, `password`,
            `avatar`, `role`) VALUES ('{$newId}', '{$_SESSION['name']}', '{$_SESSION['nationality']}', '{$_SESSION['gender']}', '{$_SESSION['DOB']}', '{$_SESSION['contactNumber']}',
            '{$_SESSION['email']}', '{$_SESSION['course']}', '{$date}', '{$_SESSION['hash_password']}', 'src/avatars/default.png', 'volunteer');";

            if (mysqli_query($conn, $sqlCreateAccount)) {
                header("Location: registerSuccessfully.php");
                exit;
            }
            else {
                ?>
                    <script>
                        alert('Account register failed, please rey again.')
                    </script>
                <?php
            }
        }

        ?>
            <script>
                alert(<?php echo json_encode($errorMessage) ?>);
                window.location.href = "registerPage3.php";
            </script>
        <?php
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Password</title>
    <link rel="stylesheet" href="../../styles/guest.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include("header.php") ?>

    <main class="register">
        <div class="backButtonPart">
            <div><button id='btnBackToRegisterPage2' class='btnExitPage'><a href="registerPage2.php"><i class="fa-solid fa-arrow-left" style="color: #fff;"></i></a></button></div>
        </div>
        <div class="userRegisterHeader">
            <h1>User Registration</h1>
            <div class="registerTitlePart"><i class="fa-solid fa-circle-info" style="color: #194a7a"></i><h3 class="registerTitle">Password Setting Page</h3></div>
        </div>
        <form action="#" method="POST" class="registerPassword">
            <div class="registerPasswordInput">
                <small>Password must be at least <b>8 charcters long</b> and include at least <b>one  Capital and Small letter</b>,<b> one number,</b> and <b>one character</b></small>
            </div>
            <div class="registerPasswordInput">
                <label for="registerPassword1">Password</label>
                <input type="password" name="registerPassword1" id="registerPassword1">
            </div>
            <div class="registerPasswordInput">
                <label for="registerPassword2">Confirm Password</label>
                <input type="password" name="registerPassword2" id="registerPassword2">
            </div>
            <div class="btnSubmitPasswords">
                <button id="btnSubmitPassword" name="btnSubmitPassword">Confirm </button>
            </div>
        </form>
    </main>


</body>
</html>