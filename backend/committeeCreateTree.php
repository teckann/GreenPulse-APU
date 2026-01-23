<?php
    include("../conn.php");
    include("sessionData.php");
    include("utility.php");
    
    if (isset($_POST["btnCreateTree"])) {
        $itemID = newID($conn, "items", "I");
        $itemName = $_POST["createItemName"];
        $requiredPoints = $_POST["createItemPoints"];
        // define default photo first to prevent the committee cannot upload photo duccessfully
        // $defaultItemImage = "src/itemImages/default_tree.png";
        $postedDate = date("Y-m-d");
        $itemStock = $_POST["createItemStock"];
        $description = $_POST["createItemDescription"];
        $file = $_FILES["createItemPhoto"];

        // create data
        // $sqlCreateData = "INSERT INTO items (item_id, user_id, item_name, item_image, item_description,
        // item_redeem_points, item_stock, category, posted_date, item_status) VALUES 
        // ('$itemID', '$userID', '$itemName', '$defaultItemImage', '$description', '$requiredPoints', '$itemStock', 'tree', '$postedDate', 'Active')";

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
                    alert('Create new tree failed, please create again.');
                    window.location.href = '../pages/committee/availableTreePage.php';
                </script>";
        }

        if ($fileSize > 5000000) {
            $uploadOk = 0;

            echo "<script>
                    alert('Maximum file size is 5 MB only.')
                    alert('Create new tree failed, please create again.');
                    window.location.href = '../pages/committee/availableTreePage.php';
                </script>";
        }

        if (!in_array($imageFileType, $allowFormat)) {
            $uploadOk = 0;
            echo "<script>
                    alert('System only support png, jpg, and jpeg image format.');
                    alert('Create new tree failed, please create again.');
                    window.location.href = '../pages/committee/availableTreePage.php';
                </script>";
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($fileTmpName, $target_file)) {

                $databasePath = "src/itemImages/" . $newFileName;

                $sqlCreateData = "INSERT INTO items (item_id, user_id, item_name, item_image, item_description,
                item_redeem_points, item_stock, category, posted_date, item_status) VALUES 
                ('$itemID', '$userID', '$itemName', '$databasePath', '$description', '$requiredPoints', '$itemStock', 'tree', '$postedDate', 'Active')";
                
                if (mysqli_query($conn, $sqlCreateData)) {
                    echo "<script>
                            alert('The tree created successfully');
                            window.location.href = '../pages/committee/availableTreePage.php';
                        </script>";
                    
                    addLog($conn, $userID, "Create New Tree ($itemID)");
                }
            }
            else {
                echo "<script>
                        alert('Create new tree failed, please create again.');
                        window.location.href = '../pages/committee/availableTreePage.php';
                    </script>";
            }
        }
        else {
            echo "<script>
                    alert('Image failed to upload.');
                    alert('Create new tree failed, please create again.');
                    window.location.href = '../pages/committee/availableTreePage.php';
                </script>";
        }
    }
    else {
        echo "<script>
            alert('The tree is not created successfully.');
        </script>";
    }
?>