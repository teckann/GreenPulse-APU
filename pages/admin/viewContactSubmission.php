<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    if (isset($_GET["btnBack"])) {
        header("Location: manageSystem.php");
        exit;
    }

    $data = array();
    $insightDetails = "";
    $textColor = "";
    $subject_emailFormat = "";
    $template_emailFormat = "";

    if(isset($_GET["id"])) {
        $id = $_GET["id"];
        
        $sql = "SELECT * FROM contact_submission WHERE submission_id = '$id'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);

        if (!empty($data["user_id"])) {
            $insightDetails = "Verified sender. This contact submission was sent by a registered user.";
        }
        else {
            $insightDetails = "Unverified sender. This contact submission was sent by a guest user.";
        }

        $textColor = statusColor($data["submission_status"]);

        // email subject
        $partOfSubject = explode(" ", $data["subject"]);
        $subject_emailFormat = "Follow-up:%20" . implode("%20", $partOfSubject);


        // sender name (email format)
        $partOfSenderName = explode(" ", $data["full_name"]);
        $senderName_emailFormat = implode("%20", $partOfSenderName);

        // admin name (email format)
        $adminName = getUserName($conn, $userID);
        $partOfAdminName = explode(" ", $adminName);
        $adminName_emailFormat = implode("%20", $partOfAdminName);


        // email template
        $template_emailFormat = "Dear%20" . $senderName_emailFormat . ",%0A%0A" .
                                "Greetings%20from%20GreenPulse%20APU.%0A%0A" .
                                "Best%20regards,%0A" .
                                $adminName_emailFormat . "%0A" .
                                "Admin%20of%20GreenPulse%20APU";


    }
    else {
        echo "<script>
                alert('Invalid Access');
                window.location.href = 'manageSystem.php';
              </script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Contact Submission</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>View Contact Submission</h1>
            <h2 class="page-subTitle">Review the full details of this user inquiry</h2>

            <div class="flex-container viewDetails">
                <form action="" action="GET">
                    <button name="btnBack" class="back-btn" type="submit" value="Back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p>Back</p>
                    </button>
                </form>

                <div class="reminder-container">
                    <div class="reminder-header">
                        <i class="fa-solid fa-circle-info"></i>
                        <h3>Sender Insights</h3>
                    </div>
                    <p class="reminder-details"><?php echo $insightDetails ?></p>

                    <?php 
                        if (!empty($data["user_id"])) {
                            echo '<a href="viewUserProfile.php?id=' . $data['user_id'] . '">View verified user profile here</a>';
                        }
                    ?>
                </div>

                <div class="submission-details">
                    <table class="submission-details-table">
                        <tr>
                            <td>Submission ID</td>
                            <td>:</td>
                            <td><?php echo $data["submission_id"] ?></td>
                        </tr>

                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td style="color: <?php echo $textColor ?>;"><?php echo $data["submission_status"] ?></td>
                        </tr>

                        <tr>
                            <td>Full Name</td>
                            <td>:</td>
                            <td><?php echo $data["full_name"] ?></td>
                        </tr>

                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?php echo $data["email_address"] ?></td>
                        </tr>

                        <tr>
                            <td>Contact No.</td>
                            <td>:</td>
                            <td><?php echo $data["contact_number"] ?></td>
                        </tr>

                        <tr>
                            <td>Date & Time</td>
                            <td>:</td>
                            <td><?php echo $data["submission_datetime"] ?></td>
                        </tr>

                        <tr>
                            <td>Subject</td>
                            <td>:</td>
                            <td><strong><?php echo $data["subject"] ?></strong></td>
                        </tr>

                        <tr>
                            <td>Details</td>
                            <td>:</td>
                            <td><?php echo $data["content"] ?></td>
                        </tr>
                    </table>

                    <div class="submission-details-action">
                        <button class="contact-btn"
                            onclick="<?php 
                                if ($data['submission_status'] === 'Complete') {
                                    echo "alert('--- This Submission has been Contacted ---\\nYou are NOT allow to contact again.'); return false;";
                                } else {
                                    echo "window.location.href='mailto:" . $data['email_address'] . 
                                        "?subject=" . $subject_emailFormat . 
                                        "&body=" . $template_emailFormat . "';";
                                }
                            ?>"
                        >
                            <i class="fa-solid fa-envelope"></i>
                            <p>Contact Now</p>
                        </button>
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