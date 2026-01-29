<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    if (!empty($_SESSION["hasData"])) {
        $nameError = $_SESSION["errorStatus"]["nameError"];
        $phoneNumberError = $_SESSION["errorStatus"]["phoneNumberError"];
        $courseError = $_SESSION["errorStatus"]["courseError"];
        $nationalityError = $_SESSION["errorStatus"]["nationalityError"];

        $nameInput = $_SESSION["dataInput"]["nameInput"];
        $phoneNumberInput = $_SESSION["dataInput"]["phoneNumberInput"];
        $courseInput = $_SESSION["dataInput"]["courseInput"];
        $nationalityInput = $_SESSION["dataInput"]["nationalityInput"];

        unset($_SESSION["errorStatus"]);
        unset($_SESSION["dataInput"]);
        unset($_SESSION["hasData"]);

        ?>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    // error detector
                    const nameError = <?php echo json_encode($nameError); ?>;
                    const phoneNumberError = <?php echo json_encode($phoneNumberError); ?>;
                    const courseError = <?php echo json_encode($courseError); ?>;
                    const nationalityError = <?php echo json_encode($nationalityError); ?>;
                    
                    // data input
                    const nameInput = <?php echo json_encode($nameInput); ?>;
                    const phoneNumberInput = <?php echo json_encode($phoneNumberInput); ?>;
                    const courseInput = <?php echo json_encode($courseInput); ?>;
                    const nationalityInput = <?php echo json_encode($nationalityInput); ?>;

                    console.log(nameInput);
                    console.log(phoneNumberInput);
                    console.log(courseInput);
                    console.log(nationalityInput);

                    // const 
                    const nameFind = document.querySelector("#editProfileName");
                    const phoneNumberFind = document.querySelector("#editProfileContactNumber");
                    const courseFind = document.querySelector("#course");
                    const nationalityFind = document.querySelector("#nationality");

                    // find hint text for each error
                    const hintName = document.querySelector(".nameError");
                    const hintPhoneNumber = document.querySelector(".phoneNumberError");
                    const hintCourse = document.querySelector(".courseError");
                    const hintNationality = document.querySelector(".nationalityError");

                    nameFind.value = nameInput;
                    phoneNumberFind.value = phoneNumberInput;
                    courseFind.value = courseInput;
                    nationalityFind.value = nationalityInput;

                    if (nameError) {
                        hintName.style.display = "block";
                    }
                    if (phoneNumberError) {
                        hintPhoneNumber.style.display = "block";
                    }
                    if (courseError) {
                        hintCourse.style.display = "block";
                    }
                    if (nationalityError) {
                        hintNationality.style.display = "block";
                    }
                })
            </script>
        <?php
    }
    else {
        $sql = "SELECT * FROM users WHERE user_id = '$userID'";

        $result = mysqli_query($conn, $sql);
        
        if ($row = mysqli_fetch_assoc($result)) {
            $nationality = $row["nationality"];
            $gender = "";
            if ($row["gender"] == "M") {
                $gender = "Male";
            }
            else {
                $gender = "Female";
            }

            $DOCTimeStamp = strtotime($row["date_of_birth"]);
            $DOB = date("d-m-Y", $DOCTimeStamp);
            $contactNumber = $row["contact_number"];
            $email = $row["education_email"];
            $registrationDate = $row["registration_date"];
            $role = $row["role"];
            $accountStatus = $row["account_status"];
            $courseName = $row["course_name"];
            $todayTimeStamp = time();
            $age = date("Y", $todayTimeStamp) - date("Y", $DOCTimeStamp);

            ?>
            <script>
                const courseValue = <?php echo json_encode($courseName); ?>;
                const nationalityValue = <?php echo json_encode($nationality); ?>;
            </script>
        <script src="../../scripts/committeeEditProfile.js"></script></script>
            <?php
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee Profile</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include("header.php") ?>

    <div class="editProfileUpper">
        <div><button id='btnBackToProfile'><a href="committeeProfile.php"><i class="fa-solid fa-arrow-left"></a></i></button></div>
        <div class="editProfileTextContainer"><h1 id="editPorfileDataText">Edit Profile</h2></div>
    </div>
    <div class="editProfileDescription"><p>This page displays only information that can be edited, all other data cannot be modified.</p></div>
    <div class="editProfileBottom">
        <form action="committeeEditProfileValidation.php" method="POST">
            <div class="editContainer">
                <div class="editInput">
                    <label for="editProfileName">
                        Name:
                    </label>
                    <input type="text" id="editProfileName" name="editProfileName" value="<?php echo $userName ?>" required>
                    <small class="errorMessages nameError">The name must contain only alphabet</small>
                </div>
                <div class="editInput">
                    <label for="editProfileContactNumber">
                        Contact Number<br>
                        <small>format: 0123456789</small>
                    </label>
                    <input type="tel" id="editProfileContactNumber" name="editProfilePhoneNumber" value="<?php echo $contactNumber ?>" required>
                    <small class="errorMessages phoneNumberError">The phone number must contain only 10 - 11 numeric number</small>
                </div>
                <div class="editInput">
                    <label for="course">
                        Course Name
                    </label>
                    <?php include("../general/course.php"); ?>
                    <small class="errorMessages courseError">Must select ONE course</small>
                </div>
                <div class="editInput">
                    <label for="editProfileName">
                        Nationality:
                    </label>
                    <?php include("../general/nationality.php"); ?>
                    <small class="errorMessages nationalityError">Must select ONE nationality</small>
                </div>
                <div class="confirmEditProfileBtn">
                    <button id="btnConfirmEditProfile" name="btnConfirmEditProfile">Confirm</button>            
                </div>
            </div>
        </form>
    </div>
    <?php include ("hamburgerMenu.php");?>
</body>
</html>