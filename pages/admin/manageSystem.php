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

                <div class="">

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