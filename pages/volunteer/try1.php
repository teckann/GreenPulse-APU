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


<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    
    $userID = $_SESSION["userID"];

    // --- NEW: HANDLE IMAGE UPLOAD ---
    if(isset($_FILES["profileImage"]) && $_FILES["profileImage"]["error"] == 0){
        
        $target_dir = "../../src/profile_images/"; // Make sure this folder exists!
        
        // Create folder if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $fileType = strtolower(pathinfo($_FILES["profileImage"]["name"], PATHINFO_EXTENSION));
        // Create a unique name to prevent cache issues: profile_123_TIMESTAMP.jpg
        $newFileName = "profile_" . $userID . "_" . time() . "." . $fileType;
        $target_file = $target_dir . $newFileName;
        
        // Allowed file types
        $allowedTypes = array("jpg", "png", "jpeg", "gif");

        if(in_array($fileType, $allowedTypes)){
            if(move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)){
                
                // Save path in DB (Store relative path for cleaner DB)
                $db_path = "src/profile_images/" . $newFileName;
                
                $sql_update_pic = "UPDATE users SET avatar = '$db_path' WHERE user_id = '$userID'";
                mysqli_query($conn, $sql_update_pic);
                
                // Refresh page to show new image
                header("Location: editProfile.php");
                exit();
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        } else {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        }
    }
    // --- END IMAGE UPLOAD ---

    // ... (Keep your existing $_POST logic for other fields here) ...?>


<div class="pointBar-left" id="editProfilePic">
        
        <form id="avatarForm" action="" method="POST" enctype="multipart/form-data">
            
            <?php 
                // Display the image
                echo '<img src="../../'.$avatar.'" alt="User Profile" class="profilePic">'; 
            ?>

            <input type="file" name="profileImage" id="fileInput" style="display: none;" accept="image/*">

            <button type="button" id="uploadPicBtn">
                <i class="fa-solid fa-camera" id="editPicIcon"></i>
            </button>

        </form>

    </div>

    <script>
        const uploadBtn = document.getElementById('uploadPicBtn');
        const fileInput = document.getElementById('fileInput');
        const form = document.getElementById('avatarForm');

        // When the camera icon is clicked, click the hidden file input
        uploadBtn.addEventListener('click', function() {
            fileInput.click();
        });

        // When a file is selected, automatically submit the form
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                form.submit();
            }
        });
    </script>