<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    if (isset($_GET["btnBack"])) {
        header("Location: manageUsers.php");
        exit;
    }

    $data = array();

    $age = "";
    $statusColor = "";
    $gender = "";

    $accountSecurityStatus = "";
    $accountStatusColor = "";
    $safetyQuestion_icon = "";
    $changedDefaultPassword_icon = "";

    $event_text = "";
    $total_event = 0;

    $total_earn = 0;

    if(isset($_GET["id"])) {
        $id = $_GET["id"];
        
        $sql = "SELECT * FROM users WHERE user_id = '$id'";
        $result = mysqli_query($conn, $sql);

        $data = mysqli_fetch_assoc($result);

        $age = date_diff(date_create($data["date_of_birth"]), date_create("today")) -> y;

        $statusColor = statusColor($data["account_status"]);

        if ($data["gender"] === "M") {
            $gender = "Male";
        }
        elseif ($data["gender"] === "F") {
            $gender = "Female";
        }

        // find the dob
        $arr = explode("-", $data["date_of_birth"]);
        $dob = $arr[1] .$arr[2];
        $defaultPassword = $data["user_id"] . "@" . $dob;

        $defaultPassword_test = !password_verify($defaultPassword, $data["password"]);
        $safetyQuestion_test = !empty($data["safety_question_1"]);

        // both true (have safety question and chenged password)
        if ($safetyQuestion_test && $defaultPassword_test) {
            $accountSecurityStatus = "Safe";
            $accountStatusColor = "#28a745";
            $safetyQuestion_icon = "fa-solid fa-check";
            $changedDefaultPassword_icon = $safetyQuestion_icon;
        }
        // either one is true (no safety question && chenged password OR safety question && default password)
        elseif (($safetyQuestion_test && !$defaultPassword_test) || (!$safetyQuestion_test && $defaultPassword_test)) {
            $accountSecurityStatus = "Warning";
            $accountStatusColor = "#ffca28";
            
            if ($safetyQuestion_test && !$defaultPassword_test) {
                $safetyQuestion_icon = "fa-solid fa-check";
                $changedDefaultPassword_icon = "fa-solid fa-xmark";
            }
            else {
                $safetyQuestion_icon = "fa-solid fa-xmark";
                $changedDefaultPassword_icon = "fa-solid fa-check";
            }
        }
        else {
            $accountSecurityStatus = "Danger";
            $accountStatusColor = "#dc3545";
            $safetyQuestion_icon = "fa-solid fa-xmark";
            $changedDefaultPassword_icon = $safetyQuestion_icon;
        }


        // find the total event create or registered
        if ($data["role"] != "admin") {
            $sql_totalEvent = "";

            if ($data["role"] === "committee") {
                $sql_totalEvent = "SELECT COUNT(*) AS total FROM events WHERE user_id = '$id'";
                $event_text = "Posted";
            }
            elseif ($data["role"] === "volunteer") {
                $sql_totalEvent = "SELECT COUNT(*) AS total FROM attendance WHERE user_id = '$id' AND attendance_status = 'Present'";
                $event_text = "Attended";
            }

            $result_totalEvent = mysqli_query($conn, $sql_totalEvent);
            $row = mysqli_fetch_assoc($result_totalEvent);
            $total_event = $row["total"];
        }
        else {
            $event_text = "Posted/Attended";
            $total_event = "Not Support";
        }
        
    }
    else {
        echo "<script>alert('ID not granted yet')</script>";
        exit;
    }

    $registrationDate = $data["registration_date"];
    $formatted_registrationDate = date("d M Y", strtotime($registrationDate));
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View User Profile</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php") ?> 
    </head>
    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>View User Profile</h1>
            <h2 class="page-subTitle">Detailed information about this user</h2>

            <div class="flex-container viewDetails">
                <form action="" action="GET">
                    <button name="btnBack" class="back-btn" type="submit" value="Back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p>Back</p>
                    </button>
                </form>

                <div class="viewDetails-header">
                    <img src="../../<?php echo $data['avatar'] ?>" alt="user_avatar" width="100px" height="100px">

                    <div class="viewDetails-title">
                        <h2><?php echo $data["name"] ?></h2>

                        <div class="row">
                            <p><?php echo $data["user_id"] ?></p>
                            <p><?php echo ucwords($data["role"]) ?></p>
                        </div>

                        <div class="row status" style="background-color: <?php echo $statusColor; ?>">
                            <?php echo $data["account_status"] ?>
                        </div>
                    </div>
                </div>

                <div class="viewDetails-content">
                    <div class="info-box1">
                        <div class="info-title">
                            <p>Personal Information</p>
                            <div class="line"></div>
                        </div>

                        <div class="info-content">
                            <table>
                                <tr>
                                    <td>Full Name</td>
                                    <td>:</td>
                                    <td><?php echo $data["name"] ?></td>
                                </tr>

                                <tr>
                                    <td>Gender</td>
                                    <td>:</td>
                                    <td><?php echo $gender ?></td>
                                </tr>

                                <tr>
                                    <td>Nationality</td>
                                    <td>:</td>
                                    <td><?php echo $data["nationality"] ?></td>
                                </tr>

                                <tr>
                                    <td>Date of Birth (DOB)</td>
                                    <td>:</td>
                                    <td><?php echo $data["date_of_birth"] ?></td>
                                </tr>

                                <tr>
                                    <td>Age</td>
                                    <td>:</td>
                                    <td><?php echo $age ?></td>
                                </tr>

                                <tr>
                                    <td>Education Email</td>
                                    <td>:</td>
                                    <td><?php echo $data["education_email"] ?></td>
                                </tr>

                                <tr>
                                    <td>Contact Number</td>
                                    <td>:</td>
                                    <td><?php echo $data["contact_number"] ?></td>
                                </tr>

                                <tr>
                                    <td>Course Enrolled</td>
                                    <td>:</td>
                                    <td><?php echo $data["course_name"] ?></td>
                                </tr>

                                <tr>
                                    <td>Registration Date</td>
                                    <td>:</td>
                                    <td><?php echo $formatted_registrationDate ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="info-box2">
                        <div class="tracking-box1">
                            <div class="info-title">
                                <p>Account Security Analysis</p>
                                <div class="line"></div>
                            </div>

                            <div class="info-content">
                                <div class="account-security-status" style="background-color: <?php echo $accountStatusColor ?>">
                                    <p><?php echo $accountSecurityStatus ?></p>
                                </div>

                                <div class="icon-text">
                                    <i class="<?php echo $changedDefaultPassword_icon ?>"></i>
                                    <p>Default Password Changed</p>
                                </div>

                                <div class="icon-text">
                                    <i class="<?php echo $safetyQuestion_icon ?>"></i>
                                    <p>Security Questions Set</p>
                                </div>
                            </div>
                        </div>

                        <div class="tracking-box2">
                            <div class="info-title">
                                <p>User Activity Monitoring</p>
                                <div class="line"></div>
                            </div>

                            <div class="info-content">
                                <div class="icon-text">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                    <p>Last Login: <?php echo $data["last_login"] ?? "N/A" ?></p>
                                </div>

                                <div class="icon-text">
                                    <i class="fa-solid fa-calendar-check"></i>
                                    <p>Total Event <?php echo $event_text ?>: <?php echo $total_event ?></p>
                                </div>

                                <div class="icon-text">
                                    <i class="fa-solid fa-leaf"></i>
                                    <p>Total Earned (Green Points): <?php echo $data["total_earned"] === null ? "Not Support" : $data["total_earned"] . " GP" ?></p>
                                </div>

                                <div class="icon-text">
                                    <i class="fa-solid fa-leaf"></i>
                                    <p>Current Green Points: <?php echo $data["green_points"] === null ? "Not Support" : $data["green_points"] . " GP" ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>