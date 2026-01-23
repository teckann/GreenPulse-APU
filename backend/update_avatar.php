<?php
    include("../conn.php");
    include("sessionData.php");
    
    if (isset($_POST["btnUpdateAvatar"])) {
        $file = $_FILES["avatar_image"];

        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];

        $target_dir = "../src/avatars/"; // target folder that save the avatar
        $imageFileType = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // format file

        $newFileName = $userID . "_avatar_" . time() . "." . $imageFileType;
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
                    window.location.href = '../pages/admin/profile.php';
                  </script>";
        }

        if ($fileSize > 5000000) {
            $uploadOk = 0;
            echo "<script>
                    alert('Maximum file size is 5 MB only.');
                    window.location.href = '../pages/admin/profile.php';
                  </script>";
        }

        if (!in_array($imageFileType, $allowFormat)) {
            $uploadOk = 0;
            echo "<script>
                    alert('System only support png, jpg, and jpeg image format.');
                    window.location.href = '../pages/admin/profile.php';
                  </script>";
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($fileTmpName, $target_file)) {

                $databasePath = "src/avatars/" . $newFileName;

                $sql = "UPDATE users SET avatar = '$databasePath'
                        WHERE user_id = '$userID'";
                
                if (mysqli_query($conn, $sql)) {
                    // record action into log
                    // addLog($conn, $userID, "Update Profile Picture ($userID)");
                    echo "<script>
                            alert('--- Successfully Updated Avatar ---\\nTarget Account: $userID\\nNew Avatar: $newFileName');
                            window.location.href = '../pages/admin/profile.php';
                          </script>";
                }
            }
            else {
                echo "<script>
                        alert('Image failed to upload.');
                        window.location.href = '../pages/admin/profile.php';
                      </script>";
            }
        }
        else {
            echo "<script>
                    alert('Image failed to upload.');
                    window.location.href = '../pages/admin/profile.php';
                  </script>";
        }
    }
?>