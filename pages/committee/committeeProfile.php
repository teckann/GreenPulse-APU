<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

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
        $courseEmail = $row["course_name"];
        $registrationDate = $row["registration_date"];
        $role = $row["role"];
        $accountStatus = $row["account_status"];
        $todayTimeStamp = time();
        $age = date("Y", $todayTimeStamp) - date("Y", $DOCTimeStamp);
        $photo = $row["avatar"];

        $statusColor = "";
        if ($accountStatus == "Active") {
            $statusColor = "green";
        }
        else {
            $statusColor = "#dc3545";
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

    <div class="profileUpper">
        <h1 class="profileText"><?php echo $userName ?>'s Profile</h1>
        <p>View and manage your profile data here</p>
    </div>
    <hr>
    <div class="profileMiddle">
        <div class="photosPart">
            <img src="../../<?php echo $photo ?>" alt="profile photo">
            <button class="btnChangeProfilePhoto" name="btnChangeProfilePhoto"><i class="fa-solid fa-camera"></i></button>
        </div>
        <div class="profileName">
            <b><?php echo $userName ?></php></b>
            <b><?php echo $userID ?></b>
        </div>
        <div class="profileStatus" style="background-color: <?php echo $statusColor ?>">
                <p><?php echo $accountStatus ?></p>
        </div>
    </div>
    <div class="profileBottom">
        <div class="info">
            <div class="personalData">
                <div><p>Role</p></div>
                <div><p>: <?php echo $role ?></p></div>
            </div>
            <div class="personalData">
                <div><p>Gender</p></div>
                <div><p>: <?php echo $gender ?></p></div>
            </div>
            <div class="personalData">
                <div><p>Date of Birth</p></div>
                <div><p>: <?php echo $DOB ?></p></div>
            </div>
            <div class="personalData">
                <div><p>Age<p></div>
                <div><p>: <?php echo $age ?> years old</p></div>
            </div>
            <div class="personalData">
                <div><p>Nationality<p></div>
                <div><p>: <?php echo $nationality ?></p></div>
            </div>
            <div class="personalData">
                <div><p>Contact Number<p></div>
                <div><p>: <?php echo $contactNumber ?></p></div>
            </div>
            <div class="personalData">
                <div><p>Education Email<p></div>
                <div><p>: <?php echo $email ?></p></div>
            </div>
            <div class="personalData">
                <div><p>Registration Date<p></div>
                <div><p>: <?php echo $registrationDate ?></p></div>
            </div>
        </div>
        <div class="editProfileButtonPart">
            <button class="btnEditProfile">Edit</button>
        </div>
    </div>

    <div class="popUpOverlay"></div>

    <div class="showChangePhotoPopUp">
        <div>
            <button id="changeCurrentPhotoBtn" class="photoRelatedBtn"><i class="fa-solid fa-pen-to-square"></i></button>
            <label>Change Photo</label>
        </div>
        <div>
            <button id="deleteCurrentPhotoBtn" class="photoRelatedBtn"><i class="fa-solid fa-trash"></i></button>
            <label>Delete Photo</label>
        </div>
    </div>
</body>
</html>