<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    if (isset($_POST["btnDeleteProfilePhoto"])) {
        $sqlDeletePhoto = "UPDATE users SET avatar = 'src/avatars/default.png' WHERE user_id = '$userID'";

        if (mysqli_query($conn, $sqlDeletePhoto)) {
            addLog($conn, $userID, "Delete Profile Photo");
            
            ?>

            <script>
                alert('Profile photo delete successfully!');
                window.location.href = "committeeProfile.php";
            </script>

            <?php
        }
        else {
            ?>
                <script>
                    alert('Profile is not delete successfully, please try again.');
                    window.location.href = "committeeProfile.php";
                </script>
            <?php
        }
    }

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
        $todayTimeStamp = time();
        $age = date("Y", $todayTimeStamp) - date("Y", $DOCTimeStamp);
        $photo = $row["avatar"];
        $courseName = $row["course_name"];

        $statusColor = "";
        if ($accountStatus == "Active") {
            $statusColor = "green";
        }
        else {
            $statusColor = "#dc3545";
        }

        if ($photo == 'src/avatars/default.png') {
            ?>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const btnDeletePhotoText = document.querySelector("#deleteCurrentPhotoBtnText");
                        const btnDeletePhoto = document.querySelector("#deleteCurrentPhotoBtn");
                        // btnDeletePhoto.style.color = "red";
                        btnDeletePhoto.classList.add("disableButton");
                        btnDeletePhotoText.style.color = "gray";
                        btnDeletePhotoText.style.opacity = "0.5";
                    })
                </script>
            <?php
        }
    }

    $changeProfilePhotoPopUp = false;
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
            <button class="btnChangeProfilePhoto" name="btnChangeProfilePhoto" id="btnChangeProfilePhoto"><i class="fa-solid fa-camera"></i></button>
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
                <div><p>: <?php echo ucwords($role) ?></p></div>
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
                <div><p>Course Name<p></div>
                <div><p>: <?php echo $courseName ?></p></div>
            </div>
            </div>
        </div>
        <div class="editProfileButtonPart">
            <button class="btnEditProfile"><a href="editProfile.php">Edit</a></button>
        </div>
    </div>

    <div class="profileOverlay"></div>

    <div class="showChangePhotoPopUp">
        <div>
            <button id="changeCurrentPhotoBtn" class="photoRelatedBtn"><i class="fa-solid fa-pen-to-square"></i></button>
            <label>Change Photo</label>
        </div>
        <div>
            <button id="deleteCurrentPhotoBtn" class="photoRelatedBtn"><i class="fa-solid fa-trash"></i></button>
            <label id="deleteCurrentPhotoBtnText">Delete Photo</label>
        </div>
    </div>

    <div id="itemPopUp2">
        <div class="popUpHeader">
            <div><button id='btnBackEditChangeProfilePhoto' class='btnExitPopUps'><i class="fa-solid fa-arrow-left"></i></button></div>
            <div id="popUpHeaderText"><b id="changeProfilePhotoText">Current Profile Photo</b></div>
        </div>
            
        <form action="../../backend/committeeUpdateUserPhoto.php" method="POST" enctype="multipart/form-data" class='popUpForm'>
            <div class='popUpShow profilePhotoEditPage'>
                <img id="oldProfileImage" src="../../<?php echo $photo ?>" alt="Profile Image">
                
                <div class="fileUploadPart">
                    <span class="attachPhotoText"><b>Please attach photo here</b></span>
                    <span class="uploadFileText">Upload one supported files (e.g. png, jpg, jpeg), Each file up to 5 MB in size.</span>
                    <input type="file" name="updateFile" id="fileChangeProfilePhoto">
                </div>
                <button type="submit" name="btnConfirmChangeProfilePhoto" class="btnConfirmChangeProfilePhoto">Update Profile Photo</button>
                
            </div>
        </form>
    </div>

    
            
    <div id="itemPopUp3">
        <div class="popUpHeader">
            <div id="popUpHeaderText"><b id="deleteProfileText">Delete Profile Photo Page</b></div>
        </div>
        
        <form action="#" method="POST" class='popUpForm'>
            <div class='popUpShow deleteTreePage'>
                <div class="allDeleteInfo">
                    <div class="askForDelete">
                        <p>Do you want to delete your current profile photo?</p>
                        <p>Once delete, a default photo will give to you</p>
                    </div>
                </div>
                <div class="deletePhotoBtns">
                    <button type="button" name="btnExitDeletePopUp" class="btnExitDeletePopUp"><a href="committeeProfile.php">Cancel</a></button>
                    <button type="submit" name="btnDeleteProfilePhoto" class="btnDeleteTree">Delete Tree</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const changePhotoStatus = <?php echo json_encode($changeProfilePhotoPopUp); ?>;
    </script>
    <script src="../../scripts/committee_profile.js"></script>
</body>
</html>