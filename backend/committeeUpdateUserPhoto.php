<?php
    include("../conn.php");
    include("sessionData.php");
    include("utility.php");
    
    if (isset($_POST["btnConfirmChangeProfilePhoto"])) {
        $file = $_FILES["updateFile"];

        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];

        $target_dir = "../src/avatars/"; // target folder that save the image
        $imageFileType = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // format file

        $newFileName = $userID . "_avatars_" . time() . "." . $imageFileType;
        $target_file = $target_dir . $newFileName;  // file that system will save

        $allowFormat = array("png", "jpg", "jpeg");
		$uploadOk = 1; // if upload fails, it will change to 0

        if ($fileSize > 0) {
            $uploadOk = 1;
        }
        else {
            $uploadOk = 0;
            echo "<script>
                    alert('The photo is not upload successfully');
                    window.location.href = '../pages/committee/committeeProfile.php';
                  </script>";
        }

        if ($fileSize > 5000000) {
            $uploadOk = 0;
            echo "<script>
                    alert('Maximum file size is 5 MB only.');
                    window.location.href = '../pages/committee/committeeProfile.php';
                  </script>";
        }

        if (!in_array($imageFileType, $allowFormat)) {
            $uploadOk = 0;
            echo "<script>
                    alert('System only support png, jpg, and jpeg image format.');
                    window.location.href = '../pages/committee/committeeProfile.php';
                  </script>";
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($fileTmpName, $target_file)) {

                $databasePath = "src/avatars/" . $newFileName;

                $sql = "UPDATE users SET avatar = '$databasePath'
                        WHERE user_id = '$userID'";
                
                if (mysqli_query($conn, $sql)) {
                    addLog($conn, $userID, "Update Profile Photo ($userID)");
                    
                    echo "<script>
                            alert('Image is updated successfully');
                            window.location.href = '../pages/committee/committeeProfile.php';
                          </script>";
                }
            }
            else {
                echo "<script>
                        alert('Image failed to upload.');
                        window.location.href = '../pages/committee/committeeProfile.php';
                      </script>";
            }
        }
        else {
            echo "<script>
                    alert('Image failed to upload.');
                    window.location.href = '../pages/committee/committeeProfile.php';
                  </script>";
        }
    }
?>