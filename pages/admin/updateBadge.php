<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");

    if (isset($_GET["btnBack"])) {
        unset($_SESSION["id"]);
        header("Location: manageSystem.php");
        exit;
    }
    

    $row = "";

    if (isset($_GET["id"]) || isset($_SESSION["id"])) {
        $id = "";
        
        if (isset($_SESSION["id"])) {
            $id = $_SESSION["id"];
        }
        else {
            $id = $_GET["id"];
            $_SESSION["id"] = $id;
        }

        $sql = "SELECT * FROM badges WHERE badge_id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $badgeName = $_POST["badgeName"];
            $requiredPoints = $_POST["points"];

            $sql_updateBadgeInfo = "UPDATE badges SET
                                    badge_name = '$badgeName', points_required = '$requiredPoints'
                                    WHERE badge_id = '$id'";

            if (mysqli_query($conn, $sql_updateBadgeInfo)) {
                // record action into log
                addLog($conn, $userID, "Update Badge Information ($id)");
                
                echo "<script>
                        alert('--- Successfully Updated Badge Infomation ---\\nThe badge criteria have been successfully updated.');
                        window.location.href = 'updateBadge.php';
                      </script>";
            }
        }
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
        <title>Update Badge</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Update Badges</h1>
            <h2 class="page-subTitle">Update achievement milestones and reward settings</h2>

            <div class="flex-container">
                <form action="" method="GET" class="updateSecuritySettings-back-btn-form">
                    <button name="btnBack" class="back-btn" type="submit" value="Back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p>Back</p>
                    </button>
                </form>

                <div class="badge-info-container">
                    <div class="badge-container">
                        <img src="../../<?php echo $row["badge_image"] ?>" alt="badge image" class="badge-image">
                        <button class="edit-badge-icon" style="background-color: #666; color: white;">
                            <i class="fa-solid fa-camera"></i>
                        </button>
                    </div>

                    <div class="overlay" id="popupOverlay"></div>

                    <div class="popup" id="popup-updateBadge">
                        <div class="popup-header">
                            <div class="info-title">
                                <h3>Update Badge Image</h3>
                                <div class="line"></div>
                            </div>
                            <button id="popup-close-menu" class="icon-menu">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- enctype very important to take the file value/path  -->
                        <form action="../../backend/update_badgeImage.php" method="POST" enctype="multipart/form-data" class="update-badge-image-form">
                            <input type="text" name="badgeID" value="<?php echo $row["badge_id"] ?>" hidden>

                            <div class="update-badge-container">
                                <img src="../../<?php echo $row["badge_image"]; ?>" class="preview-badge" id="preview-badge" alt="Badge Preview">

                                <label for="badge_image" class="upload-file-btn">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <p>Choose Image</p>
                                </label>
                                <input type="file" id="badge_image" name="badge_image" class="uploadFile-btn" hidden>

                                <span id="file-name" class="file-name">No file choosen</span>
                            </div>

                            <div class="submit-container">
                                <button type="submit" name="btnUpdateBadgeImage" value="Submit" class="submit-btn">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <p>Save Changes</p>
                                </button>
                            </div>            
                        </form>
                    </div>

                    <form action="" method="POST" class="popup-form update-badge-info-form" style="margin-top: 0.5em;">
                        <div class="popup-input">
                            <label for="badgeID">Badge ID</label>
                            <input type="text" id="badgeID" value="<?php echo $row["badge_id"] ?>" disabled>
                        </div>

                        <div class="popup-input">
                            <label for="badgeName">Badge Name *</label>
                            <input type="text" name="badgeName" id="badgeName" value="<?php echo $row["badge_name"] ?>">
                            <div class="popup-error-text" id="error-badge-name">Enter a Valid Badge Name</div>
                        </div>

                        <div class="popup-input">
                            <label for="points">Required Points *</label>
                            <input type="number" name="points" id="points" value="<?php echo $row["points_required"] ?>">
                            <div class="popup-error-text" id="error-point-number">Enter a Valid Number</div>
                        </div>

                        <div class="badge-submit-container">
                            <button name="btnSubmit" value="Submit" class="submit-btn badge-submit-btn" id="btnSubmit-update-badge-info">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <p>Save Changes</p>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
        <script src="../../scripts/validation.js"></script>
        <script src="../../scripts/admin_popup_updateBadge.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>