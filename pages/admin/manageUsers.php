<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    $sql = "SELECT * FROM users";
    $target = "";

    if (isset($_GET["btnSearch"])) {
        $target = $_GET["target"];

        $sql = "SELECT * FROM users WHERE name LIKE '%{$target}%'";
    }

    if (isset($_GET["btnChangeStatus"])) {
        $targetUserID = $_GET["target_userID"];
        $nextStatus = $_GET["next_status"];

        if ($targetUserID == $userID) {
            echo "<script>
                    alert('You cannot inactive yourself');
                    window.location.href = 'manageUsers.php';
                  </script>";
        }
        else {
            $sql_updateStatus = "UPDATE users SET account_status = '$nextStatus' 
                                 WHERE user_id = '$targetUserID'";
        
            if(mysqli_query($conn, $sql_updateStatus)) {
                echo "<script>
                        alert('--- Successfully Updated User Status ---\\nUser ID: $targetUserID\\nNew Status: $nextStatus');
                        window.location.href = 'manageUsers.php';
                      </script>";
            }
        }
    }

    $currentStatus = "";
    $currentRole = "";

    if (isset($_GET["txtRole"]) || isset($_GET["txtStatus"])) {
        $role = $_GET["txtRole"];
        $accountStatus = $_GET["txtStatus"];

        $currentRole = $role;
        $currentStatus = $accountStatus;

        if (!empty($role) && !empty($accountStatus)) {
            $sql = "SELECT * FROM users 
                    WHERE role = '$role' AND account_status = '$accountStatus'";
        }
        elseif (!empty($role)) {
            $sql = "SELECT * FROM users 
                    WHERE role = '$role'";
        }
        elseif (!empty($accountStatus)) {
            $sql = "SELECT * FROM users 
                    WHERE account_status = '$accountStatus'";
        }
    }

    $result = mysqli_query($conn, $sql);


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = trim($_POST["name"]);
        $emailID = trim($_POST["emailID"]);
        $contactNumber = trim($_POST["contactNumber"]);
        $dateOfBirth = $_POST["dateOfBirth"];
        $courseName = $_POST["courseName"];
        $gender = $_POST["gender"];
        $nationality = $_POST["nationality"];
        $role = $_POST["role"];

        $email = strtoupper($emailID) . "@mail.apu.edu.my";
        $newUserID = newID($conn, "users", "U");
        $registrationDate =  date("Y-m-d");

        // default password
        $arr = explode("-", $dateOfBirth);
        $dob = $arr[1] .$arr[2];
        $defaultPassword = $newUserID . "@" . $dob;
        $hash = password_hash($defaultPassword, PASSWORD_DEFAULT);

        $avatar = "src/avatars/default.png";

        $sql_addUser = "";

        if ($role == "admin" || $role == "committee") {
            $sql_addUser = "INSERT INTO users (user_id, name, nationality, gender, date_of_birth, contact_number, 
                            education_email, course_name, registration_date, password, avatar, role)
                            VALUES ('$newUserID', '$name', '$nationality', '$gender', '$dateOfBirth', '$contactNumber', 
                            '$email', '$courseName', '$registrationDate', '$hash', '$avatar', '$role')";
        }
        else {
            $greenPoints = 0;
            $totalEarned = 0;

            $sql_addUser = "INSERT INTO users (user_id, name, nationality, gender, date_of_birth, contact_number, 
                            education_email, course_name, registration_date, password, green_points, total_earned, avatar, role)
                            VALUES ('$newUserID', '$name', '$nationality', '$gender', '$dateOfBirth', '$contactNumber', 
                            '$email', '$courseName', '$registrationDate', '$hash', '$greenPoints', '$totalEarned', '$avatar', '$role')";
        }

        if(mysqli_query($conn, $sql_addUser)) {
            $titleFormat_role = ucwords($role);
            echo "<script>
                    alert('--- Successfully Added New User ---\\nAccess Granted!\\nUser ID: $newUserID\\nRole: $titleFormat_role\\nDefault Password Format: UXXX@MMDD');
                    window.location.href = 'manageUsers.php';
                  </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Users</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php") ?>
    </head>
    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Manage Users</h1>
            <h2 class="page-subTitle">Overview of all registered accounts</h2>

            <div class="action-bar" style="margin: 1em 0;">
                <form action="" method="GET">
                    <div class="table-search-box">
                        <input type="text" name="target" placeholder="Search user here">
                        <i class="fa-solid fa-magnifying-glass"></i>

                        <button name="btnSearch" type="submit" value="Search" class="table-btnSearch" title="Search"></button>
                    </div>
                </form>

                <form action="" method="GET" class="select-container" id="user-form">
                    <div class="select-boxs">
                        <div>
                            <label for="userRole">Role: </label>
                            <select name="txtRole" id="userRole">
                                <option value="" <?php if($currentRole === "") echo "selected" ?>>All</option>
                                <option value="admin" <?php if($currentRole === "admin") echo "selected" ?>>Admin</option>
                                <option value="committee" <?php if($currentRole === "committee") echo "selected" ?>>Committee</option>
                                <option value="volunteer" <?php if($currentRole === "volunteer") echo "selected" ?>>Volunteer</option>
                            </select>
                        </div>

                        <div>
                            <label for="userStatus">Status: </label>
                            <select name="txtStatus" id="userStatus">
                                <option value="" <?php if($currentStatus === "") echo "selected" ?>>All</option>
                                <option value="Active" <?php if($currentStatus === "Active") echo "selected" ?>>Active</option>
                                <option value="Inactive" <?php if($currentStatus === "Inactive") echo "selected" ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="action-btns">
                        <button class="print" onclick="window.print()">
                            <i class="fa-solid fa-print"></i>
                        </button>

                        <button type="button" class="addNewUser-btn">
                            <i class="fa-solid fa-user-plus"></i>
                            <p>Add New User</p>
                        </button>
                    </div>
                </form>
            </div>

            <div class="overlay" id="popupOverlay"></div>

            <div class="popup" id="popup">
                <div class="popup-header">
                    <div class="info-title">
                        <h3>Add New User</h3>
                        <div class="line"></div>
                    </div>
                    <button id="popup-close-menu" class="icon-menu">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="" method="POST" class="popup-form">
                    <div class="popup-scroll-area">
                        <div class="popup-input">
                            <label for="fullname">Full Name *</label>
                            <input type="text" name="name" id="fullname" placeholder="e.g. Marcus">
                            <div class="popup-error-text" id="error-fullname">Enter a Valid Name</div>
                        </div>

                        <div class="popup-input">
                            <label for="email">Education Email *</label>
                            <div style = "display: flex; flex-direction: row; align-items: center; gap:5px;">
                                <input type="text" name="emailID" id="email" placeholder="e.g. TP012345">
                                <label for="email">@mail.apu.edu.my</label>
                            </div>
                            <div class="popup-error-text" id="error-email">Enter a Valid APU Education Email</div>
                        </div>

                        <div class="popup-row">
                            <div class="popup-input popup-contact">
                                <label for="contactNumber">Contact Number *</label>
                                <div class="popup-sub-input">
                                    <label for="contact">+60 </label>
                                    <input type="text" name="contactNumber" id="contact" placeholder="e.g. 0123456789">
                                </div>
                                <div class="popup-error-text" id="error-contactNumber">Enter a Valid Contact Number</div>
                            </div>

                            <div class="popup-input popup-dob">
                                <label for="dob">DOB *</label>
                                <input type="date" name="dateOfBirth" id="dob">
                                <div class="popup-error-text" id="error-dob">Select DOB</div>
                            </div>
                        </div>

                        <div class="popup-input">
                            <label for="course">Course Enrolled *</label>
                            <?php include("../general/course.php"); ?>
                            <div class="popup-error-text" id="error-course">Select Course</div>
                        </div>

                        <div class="popup-row">
                            <div class="popup-input">
                                <label for="gender">Gender *</label>
                                <div style="display: flex; flex-direction: row; gap:15px; margin-top: 0.5em;">
                                    <label><input type="radio" name="gender" value="M" class="popup-radio"> Male</label>
                                    <label><input type="radio" name="gender" value="F" class="popup-radio"> Female</label>
                                </div>
                                <div class="popup-error-text" id="error-gender">Select Gender</div>
                            </div>

                            <div class="popup-input popup-nationality">
                                <label for="nationality">Nationality *</label>
                                <?php include("../general/nationality.php"); ?>
                                <div class="popup-error-text" id="error-nationality">Select Nationality</div>
                            </div>
                        </div>

                        <div class="popup-input">
                            <label for="permission">Access Permission *</label>
                            <select name="role" id="permission">
                                <option value="">-- Please Select --</option>
                                <option value="admin">Admin</option>
                                <option value="committee">Committee</option>
                                <option value="volunteer">Volunteer</option>
                            </select>
                            <div class="popup-error-text" id="error-permission">Select Access Permission</div>
                        </div>
                    </div>

                    <div class="submit-container">
                        <button name="btnSubmit" value="Submit" class="submit-btn" id="btnSubmit-addNewUser">
                            <i class="fa-solid fa-paper-plane"></i>
                            <p>Submit</p>
                        </button>
                    </div>
                </form>
            </div>

            <?php
                $users = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $users[] = $row;
                }
            ?>

            <div class="flex-container desktop-table" style="margin: 1em 0;">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Full Name</th>
                            <th>Education Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            foreach ($users as $row) {
                                $config = tableConfig($row["account_status"]);

                                $textColor = $config[0];
                                $icon = $config[1];
                                $title = $config[2];
                                $nextStatus = $config[3];

                                echo '<tr>
                                        <td>' . $row['user_id'] . '</td>
                                        <td>' . $row['name'] . '</td>
                                        <td>' . $row['education_email'] . '</td>
                                        <td>' . ucwords($row['role']) . '</td>
                                        <td style="color:' . $textColor . '">' . $row['account_status'] . '</td>
                                        
                                        <td>
                                            <div class="action-container">
                                                <form action="" method="GET">
                                                    <input type="hidden" name="target_userID" value="' . $row['user_id'] . '">
                                                    <input type="hidden" name="next_status" value="' . $nextStatus . '">

                                                    <button name="btnChangeStatus" type="submit" class="action-btn" title="'. $title .'">
                                                        ' . $icon . '
                                                    </button>
                                                </form>

                                                <a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="action-btn" title="View">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="flex-container mobile-card" style="margin: 1em 0;">
                <?php
                    foreach ($users as $row) {
                        $config = tableConfig($row["account_status"]);

                        $bgColor = $config[0];
                        $icon = $config[1];
                        $title = $config[2];
                        $nextStatus = $config[3];

                        $text = $nextStatus;

                        echo '<div class="cards">
                                <div class="card-header">
                                    <div class="card-id">
                                        <p>User ID</p>
                                        <h3>' . $row['user_id'] . '</h3>
                                    </div>

                                    <div class="card-status" style="background-color:' . $bgColor . '">
                                        <p>' . $row['account_status'] . '</p>
                                    </div>
                                </div>

                                <div class="card-content">
                                    <div class="card-data">
                                        <p>Name</p>
                                        <p>' . $row['name'] . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>Education Email</p>
                                        <p>' . $row['education_email'] . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>Role</p>
                                        <p>' . ucwords($row['role']) . '</p>
                                    </div>
                                </div>

                                <div class="card-btns">
                                    <form action="" method="GET">
                                        <input type="hidden" name="target_userID" value="' . $row['user_id'] . '">
                                        <input type="hidden" name="next_status" value="' . $nextStatus . '">

                                        <button name="btnChangeStatus" type="submit" class="card-action-btn card-status-btn" title="'. $title .'">
                                            ' . $icon . '
                                            <p>' . $text . '</p>
                                        </button>
                                    </form>

                                    <a href="viewUserProfile.php?id=' . $row['user_id'] . '" title="View">
                                        <button class="card-action-btn card-view-btn">
                                            View User Details
                                        </button>
                                    </a>
                                </div>
                              </div>';
                    }
                ?>
            </div>
        </main>

        <?php include("footer.php"); ?>
        
        <script src="../../scripts/admin.js"></script>
        <script src="../../scripts/admin_popup_addNewUser.js"></script>
        <script src="../../scripts/validation.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>