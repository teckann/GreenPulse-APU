<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") { 
        
      
        if (isset($_POST["formType"]) && $_POST["formType"] === "createNewMaterial") {
            $targetDir = "../../src/moduleMaterials/";
            
            // Handle Material File
            $materialFileName = basename($_FILES["study_material"]["name"]);
            $materialTargetFilePath = $targetDir . $materialFileName;
            $materialFileType = pathinfo($materialTargetFilePath, PATHINFO_EXTENSION);

            // Handle Video File 
            $videoFileName = basename($_FILES["study_video"]["name"]);
            $videoTargetFilePath = $targetDir . $videoFileName;
            $videoFileType = pathinfo($videoTargetFilePath, PATHINFO_EXTENSION);

            $allowDocTypes = array('pdf', 'png'); // CHANGE THIS [PNG] JUST FOR TESTING
            $allowVideoTypes = array('mp4');

            // Validation & Upload Logic
            $uploadOk = 1;

            // Check Material
            if(!in_array(strtolower($materialFileType), $allowDocTypes)){
                echo "<script>alert('Invalid Material file type (PDF/Images only).');</script>";
                $uploadOk = 0;
            }
            
            // Check Video
            if(!in_array(strtolower($videoFileType), $allowVideoTypes)){
                echo "<script>alert('Invalid Video file type (mp4 only).');</script>";
                $uploadOk = 0;
            }

            // If checks pass, move files and Insert DB
            if ($uploadOk == 1) {
                
                // Move Material
                if (move_uploaded_file($_FILES["study_material"]["tmp_name"], $materialTargetFilePath) && 
                    move_uploaded_file($_FILES["study_video"]["tmp_name"], $videoTargetFilePath)) {
                    
                    // File Paths to save in DB (Relative to root)
                    $materialPath = "src/moduleMaterials/" . $materialFileName; 
                    $videoPath = "src/moduleMaterials/" . $videoFileName;

                    // 6. Sanitize Inputs
                    $moduleName = mysqli_real_escape_string($conn, $_POST['module_name']);
                    $moduleDesc = mysqli_real_escape_string($conn, $_POST['module_description']);
                    
                    // 7. Generate Required Data (ID, User, Status)
                    $moduleID = "M" . rand(1000, 9999); // Simple ID generation
                    $creatorID = isset($userID) ? $userID : $_SESSION['user_id'];
                    $status = "Active";

                    // 8. SQL Insert (Matching your SQL Schema)
                    $sql = "INSERT INTO modules (
                                module_id, 
                                user_id,
                                module_name, 
                                module_description, 
                                module_material, 
                                module_video, 
                                module_status
                            ) VALUES (
                                '$moduleID',
                                '$creatorID',
                                '$moduleName',
                                '$moduleDesc',
                                '$materialPath',
                                '$videoPath',
                                '$status'
                            )";

                    if (mysqli_query($conn, $sql)) {
                        echo "<script>
                                alert('Module Created Successfully!'); 
                                window.location.href='studyQuizMain.php';
                              </script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

                } else {
                    echo "<script>alert('Error moving files to server. Check permissions.');</script>";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study & Quiz Create Material</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include ("header.php");?>
    
    <!-- Upper Part -->
    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>CREATE MATERIAL</h1>
            <p>UPLOAD STUDY MATERIALS AND VIDEOS.</p>
        </div>
    </div>

    <!-- FORM START -->
    <form action="#" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="formType" value="createNewMaterial">
                
        <section class="event-controls-event-main">
            <div class = "white-color-box">

            <div class = "study-quiz-module-name-box">
                <div class = "study-quiz-title">Module Name</div>
                <input type="text" name="module_name" placeholder="Module Name" class="event-box" required>
            </div>

            <div class = "study-quiz-description-box">
                <div class = "study-quiz-title">Description</div>
                <input type="text" name="module_description" placeholder="Module Description" class="event-box" required>
            </div>

            <div class = "study-quiz-module-upload">
                <div class = "study-quiz-title">Study Material (PDF/Image)</div>
                <input type="file" name="study_material" class="event-big-box" required>
            </div>

            <div class = "study-quiz-module-upload">
                <div class = "study-quiz-title">Study Video (MP4)</div>
                <input type="file" name="study_video" class="event-big-box" required>
            </div>

            
            <button type="submit" class="btnCreateEvent">
                Save Material
            </button>

            <!-- If you want a button to go to next page without saving, use this: -->
            <!-- <button type="button" onclick="window.location.href='studyQuizCreateQuiz.php'">Create Quiz</button> -->

            <div class = "short-tagline">
                Create. Inspire. Impact.
            </div>

            </div>
        </section>
    </form>

    <?php include ("hamburgerMenu.php");?>
</body>
</html>