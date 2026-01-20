<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    $sql_submission = "SELECT * FROM contact_submission";

    // for maintain the select option, even the page refresh
    $currentStatus = "";

    if (isset($_GET["submissionStatus"])) {
        $submissionStatus = $_GET["submissionStatus"];
        $currentStatus = $submissionStatus;

        if (!empty($submissionStatus)) {
            $sql_submission = "SELECT * FROM contact_submission
                               WHERE submission_status = '$submissionStatus'";
        }
    }

    if (isset($_GET["btnChangeStatus"])) {
        $targetSubmissionID = $_GET["target_submissionID"];
        $nextStatus = $_GET["next_status"];

        $sql_updateStatus = "UPDATE contact_submission SET submission_status = '$nextStatus'
                             WHERE submission_id = '$targetSubmissionID'";
        
        if(mysqli_query($conn, $sql_updateStatus)) {
            echo "<script>
                    alert('--- Successfully Updated Contact Submission Status ---\\nUser ID: $targetSubmissionID\\nNew Status: $nextStatus');
                    window.location.href = 'manageSystem.php';
                    </script>";
        }
    }

    $result_submission = mysqli_query($conn, $sql_submission);

    $submissions = array();
    if (mysqli_num_rows($result_submission) > 0) {
        while($row = mysqli_fetch_assoc($result_submission)) {
            $submissions[] = $row;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if($_POST["formType"] === "addNewAnnouncement") {
            $newAnnouncement = $_POST["newAnnouncement"];
            $announcementID = newID($conn, "announcement", "A");
            $today = date("Y-m-d H:i:s");

            $sql = "INSERT INTO announcement (announcement_id, user_id, announcement_details, announcement_datetime)
                    VALUES ('$announcementID', '$userID', '$newAnnouncement', '$today')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('--- Successfully Added Announcement ---\\nThe latest notifications will be displayed on the banner.');
                        window.location.href = 'manageSystem.php';
                      </script>";
            }
        }
    }

    // announcement
    $sql_announcement = "SELECT * FROM announcement GROUP BY announcement_datetime DESC";
    $result_announcement = mysqli_query($conn, $sql_announcement);

    // badges
    $sql_badge = "SELECT * FROM badges";
    $result_badge = mysqli_query($conn, $sql_badge);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage System</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Manage System</h1>
            <h2 class="page-subTitle">Oversee user communication and engagement settings</h2>

            <div class="flex-container">
                <div class="contact-submission-container">
                    <div class="contact-submission-header">
                        <h3>Contact Submission</h3>

                        <form action="" method="GET" id="submission-form">
                            <select id="submission-status" name="submissionStatus">
                                <option value="" <?php if($currentStatus == "") echo "selected" ?>>All</option>
                                <option value="Pending" <?php if($currentStatus == "Pending") echo "selected" ?>>Pending</option>
                                <option value="Complete" <?php if($currentStatus == "Complete") echo "selected" ?>>Complete</option>
                            </select>
                        </form>
                    </div>

                    <div class="table-container desktop-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    foreach ($submissions as $row) {
                                        $textColor = statusColor($row["submission_status"]);

                                        echo '<tr>
                                                <td>' . $row['submission_id'] . '</td>';

                                                if (!Empty($row["user_id"])) {
                                                    echo '<td>
                                                            <a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="redirect-link" title="View User Profile">
                                                                ' . $row['full_name'] . ' 
                                                                <i class="fa-solid fa-angle-double-right table-linkIcon"></i>
                                                            </a>
                                                          </td>';
                                                }
                                                else {
                                                    echo '<td>' . $row['full_name'] . '</td>';
                                                }
                                                
                                          echo '<td>' . $row['email_address'] . '</td>
                                                <td>' . $row['subject'] . '</td>
                                                <td style="color:' . $textColor . '">' . $row['submission_status'] . '</td>

                                                <td>
                                                    <div class="action-container">';
                                                        if ($row["submission_status"] === "Pending") {
                                                            echo '<form action="" method="GET">
                                                                        <input type="hidden" name="target_submissionID" value="' . $row['submission_id'] . '">
                                                                        <input type="hidden" name="next_status" value="Complete">

                                                                        <button name="btnChangeStatus" type="submit" class="action-btn confirm-btn" title="Complete">
                                                                            <i class="fa-solid fa-check"></i>
                                                                        </button>
                                                                   </form>';
                                                        }

                                                        echo '<a href="viewContactSubmission.php?id=' . $row['submission_id'] . '" class="action-btn" title="View">
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

                    <div class="table-container mobile-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    foreach ($submissions as $row) {
                                        $textColor = statusColor($row["submission_status"]);

                                        echo '<tr>
                                                <td>' . $row['submission_id'] . '</td>';
                                        
                                        if (!Empty($row["user_id"])) {
                                            echo '<td>
                                                    <a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="redirect-link" title="View User Profile">
                                                        ' . $row['full_name'] . ' 
                                                        <i class="fa-solid fa-angle-double-right table-linkIcon"></i>
                                                    </a>
                                                    </td>';
                                        }
                                        else {
                                            echo '<td>' . $row['full_name'] . '</td>';
                                        }

                                        echo ' <td style="color:' . $textColor . '">' . $row['submission_status'] . '</td>

                                                <td>
                                                    <div class="action-container">';
                                                        if ($row["submission_status"] === "Pending") {
                                                            echo '<form action="" method="GET">
                                                                        <input type="hidden" name="target_submissionID" value="' . $row['submission_id'] . '">
                                                                        <input type="hidden" name="next_status" value="Complete">

                                                                        <button name="btnChangeStatus" type="submit" class="action-btn confirm-btn" title="Complete">
                                                                            <i class="fa-solid fa-check"></i>
                                                                        </button>
                                                                    </form>';
                                                        }

                                                        echo '<a href="viewContactSubmission.php?id=' . $row['submission_id'] . '" class="action-btn" title="View">
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
                </div>

                <div class="overlay" id="popupOverlay"></div>

                <div class="popup" id="popup-add-announcement">
                    <div class="popup-header">
                        <div class="info-title">
                            <h3>Add New Announcement</h3>
                            <div class="line"></div>
                        </div>
                        <button id="popup-add-announcement-close-menu" class="icon-menu">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <form action="" method="POST" class="addNewAnnouncem-form">
                        <!-- used to know what form submited  -->
                        <input type="hidden" name="formType" value="addNewAnnouncement">
                        <div class="popup-scroll-area">
                            <div class="popup-input">
                                <label for="announcement">Announcement *</label>
                                <input type="text" name="newAnnouncement" id="newAnnouncement">
                                <div class="popup-error-text" id="error-announcement">Enter a Valid Announcement</div>
                            </div>
                        </div>

                        <div class="submit-container">
                            <button name="btnSubmit" value="Submit" class="submit-btn" id="btnSubmit-addNewAnnouncement">
                                <i class="fa-solid fa-circle-plus"></i>
                                <p>Add Announcement</p>
                            </button>
                        </div>            
                    </form>
                </div>

                <div class="manage-system-big-container">
                    <div class="manage-system-container">
                        <div class="manage-system-header">
                            <h3>System Announcements</h3>

                            <button class="add-new-btn addNewAnnouncement-btn">
                                <i class="fa-solid fa-circle-plus"></i>
                                <p>Add</p>
                            </button>
                        </div>

                        <div class="table-container table-handle">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Announcement</th>
                                        <th>Added By</th>
                                        <th>Date & Time</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        if (mysqli_num_rows($result_announcement) > 0) {
                                            while($row = mysqli_fetch_assoc($result_announcement)) {
                                                echo '<tr>
                                                        <td>' . $row['announcement_id'] . '</td>
                                                        <td>' . $row['announcement_details'] . '</td>
                                                        <td>' . $row['user_id'] . '</td>
                                                        <td>' . $row['announcement_datetime'] . '</td>
                                                      </tr>';
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="manage-system-container">
                        <div class="manage-system-header">
                            <h3>Badges</h3>

                            <button class="add-new-btn">
                                <i class="fa-solid fa-circle-plus"></i>
                                <p>Add</p>
                            </button>
                        </div>

                        <div class="table-container table-handle">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Badge</th>
                                        <th>Badge Name</th>
                                        <th>Points</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        if (mysqli_num_rows($result_badge) > 0) {
                                            while($row = mysqli_fetch_assoc($result_badge)) {
                                                echo '<tr>
                                                        <td>' . $row['badge_id'] . '</td>
                                                        <td><img src="../../' . $row['badge_image'] . '" alt="badge" width="50px" height="50px"></td>
                                                        <td>' . $row['badge_name'] . '</td>
                                                        <td>' . $row['points_required'] . '</td>
                                                        <td>
                                                            <a href="updateBadge.php?id=' . $row['badge_id'] . '" class="action-btn" title="Update">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                        </td>
                                                      </tr>';
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
        <script src="../../scripts/admin_popup_addAnnouncement.js"></script>
        <script src="../../scripts/validation.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>