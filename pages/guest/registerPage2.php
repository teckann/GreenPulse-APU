<?php
    include("../../conn.php");
    session_start();

    if(isset($_SESSION["name"])) {
        ?>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const nameInput = document.querySelector("#registerName");
                    const DOBInput = document.querySelector("#registerDOB");
                    const genderInput = document.querySelector("#registerGender");
                    const courseInput = document.querySelector("#course");
                    const nationalityInput = document.querySelector("#nationality");
                    const contactNumberInput = document.querySelector("#contactNumber");

                    nameInput.value = <?php echo json_encode($_SESSION["name"]); ?>;
                    DOBInput.value = <?php echo json_encode($_SESSION["DOB"]); ?>;
                    genderInput.value = <?php echo json_encode($_SESSION["gender"]); ?>;
                    courseInput.value = <?php echo json_encode($_SESSION["course"]); ?>;
                    nationalityInput.value = <?php echo json_encode($_SESSION["nationality"]); ?>;
                    contactNumberInput.value = <?php echo json_encode($_SESSION["contactNumber"]); ?>;
                })
            </script>
        <?php
    }

    if (isset($_POST["btnSubmitInformation"])) {
        $name = trim($_POST["registerName"]);
        $DOB = $_POST["registerDOB"];
        $gender = $_POST["registerGender"];
        $course = $_POST["courseName"];
        $nationality = $_POST["nationality"];
        $contactNumber = trim($_POST["contactNumber"]);

        $_SESSION["name"] = $name;
        $_SESSION["DOB"] = $DOB;
        $_SESSION["gender"] = $gender;
        $_SESSION["course"] = $course;
        $_SESSION["nationality"] = $nationality;
        $_SESSION["contactNumber"] = $contactNumber;

        if (empty($name) ||empty($gender) || empty($course) || empty($nationality)) {
            $errorMessage = "All data is required to be selected.";
        }
        else if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
            $errorMessage = "The name should only contain alpheberts.";
        }
        else if (!ctype_digit($contactNumber) || !((10 == strlen($contactNumber)) || (strlen($contactNumber) == 11))) {
            $errorMessage = "The contact number should only contain 10 or 11 digits.";
        }
        else {

            header("Location: registerPage3.php");
            exit;
        }

        ?>
            <script>
                alert(<?php echo json_encode($errorMessage) ?>);
                window.location.href = "registerPage2.php";
            </script>
        <?php

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Information</title>
    <link rel="stylesheet" href="../../styles/guest.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include("header.php") ?>

    <main class="register">
        <div class="backButtonPart">
            <div><button id='btnBackToRegisterPage1' class='btnExitPage'><a href="registerPage1.php"><i class="fa-solid fa-arrow-left" style="color: #fff;"></i></a></button></div>
        </div>
        <div class="userRegisterHeader">
            <h1>User Registration</h1>
            <div class="registerTitlePart"><i class="fa-solid fa-circle-info" style="color: #194a7a"></i><h3 class="registerTitle">Information Collection Page</h3></div>
        </div>
        <form action="#" method="POST" class="registerInformationForm">
            <div class="registerInformationInput">
                <label for="registerName">Name</label>
                <input type="text" name="registerName" id="registerName" required placeholder="Enter Name">
            </div>
            <div class="registerInformationInput">
                <label for="registerDOB">Date Of Birth</label>
                <input type="date" name="registerDOB" id="registerDOB" required id="registerDOB">
            </div>
            <div class="registerInformationInput">
                <label for="registerGender">Gender</label>
                <select name="registerGender" id="registerGender">
                    <option value="">--Please Select--</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
            <div class="registerInformationInput">
                <label for="course">Course Name</label>
                <?php include("../general/course.php"); ?>
            </div>
            <div class="registerInformationInput">
                <label for="nationality">Nationality</label>
                <?php include("../general/nationality.php"); ?>
            </div>
            <div class="registerInformationInput">
                <label for="contactNumber">Contact Number</label>
                <input type="text" name="contactNumber" required id="contactNumber" placeholder="0123456789">
            </div>
            <div class="btnSubmitInformations">
                <button id="btnSubmitInformation" name="btnSubmitInformation">Next Page</button>
            </div>
        </form>
    </main>


</body>
</html>