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

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if ($_POST["formType"] === "addNewUser") {
            $name = trim($_POST["name"]);
            $emailID = trim($_POST["emailID"]);
            $contactNumber = trim($_POST["contactNumber"]);
            $dateOfBirth = $_POST["dateOfBirth"];
            $courseName = $_POST["courseName"];
            $nationality = $_POST["nationality"];

            $email = strtoupper($emailID) . "@mail.apu.edu.my";

            $sql_updateInfo = "UPDATE users SET
                               name = '$name', education_email = '$email',
                               contact_number = '$contactNumber', date_of_birth = '$dateOfBirth',
                               course_name = '$courseName', nationality = '$nationality'
                               WHERE user_id = '$userID'";

            if(mysqli_query($conn, $sql_updateInfo)) {
                // record action into log
                // addLog($conn, $userID, "Update Profile Information ($userID)");
                echo "<script>
                        alert('--- Successfully Updated Personal Infomation ---\\nAlways keep your profile details up to date.');
                        window.location.href = 'profile.php';
                      </script>";
            }
        }

        // this is create by js, admin_promptPassword.js
        elseif ($_POST["formType"] === "checkPassword") {
            $inputPassword = trim($_POST["inputPassword"]);

            if (password_verify($inputPassword, $row["password"])) {
                $_SESSION["valid_updateSecurityQuestion"] = "Valid";
                header("Location: updateSecuritySettings.php?");
            }
            else {
                echo "<script>
                        alert('Incorrect Password');
                        window.location.href = 'profile.php';
                      </script>";
            }
        }
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

                    <form action="" method="POST" class="popup-form">
                        <!-- used to know what form submited  -->
                        <input type="hidden" name="formType" value="addNewUser">
                        <div class="popup-scroll-area">
                            <div class="popup-input">
                                <label for="fullname">Full Name *</label>
                                <input type="text" name="name" id="fullname" value="<?php echo $row["name"] ?>">
                                <div class="popup-error-text" id="error-fullname">Enter a Valid Name</div>
                            </div>

                            <div class="popup-input">
                                <label for="email">Education Email *</label>
                                <div style = "display: flex; flex-direction: row; align-items: center; gap:5px;">
                                    <input type="text" name="emailID" id="email" value="<?php echo explode('@', $row["education_email"])[0]; ?>">
                                    <label for="email">@mail.apu.edu.my</label>
                                </div>
                                <div class="popup-error-text" id="error-email">Enter a Valid APU Education Email</div>
                            </div>

                            <div class="popup-row">
                                <div class="popup-input popup-contact">
                                    <label for="contactNumber">Contact Number *</label>
                                    <div class="popup-sub-input">
                                        <label for="contact">+60 </label>
                                        <input type="text" name="contactNumber" id="contact" value="<?php echo $row["contact_number"] ?>">
                                    </div>
                                    <div class="popup-error-text" id="error-contactNumber">Enter a Valid Contact Number</div>
                                </div>

                                <div class="popup-input popup-dob">
                                    <label for="dob">DOB *</label>
                                    <input type="date" name="dateOfBirth" id="dob" value="<?php echo $row['date_of_birth']; ?>">
                                    <div class="popup-error-text" id="error-dob">Select DOB</div>
                                </div>
                            </div>

                            <div class="popup-input">
                                <label for="course">Course Enrolled *</label>
                                <?php include("../general/course.php"); ?>
                                <div class="popup-error-text" id="error-course">Select Course</div>
                            </div>

                            <div class="popup-input">
                                <label for="nationality">Nationality *</label>
                                <?php include("../general/nationality.php"); ?>
                                <div class="popup-error-text" id="error-nationality">Select Nationality</div>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    const btnOpen = document.querySelectorAll(".updatePersonalInfo-btn");

                                    const userCourse = "<?php echo $row["course_name"]; ?>"; 
                                    const userNationality = "<?php echo $row["nationality"]; ?>"; 
                                    
                                    const selectCourse = document.getElementById("course");
                                    const selectNationality = document.getElementById("nationality");

                                    if (btnOpen) {
                                        btnOpen.forEach((btn) => {
                                            btn.addEventListener("click", () => {
                                                if (userCourse) {
                                                    selectCourse.value = userCourse;
                                                }

                                                if (userNationality) {
                                                    selectNationality.value = userNationality;
                                                }
                                            });
                                        });
                                    }
                                });
                            </script>
                        </div>

                        <div class="submit-container">
                            <button name="btnSubmit" value="Submit" class="submit-btn" id="btnSubmit-updateInfo">
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

                        <!-- js will run the promp to receive password from user  -->
                        <button class="profile-update-btn prompt-btn">
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

                        <button class="profile-update-btn updatePersonalInfo-btn">
                            <i class="fa-solid fa-pen"></i>
                            <p>Update</p>
                        </button>
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

                        <!-- js will run the promp to receive password from user  -->
                        <button class="profile-update-btn prompt-btn">
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
        <script src="../../scripts/admin_promptPassword.js"></script>
        <script src="../../scripts/validation.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>