<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    $sql = "SELECT * FROM users WHERE user_id = '$userID'";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);

    $gender = "";

    if ($row["gender"] === "M") {
        $gender = "Male";
    }
    else {
        $gender = "Female";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>My Profile</h1>
            <h2 class="page-subTitle">Manage your admin identity & credentials</h2>

            <div class="flex-container">
                <div class="profile-header">
                    <div class="profile-header-info">
                        <div class="avatar-container">
                            <img src="../../<?php echo $row["avatar"] ?>" alt="user_avatar" class="profile-avatar">
                            <button class="edit-avatar-icon">
                                <i class="fa-solid fa-camera"></i>
                            </button>
                        </div>

                        <div class="profile-header-details">
                            <h2><?php echo $row["name"] ?></h2>
                            <p><?php echo $row["user_id"] ?> | <?php echo ucwords($row["role"]) ?></p>
                        </div>
                    </div>

                    <div class="last-login">
                        <p style="text-align: right">Last Login: <?php echo $row["last_login"] ?></p>
                    </div>
                </div>

                <div class="overlay" id="popupOverlay"></div>

                <div class="popup" id="popup">
                    <div class="popup-header">
                        <div class="info-title">
                            <h3>Update Your Avatar</h3>
                            <div class="line"></div>
                        </div>
                        <button id="popup-close-menu" class="icon-menu">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- enctype very important to take the file value/path  -->
                    <form action="../../backend/update_avatar.php" method="POST" enctype="multipart/form-data">
                        <div class="update-avatar-container">
                            <img src="../../<?php echo $row["avatar"]; ?>" class="preview-avatar" id="preview-avatar" alt="Avatar Preview">

                            <label for="avatar_image" class="upload-file-btn">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <p>Choose Image</p>
                            </label>
                            <input type="file" id="avatar_image" name="avatar_image" class="uploadFile-btn" hidden>

                            <span id="file-name" class="file-name">No file choosen</span>
                        </div>

                        <div class="submit-container">
                            <button type="submit" name="btnUpdateAvatar" value="Submit" class="submit-btn">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <p>Save Changes</p>
                            </button>
                        </div>            
                    </form>
                </div>

                <div class="popup" id="popup-update-info">
                    <div class="popup-header">
                        <div class="info-title">
                            <h3>Update Personal Information</h3>
                            <div class="line"></div>
                        </div>
                        <button id="popup-update-info-close-menu" class="icon-menu">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <form action="../../backend/update_avatar.php" method="POST">
                        <div class="update-avatar-container">
                        </div>

                        <div class="submit-container">
                            <button type="submit" name="btnUpdateAvatar" value="Submit" class="submit-btn">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <p>Save Changes</p>
                            </button>
                        </div>            
                    </form>
                </div>

                <div class="profile-personal-info profile-desktop">
                    <div class="profile-info-header">
                        <h3>Personal Information</h3>
                        <button class="profile-update-btn updatePersonalInfo-btn">
                            <i class="fa-solid fa-pen"></i>
                            <p>Update</p>
                        </button>
                    </div>

                    <div class="profile-info-content">
                        <div class="profile-personal-content-container">
                            <div class="profile-personal-content-box">
                                <h3>Full Name</h3>
                                <p><?php echo $row["name"] ?></p>
                            </div>

                            <div class="profile-personal-content-box">
                                <h3>Education Email</h3>
                                <p><?php echo $row["education_email"] ?></p>
                            </div>
                        </div>

                        <div class="profile-personal-content-container">
                            <div class="profile-personal-content-box">
                                <h3>Gender</h3>
                                <p><?php echo $gender ?></p>
                            </div>

                            <div class="profile-personal-content-box">
                                <h3>Contact Number</h3>
                                <p><?php echo $row["contact_number"] ?></p>
                            </div>
                        </div>

                        <div class="profile-personal-content-container">
                            <div class="profile-personal-content-box">
                                <h3>Nationality</h3>
                                <p><?php echo $row["nationality"] ?></p>
                            </div>

                            <div class="profile-personal-content-box">
                                <h3>Course Enrolled</h3>
                                <p><?php echo $row["course_name"] ?></p>
                            </div>
                        </div>

                        <div class="profile-personal-content-container">
                            <div class="profile-personal-content-box">
                                <h3>Date of Birth</h3>
                                <p><?php echo reformat_date($row["date_of_birth"]) ?></p>
                            </div>

                            <div class="profile-personal-content-box">
                                <h3>User Role</h3>
                                <p><?php echo ucwords($row["role"]) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-personal-info profile-desktop">
                    <div class="profile-info-header">
                        <h3>Account Security Settings</h3>
                        <button class="profile-update-btn">
                            <i class="fa-solid fa-pen"></i>
                            <p>Update</p>
                        </button>
                    </div>

                    <div class="profile-info-content">
                        <div class="profile-personal-content-container">
                            <div class="profile-personal-content-box">
                                <h3>Password</h3>
                                <p class="no-copy-element">**************************</p>
                            </div>
                        </div>

                        <div class="profile-personal-content-container">
                            <div class="profile-personal-content-box">
                                <h3>Security Question 1</h3>
                                <p class="no-copy-element"><?php echo $row["safety_question_1"] ?? "N/A" ?></p>
                            </div>
                        </div>

                        <div class="profile-personal-content-container">
                            <div class="profile-personal-content-box">
                                <h3>Security Question 2</h3>
                                <p class="no-copy-element"><?php echo $row["safety_question_2"] ?? "N/A" ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cards profile-mobile">
                    <div class="card-header">
                        <div class="card-id">
                            <h3>Personal Information</h3>
                        </div>

                        <a href="updatePersonalInfo.php" style="text-decoration: none;">
                            <button class="profile-update-btn">
                                <i class="fa-solid fa-pen"></i>
                                <p>Update</p>
                            </button>
                        </a>
                    </div>

                    <div class="card-content">
                        <div class="card-data">
                            <p>Full Name</p>
                            <p><?php echo $row["name"] ?></p>
                        </div>

                        <div class="card-data">
                            <p>Gender</p>
                            <p><?php echo $gender ?></p>
                        </div>

                        <div class="card-data">
                            <p>Nationality</p>
                            <p><?php echo $row["nationality"] ?></p>
                        </div>

                        <div class="card-data">
                            <p>Date of Birth</p>
                            <p><?php echo reformat_date($row["date_of_birth"]) ?></p>
                        </div>

                        <div class="card-data">
                            <p>Education Email</p>
                            <p><?php echo $row["education_email"] ?></p>
                        </div>

                        <div class="card-data">
                            <p>Contact Number</p>
                            <p><?php echo $row["contact_number"] ?></p>
                        </div>

                        <div class="card-data">
                            <p>Course Enrolled</p>
                            <p><?php echo $row["course_name"] ?></p>
                        </div>

                        <div class="card-data">
                            <p>Role</p>
                            <p><?php echo ucwords($row["role"]) ?></p>
                        </div>
                    </div>
                </div>

                <div class="cards profile-mobile">
                    <div class="card-header">
                        <div class="card-id">
                            <h3>Account Security Settings</h3>
                        </div>

                        <button class="profile-update-btn">
                            <i class="fa-solid fa-pen"></i>
                            <p>Update</p>
                        </button>
                    </div>

                    <div class="card-content">
                        <div class="card-data">
                            <p>Password</p>
                            <p class="no-copy-element">**************************</p>
                        </div>

                        <div class="card-data">
                            <p>Security Question 1</p>
                            <p class="no-copy-element"><?php echo $row["safety_question_1"] ?? "N/A" ?></p>
                        </div>

                        <div class="card-data">
                            <p>Safety Question 2</p>
                            <p class="no-copy-element"><?php echo $row["safety_question_2"] ?? "N/A" ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
        <script src="../../scripts/admin_popup_updateAvatar.js"></script>
        <script src="../../scripts/admin_popup_updateProfile.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>