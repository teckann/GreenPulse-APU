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
        $age = (date("Y-m-d"));
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
            <div class="profileStatus" style="background-color: <?php echo $statusColor ?>"><p><?php echo $accountStatus ?></p></div>
        <div>

        </div>
    </div>
</body>
</html>