<?php
    include("../conn.php");
    include("sessionData.php");
    include("utility.php");
    
    if (isset($_POST["btnChangeTreePhoto"])) {
        $itemID = $_POST["itemId"];
        $file = $_FILES["updateFile"];

        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];

        $target_dir = "../src/itemImages/"; // target folder that save the image
        $imageFileType = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // format file

        $newFileName = $itemID . "_treeImage_" . time() . "." . $imageFileType;
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
                    window.location.href = '../pages/committee/availableTreePage.php';
                  </script>";
        }

        if ($fileSize > 5000000) {
            $uploadOk = 0;
            echo "<script>
                    alert('Maximum file size is 5 MB only.');
                    window.location.href = '../pages/committee/availableTreePage.php';
                  </script>";
        }

        if (!in_array($imageFileType, $allowFormat)) {
            $uploadOk = 0;
            echo "<script>
                    alert('System only support png, jpg, and jpeg image format.');
                    window.location.href = '../pages/committee/availableTreePage.php';
                  </script>";
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($fileTmpName, $target_file)) {

                $databasePath = "src/itemImages/" . $newFileName;

                $sql = "UPDATE items SET item_image = '$databasePath'
                        WHERE item_id = '$itemID'";
                
                if (mysqli_query($conn, $sql)) {
                    addLog($conn, $userID, "Change available tree photo");
                    
                    echo "<script>
                            alert('Image is updated successfully');
                            window.location.href = '../pages/committee/availableTreePage.php';
                          </script>";
                }
            }
            else {
                echo "<script>
                        alert('Image failed to upload.');
                        window.location.href = '../pages/committee/availableTreePage.php';
                      </script>";
            }
        }
        else {
            echo "<script>
                    alert('Image failed to upload.');
                    window.location.href = '../pages/committee/availableTreePage.php';
                  </script>";
        }
    }
?>