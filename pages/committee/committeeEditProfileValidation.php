<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");
    
    if (isset($_POST["btnConfirmEditProfile"])) {
        $name = trim($_POST["editProfileName"]);
        $phoneNumber = trim($_POST["editProfilePhoneNumber"]);
        $course = trim($_POST["courseName"]);
        $nationality = trim($_POST["nationality"]);

        $nameError = false;
        $phoneNumberError = false;
        $courseError = false;
        $nationalityError = false;

        if(empty($name)) {
            $nameError = true;
            $name = "";
        } else if(preg_match('~[0-9]~',$name)) {
            $nameError = true;
        }

        if (empty($phoneNumber)) {
            $phoneNumberError = true;
            $phoneNumber = "";
        } else if (!is_numeric($phoneNumber) || !((strlen($phoneNumber) == 10) || (strlen($phoneNumber) == 11))) {
            $phoneNumberError = true;
        }
        if (empty($course)) {
            $courseError = true;
            $course = "";
        }

        if (empty($nationality)) {
            $nationalityError = true;
            $nationality = "";
        }

        if ($nameError || $phoneNumberError || $courseError || $nationalityError) {
            // $_SESSION["nameError"] = $nameError;
            // $_SESSION["phoneNumberError"] = $phoneNumberError;
            // $_SESSION["courseError"] = $courseError;
            // $_SESSION["nationalityError"] = $nationalityError;

            // use array to store the session
            $_SESSION["errorStatus"] = [
                "nameError" => $nameError,
                "phoneNumberError" => $phoneNumberError,
                "courseError" => $courseError,
                "nationalityError" => $nationalityError
            ];

            // old data that may apply
            // $_SESSION["nameInput"] = $name;
            // $_SESSION["phoneNumberInput"] = $phoneNumber;
            // $_SESSION["courseInput"] = $course;
            // $_SESSION["nationalityInput"] = $nationality;

            $_SESSION["dataInput"] = [
                "nameInput" => $name,
                "phoneNumberInput" => $phoneNumber,
                "courseInput" => $course,
                "nationalityInput" => $nationality
            ];

            // set the session to let the edit php check overwrite data or not
            $_SESSION["hasData"] = true;

            ?>
            <script>
                window.location.href = "editProfile.php";
            </script>
            <?php
        }
        else {
            $sqlChangeProfileData = "UPDATE users SET name = '$name', contact_number = '$phoneNumber',
            course_name = '$course', nationality = '$nationality' WHERE user_id = '$userID'";

            if (mysqli_query($conn, $sqlChangeProfileData)) {

                addLog($conn, $userID, "Update Profile Information ($userID)");

                $_SESSION["userName"] = $name;
                ?>
                    <script>
                        alert('Profile Update Successfully');
                        window.location.href = "committeeProfile.php";
                    </script>
                <?php
            }
        }
    }
?>

