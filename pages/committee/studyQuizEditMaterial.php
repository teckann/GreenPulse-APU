<?php
    include("../../backend/sessionData.php"); 
    include("../../conn.php");
    include("../../backend/utility.php");
    $module_id = isset($_GET['module_id']) ? $_GET['module_id'] : null;

    if (!$module_id) {
        echo "<script>alert('Module ID missing.'); window.history.back();</script>";
        exit;
    }

    $sql = "SELECT * FROM modules WHERE module_id = '$module_id'";
    $result = mysqli_query($conn, $sql);
    $moduleData = mysqli_fetch_assoc($result);

    if (!$moduleData) {
        echo "<script>alert('Module not found.'); window.history.back();</script>";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $targetDir = "../../src/moduleMaterials/";
        // module name and description
        $moduleName = mysqli_real_escape_string($conn, $_POST['module_name']);
        $moduleDesc = mysqli_real_escape_string($conn, $_POST['module_description']);

        // module cover
        if (!empty($_FILES['module_cover']['name'])) {
            $coverFileName = basename($_FILES['module_cover']['name']);
            $allowCoverType = array ('png','jpeg', 'jpg'); 
            $ext = strtolower(pathinfo($coverFileName, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowCoverType)) {
                move_uploaded_file($_FILES['module_cover']['tmp_name'], $targetDir . $coverFileName);
                $coverPath = "src/moduleMaterials/" . $coverFileName;
            } else {
                $coverPath = $moduleData['module_cover'];
            }
        } else {
            $coverPath = $moduleData['module_cover']; 
        }

        // module material
        if (!empty($_FILES['module_material']['name'])) {
            $materialFileName = basename($_FILES['module_material']['name']);
            if (strtolower(pathinfo($materialFileName, PATHINFO_EXTENSION)) === 'pdf') {
                move_uploaded_file($_FILES['module_material']['tmp_name'], $targetDir . $materialFileName);
                $materialPath = "src/moduleMaterials/" . $materialFileName;
            } else {
                $materialPath = $moduleData['module_material'];
            }
        } else {
            $materialPath = $moduleData['module_material'];
        }

        // module video
        if (!empty($_FILES['module_video']['name'])) {
            $videoFileName = basename($_FILES['module_video']['name']);
            if (strtolower(pathinfo($videoFileName, PATHINFO_EXTENSION)) === 'mp4') {
                move_uploaded_file($_FILES['module_video']['tmp_name'], $targetDir . $videoFileName);
                $videoPath = "src/moduleMaterials/" . $videoFileName;
            } else {
                $videoPath = $moduleData['module_video'];
            }
        } else {
            $videoPath = $moduleData['module_video'];
        }

        $sqlUpdate = "UPDATE modules SET 
                        module_name = '$moduleName',
                        module_description = '$moduleDesc',
                        module_cover = '$coverPath',
                        module_material = '$materialPath',
                        module_video = '$videoPath'
                      WHERE module_id = '$module_id'";

        if (mysqli_query($conn, $sqlUpdate)) {
            addLog($conn, $_SESSION['userID'], "Update Module Information: $module_id");
            echo "<script>alert('Material Updated Successfully!'); window.location.href='studyQuizMain.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Study Material</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
   <?php include ("header.php");?>
    
    <div class="header-content">
        <div class="back-icon" onclick="window.location.href='studyQuizMain.php'">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>EDIT MATERIAL</h1>
            <p>UPDATE MODULE DETAILS AND FILES.</p>
        </div>
    </div>

    <section class="event-controls-event-main">
        <div class="white-color-box">
            <form action="" method="POST" enctype="multipart/form-data">
                
                <div class="input-group">
                    <div class="row">
                        <label>Module Name</label>
                        <span> *</span>
                    </div>
                    <input type="text" name="module_name" value="<?php echo $moduleData['module_name']; ?>" class="event-box" required>
                </div>

                <div class="input-group">
                    <div class="row">
                        <label>Description</label>
                        <span> *</span>
                    </div>
                    <textarea name="module_description" class="event-big-box" rows="5" required><?php echo $moduleData['module_description']; ?></textarea>
                </div>

                <div class="input-group">
                    <div class="row">
                        <label>Current Cover</label>
                    </div>
                    <?php if(!empty($moduleData['module_cover'])): ?>
                        <img src="../../<?php echo $moduleData['module_cover']; ?>">
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <div class="row">
                        <label>Update Cover (Optional)</label>
                    </div>
                    <input type="file" name="module_cover" class="event-big-box">
                </div>

                <div class="input-group">
                    <div class="row">
                        <label>Current Material</label>
                    </div>
                    <small><?php echo $moduleData['module_material']; ?></small>
                </div>

                <div class="input-group">
                    <div class="row">
                        <label>Update Study Material (PDF)</label>
                    </div>
                    <input type="file" name="module_material" class="event-big-box">
                </div>

                <div class="input-group">
                    <div class="row">
                        <label>Current Video</label>
                    </div>
                    <small><?php echo $moduleData['module_video']; ?></small>
                </div>

                <div class="input-group">
                    <div class="row">
                        <label>Update Study Video (MP4)</label>
                    </div>
                    <input type="file" name="module_video" class="event-big-box">
                </div>

                <div class="space"></div>

                <button type="submit" class="btn-create-event">
                    Save Changes
                </button>
                <div class = "space"></div>
                <div class = "short-tagline">
                    Create. Inspire. Impact.
                </div>
            </form>
        </div>
    </section>
    <?php include ("hamburgerMenu.php");?>
</body>
</html>