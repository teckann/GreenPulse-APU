<?php
    include("../../backend/sessionData.php"); 
    include("../../conn.php");
    include("../../backend/utility.php");

   
     if (!isset($creatorID) || empty($creatorID)) {
        if (isset($userID)) {
            $creatorID = $userID;
        } else {
            $creatorID = 'U002'; 
        }
    }

    $moduleID = newID($conn, "modules", "M");

    if ($_SERVER["REQUEST_METHOD"] === "POST") { 
        
        if (isset($_POST["formType"]) && $_POST["formType"] === "createNewModuleWithQuiz") {
            
            $targetDir = "../../src/moduleMaterials/";

            $coverFileName = basename($_FILES['module_cover']['name']);
            $materialFileName = basename($_FILES["module_material"]["name"]);
            $videoFileName = basename($_FILES["module_video"]["name"]);
            $allowCoverType = array ('png','jpeg', 'jpg'); 
            $allowDocTypes = array('pdf');
            $allowVideoTypes = array('mp4');
            
            $uploadOk = 1;
            
            if(!empty($coverFileName) && !in_array(strtolower(pathinfo($coverFileName, PATHINFO_EXTENSION)), $allowCoverType)) {
                $uploadOk = 0;
            }
            if(!empty($materialFileName) && !in_array(strtolower(pathinfo($materialFileName, PATHINFO_EXTENSION)), $allowDocTypes)) {
                $uploadOk = 0;
            }
            if(!empty($videoFileName) && !in_array(strtolower(pathinfo($videoFileName, PATHINFO_EXTENSION)), $allowVideoTypes)) {
                $uploadOk = 0;
            }

            $coverPath = "src/moduleMaterials/" . $coverFileName; 
            $materialPath = "src/moduleMaterials/" . $materialFileName; 
            $videoPath = "src/moduleMaterials/" . $videoFileName;

            if ($uploadOk == 1) { 
                if(!empty($coverFileName)) move_uploaded_file($_FILES["module_cover"]["tmp_name"], $targetDir . $coverFileName);
                if(!empty($materialFileName)) move_uploaded_file($_FILES["module_material"]["tmp_name"], $targetDir . $materialFileName);
                if(!empty($videoFileName)) move_uploaded_file($_FILES["module_video"]["tmp_name"], $targetDir . $videoFileName);

            $coverPath = "src/moduleMaterials/" . $coverFileName; 
            $materialPath = "src/moduleMaterials/" . $materialFileName; 
            $videoPath = "src/moduleMaterials/" . $videoFileName;

            if ($uploadOk == 1) { 
                if(!empty($coverlFileName)) move_uploaded_file($_FILES["module_cover"]["tmp_name"], $targetDir . $coverlFileName);
                if(!empty($materialFileName)) move_uploaded_file($_FILES["module_material"]["tmp_name"], $targetDir . $materialFileName);
                if(!empty($videoFileName)) move_uploaded_file($_FILES["module_video"]["tmp_name"], $targetDir . $videoFileName);

                $finalModuleID = $_POST['module_id']; 
                $moduleName = mysqli_real_escape_string($conn, $_POST['module_name']);
                $moduleDesc = mysqli_real_escape_string($conn, $_POST['module_description']);

                $sqlModule = "INSERT INTO modules (
                                module_id, 
                                user_id, 
                                module_name, 
                                module_description, 
                                module_cover,
                                module_material, 
                                module_video, 
                                module_status
                            ) VALUES (
                                '$finalModuleID',
                                '$creatorID',
                                '$moduleName',
                                '$moduleDesc',
                                '$coverPath',
                                '$materialPath',
                                '$videoPath',
                                'Active'
                            )";

                if (mysqli_query($conn, $sqlModule)) {
                    addLog($conn, $creatorID, "Add New Module: $finalModuleID");

                    if (!empty($_POST['quiz_question'])) {
                        
                        $quizCount = count($_POST['quiz_question']);
                        
                        for ($i = 0; $i < $quizCount; $i++) {
                            $question = mysqli_real_escape_string($conn, $_POST['quiz_question'][$i]);
                            
                            if (!empty($question)) {
                                
                                $sqlCheckQuizID = "SELECT quiz_id FROM quiz ORDER BY quiz_id DESC LIMIT 1";
                                $resultQuizID = mysqli_query($conn, $sqlCheckQuizID);

                                if (mysqli_num_rows($resultQuizID) > 0) {
                                    $rowQuiz = mysqli_fetch_assoc($resultQuizID);
                                    $lastQuizID = $rowQuiz['quiz_id'];
                                    $lastNumber = intval(substr($lastQuizID, 1)); 
                                    $newNumber = $lastNumber + 1;
                                    $paddedNumber = str_pad($newNumber, 3, "0", STR_PAD_LEFT);
                                    $quizID = "Q" . $paddedNumber;
                                } else {
                                    $quizID = "Q001";
                                }

                                $opt1 = mysqli_real_escape_string($conn, $_POST['opt1'][$i]);
                                $opt2 = mysqli_real_escape_string($conn, $_POST['opt2'][$i]);
                                $opt3 = mysqli_real_escape_string($conn, $_POST['opt3'][$i]);
                                $opt4 = mysqli_real_escape_string($conn, $_POST['opt4'][$i]);
                                $ans = mysqli_real_escape_string($conn, $_POST['correct_answer'][$i]);
                                $pts = mysqli_real_escape_string($conn, $_POST['points'][$i]);

                                $sqlQuiz = "INSERT INTO quiz (
                                                quiz_id, 
                                                module_id, 
                                                quiz_question, 
                                                option1, 
                                                option2, 
                                                option3, 
                                                option4, 
                                                answer, 
                                                quiz_given_point
                                            ) VALUES (
                                                '$quizID',
                                                '$finalModuleID',
                                                '$question',
                                                '$opt1',
                                                '$opt2',
                                                '$opt3',
                                                '$opt4',
                                                '$ans',
                                                '$pts'
                                            )";
                                mysqli_query($conn, $sqlQuiz);
                                addLog($conn, $creatorID, "Add New Quiz: $quizID");
                            }
                        }
                    }

                    echo "<script>
                            alert('Module and Quizzes Created Successfully!'); 
                            window.location.href='studyQuizMain.php';
                          </script>";

                } else {
                    echo "Error: " . $sqlModule . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "<script>alert('Invalid file types. Allowed: PNG/JPG for Cover, PDF for Material, and MP4 for Video.'); window.history.back();</script>";
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
    <title>Create Module & Quiz</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">

</head>
<body>
    <?php include ("header.php");?>
    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        <div class="heroSection">
            <h1>CREATE MATERIAL & QUIZ</h1>
            <p>UPLOAD FILES AND ADD MULTIPLE QUESTIONS.</p>
        </div>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="formType" value="createNewModuleWithQuiz">
        <input type="hidden" name="module_id" value="<?php echo $moduleID; ?>">
                
        <section class="event-controls-event-main">
            <div class = "white-color-box">

                <span class="title">STEP 1: CREATE MATERIAL</span>
                <p class = "instruction">
                    Create your study material by entering the module details and uploading files.
                </p>
                <div class="input-group">
                    <div class = "row">
                        <label>Module Name</label>
                        <span> *</span>
                    </div>
                    <input type="text" name="module_name" placeholder="e.g. Malaysia’s Green Technology" class="event-box" required>
                </div>

                <div class="input-group">
                    <div class = "row">
                        <label>Description</label>
                        <span> *</span>
                    </div>
                    <input type="text" name="module_description" placeholder="e.g. Malaysia’s Green Technology" class="event-box" required>
                </div>

                <div class="input-group">
                    <div class = "row">
                        <label>Module Cover</label>
                        <span> *</span>
                    </div>
                    <input type="file" name="module_cover" class="event-big-box" required>
                </div>

                <div class="input-group">
                    <div class = "row">
                        <label>Study Material</label>
                        <span> *</span>
                    </div>
                    <input type="file" name="module_material" class="event-big-box" required>
                </div>

                <div class="input-group">
                    <div class = "row">
                        <label>Study Video</label>
                        <span> *</span>
                    </div>
                    <input type="file" name="module_video" class="event-big-box" required>
                </div>


                <div class = "space"></div>

                <span class="title">STEP 2: CREATE QUIZ</span>
                <p class = "instruction">
                    Click "Add Question" to link questions to this module.
                </p>

                <div id="quiz-container">
                    <div class="quiz-block">
                        <div class="remove-quiz-btn" onclick="this.parentElement.remove()">&times;</div>

                            <div class="input-group">
                                <div class = "row">
                                    <label>Question</label>
                                    <span> *</span>
                                </div>
                                <input type="text" name="quiz_question[]" class="event-box" placeholder="Enter question..." required>
                            </div>
                        
                        
                        <div class = "two-column">
                            <div class="input-group">
                                <div class = "row">
                                    <label>Option 1</label>
                                    <span> *</span>
                                </div>
                                <div class="input-group"><input type="text" name="opt1[]" class="event-box" placeholder="Option 1" required></div>
                            </div>

                            <div class="input-group">
                                <div class = "row">
                                    <label>Option 2</label>
                                    <span> *</span>
                                </div>
                                <div class="input-group"><input type="text" name="opt2[]" class="event-box" placeholder="Option 2" required></div>
                            </div>
                        </div>

                        <div class = "two-column">
                            <div class="input-group">
                                <div class = "row">
                                    <label>Option 3</label>
                                    <span> *</span>
                                </div>
                                <div class="input-group"><input type="text" name="opt3[]" class="event-box" placeholder="Option 3" required></div>
                            </div>

                            <div class="input-group">
                                <div class = "row">
                                    <label>Option 4</label>
                                    <span> *</span>
                                </div>
                                <div class="input-group"><input type="text" name="opt4[]" class="event-box" placeholder="Option 4" required></div>
                            </div>
                        </div>

                        <div class = "two-column">
                            <div class="input-group">
                                <div class = "row">
                                    <label>Correct Answer</label>
                                    <span> *</span>
                                </div>
                                <select name="correct_answer[]" class="event-box">
                                    <option value="option 1">option 1</option>
                                    <option value="option 2">option 2</option>
                                    <option value="option 3">option 3</option>
                                    <option value="option 4">option 4</option>
                                </select>
                            </div>

                <div class="input-group">
                    <div class = "row">
                        <label>Points</label>
                        <span> *</span>
                    </div>
                    <input type="number" name="points[]" class="event-box" placeholder="e.g. 10" required>
                </div>
            </div>  
    </div> 
</div>  
            

                <button type="button" class="btn-more-question word-color" onclick="addQuizBlock()">
                        Add Question
                </button>

                
                <button type="submit" class="btn-create-event">
                        Create Module & Quizzes
                </button>
            

                <div class = "short-tagline">
                    Create. Inspire. Impact.
                </div>

            </div>
        </section>
    </form>

    <script>
        function addQuizBlock() {
            const container = document.getElementById('quiz-container');
            const html = `
                <div class="quiz-block" style="animation: fadeIn 0.5s;">
                    <div class="remove-quiz-btn" onclick="this.parentElement.remove()">&times;</div>

                        <div class="input-group">
                            <div class = "row">
                                <label>Question</label>
                                <span> *</span>
                            </div>
                            <input type="text" name="quiz_question[]" class="event-box" placeholder="Enter question..." required>
                        </div>
                        
                        <div class = "two-column">
                            <div class="input-group">
                                <div class = "row">
                                    <label>Option 1</label>
                                    <span> *</span>
                                </div>
                                <div class="input-group"><input type="text" name="opt1[]" class="event-box" placeholder="Option 1" required></div>
                            </div>

                            <div class="input-group">
                                <div class = "row">
                                    <label>Option 2</label>
                                    <span> *</span>
                                </div>
                                <div class="input-group"><input type="text" name="opt2[]" class="event-box" placeholder="Option 2" required></div>
                            </div>
                        </div>

                        <div class = "two-column">
                            <div class="input-group">
                                <div class = "row">
                                    <label>Option 3</label>
                                    <span> *</span>
                                </div>
                                <div class="input-group"><input type="text" name="opt3[]" class="event-box" placeholder="Option 3" required></div>
                            </div>

                            <div class="input-group">
                                <div class = "row">
                                    <label>Option 4</label>
                                    <span> *</span>
                                </div>
                                <div class="input-group"><input type="text" name="opt4[]" class="event-box" placeholder="Option 4" required></div>
                            </div>
                        </div>

                        <div class = "two-column">
                            <div class="input-group">
                                <div class = "row">
                                    <label>Correct Answer</label>
                                    <span> *</span>
                                </div>
                                <select name="correct_answer[]" class="event-box">
                                    <option value="option 1">option 1</option>
                                    <option value="option 2">option 2</option>
                                    <option value="option 3">option 3</option>
                                    <option value="option 4">option 4</option>
                                </select>
                            </div>

                            <div class="input-group">
                                <div class = "row">
                                    <label>Points</label>
                                    <span> *</span>
                                </div>
                                <input type="number" name="points[]" class="event-box" placeholder="e.g. 10" required>
                            </div>
                        </div>     
            
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }
    </script>
    <?php include ("hamburgerMenu.php");?>
</body>
</html>