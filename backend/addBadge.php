<?php
    include("../conn.php");
    include("sessionData.php");
    include("utility.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if($_POST["formType"] === "addNewBadge") {
            $badgeName = $_POST["badgeName"];
            $requiredPoints = $_POST["points"];
            $file = $_FILES["badge_image"];
            $badgeID = newID($conn, "badges", "B");

            $fileName = $file["name"];
            $fileTmpName = $file["tmp_name"];
            $fileSize = $file["size"];

            $target_dir = "../src/badgeImages/"; // target folder that save the avatar
            $imageFileType = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // format file

            $newFileName = $userID . "_badge_" . time() . "." . $imageFileType;
            $target_file = $target_dir . $newFileName;  // file that system will save

            $allowFormat = array("png", "jpg", "jpeg");
            $uploadOk = 1; // if upload fails, it will change to 0

            if ($fileSize > 0) {
                $uploadOk = 1;
            }
            else {
                $uploadOk = 0;
                echo "<script>
                        alert('It seem like the image was not uploaded successfully.');
                        window.location.href = '../pages/admin/manageSystem.php';
                        </script>";
            }

            if ($fileSize > 5000000) {
                $uploadOk = 0;
                echo "<script>
                        alert('Maximum file size is 5 MB only.');
                        window.location.href = '../pages/admin/manageSystem.php';
                        </script>";
            }

            if (!in_array($imageFileType, $allowFormat)) {
                $uploadOk = 0;
                echo "<script>
                        alert('System only support png, jpg, and jpeg image format.');
                        window.location.href = '../pages/admin/manageSystem.php';
                        </script>";
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($fileTmpName, $target_file)) {

                    $databasePath = "src/badgeImages/" . $newFileName;

                    $sql = "INSERT INTO badges (badge_id, badge_name, badge_image, points_required)
                            VALUES ('$badgeID', '$badgeName', '$databasePath', '$requiredPoints')";
                    
                    if (mysqli_query($conn, $sql)) {
                        echo "<script>
                                alert('--- Successfully added Badge ---\\nBadge ID: $badgeID\\nBadge Name: $badgeName\\nRequired Points: $requiredPoints');
                                window.location.href = '../pages/admin/manageSystem.php';
                                </script>";
                    }
                }
                else {
                    echo "<script>
                            alert('Image failed to upload.');
                            window.location.href = '../pages/admin/manageSystem.php';
                            </script>";
                }
            }
            else {
                echo "<script>
                        alert('Image failed to upload.');
                        window.location.href = '../pages/admin/manageSystem.php';
                        </script>";
            }
        }
    }
?>