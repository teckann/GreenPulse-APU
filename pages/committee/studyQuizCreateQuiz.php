<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    // --- 1. 预先生成 Module ID (为了后面关联 Quiz) ---
    $moduleID = "M" . rand(10000, 99999); 
    $creatorID = isset($userID) ? $userID : $_SESSION['user_id'];

    // --- 2. 处理表单提交 ---
    if ($_SERVER["REQUEST_METHOD"] === "POST") { 
        
        if (isset($_POST["formType"]) && $_POST["formType"] === "createNewModuleWithQuiz") {
            
            $targetDir = "../../src/moduleMaterials/";
            
            // A. 处理文件上传 (Material + Video)
            $materialFileName = basename($_FILES["study_material"]["name"]);
            $videoFileName = basename($_FILES["study_video"]["name"]);
            
            // ... (验证和移动文件的逻辑同上，这里简化展示核心逻辑) ...
            $allowDocTypes = array('pdf','png','jpg');
            $allowVideoTypes = array('mp4');
            
            $uploadOk = 1;
            if(!in_array(strtolower(pathinfo($materialFileName, PATHINFO_EXTENSION)), $allowDocTypes)) $uploadOk = 0;
            if(!in_array(strtolower(pathinfo($videoFileName, PATHINFO_EXTENSION)), $allowVideoTypes)) $uploadOk = 0;

            // 生成文件路径字符串
            $materialPath = "src/moduleMaterials/" . $materialFileName; 
            $videoPath = "src/moduleMaterials/" . $videoFileName;

            if ($uploadOk == 1) {
                // 移动文件
                move_uploaded_file($_FILES["study_material"]["tmp_name"], $targetDir . $materialFileName);
                move_uploaded_file($_FILES["study_video"]["tmp_name"], $targetDir . $videoFileName);

                // 获取提交上来的 Module ID (如果是POST回来的)
                $finalModuleID = $_POST['module_id']; 
                $moduleName = mysqli_real_escape_string($conn, $_POST['module_name']);
                $moduleDesc = mysqli_real_escape_string($conn, $_POST['module_description']);

                // B. 插入 Module 数据
                $sqlModule = "INSERT INTO modules (
                                module_id, 
                                user_id, 
                                module_name, 
                                module_description, 
                                module_material, 
                                module_video, 
                                module_status
                            ) VALUES (
                                '$finalModuleID',
                                '$creatorID',
                                '$moduleName',
                                '$moduleDesc',
                                '$materialPath',
                                '$videoPath',
                                'Active'
                            )";

                if (mysqli_query($conn, $sqlModule)) {
                    
                    // C. 插入 Quiz 数据 (循环处理)
                    // 检查是否有提交 Quiz 数据
                    if (!empty($_POST['quiz_question'])) {
                        
                        $quizCount = count($_POST['quiz_question']);
                        
                        for ($i = 0; $i < $quizCount; $i++) {
                            // 如果问题不为空才插入
                            $question = mysqli_real_escape_string($conn, $_POST['quiz_question'][$i]);
                            
                            if (!empty($question)) {
                                $quizID = "Q" . rand(10000, 99999);
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
</head>
<body>
    <?php include ("header.php");?>
    <!-- Upper Part -->
    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        <div class="heroSection">
            <h1>CREATE MATERIAL & QUIZ</h1>
            <p>UPLOAD FILES AND ADD MULTIPLE QUESTIONS.</p>
        </div>
    </div>

    <!-- FORM START -->
    <form action="#" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="formType" value="createNewModuleWithQuiz">
        
        <!-- 关键点：隐藏的 Module ID，让 PHP 知道题目属于哪个模块 -->
        <input type="hidden" name="module_id" value="<?php echo $moduleID; ?>">
                
        <section class="event-controls-event-main">
            <div class = "white-color-box">

                <!-- PART 1: MATERIAL INFO -->
                <h3>1. Module Details</h3>
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

                <div class = "space"></div>

                <!-- PART 2: QUIZ SECTION -->
                <h3>2. Quiz Questions</h3>
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 10px;">
                    Click "Add Question" to link questions to this module.
                </p>

                <!-- 动态题目容器 -->
                <div id="quiz-container">
                    <!-- 默认先加一个，方便用户输入 -->
                    <div class="quiz-block">
                        <div class="remove-quiz-btn" onclick="this.parentElement.remove()">&times;</div>
                        
                        <div class="input-group">
                            <label>Question</label>
                            <input type="text" name="quiz_question[]" class="event-box" placeholder="Enter question..." required>
                        </div>

                        <div class="two-columns">
                            <div class="input-group"><input type="text" name="opt1[]" class="event-box" placeholder="Option 1" required></div>
                            <div class="input-group"><input type="text" name="opt2[]" class="event-box" placeholder="Option 2" required></div>
                        </div>
                        <div class="two-columns">
                            <div class="input-group"><input type="text" name="opt3[]" class="event-box" placeholder="Option 3" required></div>
                            <div class="input-group"><input type="text" name="opt4[]" class="event-box" placeholder="Option 4" required></div>
                        </div>

                        <div class="two-columns">
                            <div class="input-group">
                                <label>Correct Answer</label>
                                <select name="correct_answer[]" class="event-box">
                                    <option value="Option 1">Option 1</option>
                                    <option value="Option 2">Option 2</option>
                                    <option value="Option 3">Option 3</option>
                                    <option value="Option 4">Option 4</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label>Points</label>
                                <input type="number" name="points[]" class="event-box" placeholder="e.g. 10" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Button -->
                <button type="button" class="btnCreateEvent" onclick="addQuizBlock()" style="background-color: #4CAF50; margin-top: 10px;">
                    <i class="fas fa-plus"></i> Add Question
                </button>

                <div class = "space"></div>

                <!-- Submit Button -->
                <button type="submit" class="btnCreateEvent">
                    Create Module & Quizzes
                </button>

                <div class = "short-tagline">
                    Create. Inspire. Impact.
                </div>

            </div>
        </section>
    </form>

    <script>
     // --- 核心逻辑：动态添加题目 ---
        function addQuizBlock() {
            const container = document.getElementById('quiz-container');
            
            // 生成题目块的 HTML 模板
            // 注意 name 属性必须带 [] 才能以数组形式提交给 PHP
            const html = `
                <div class="quiz-block" style="animation: fadeIn 0.5s;">
                    <div class="remove-quiz-btn" onclick="this.parentElement.remove()">&times;</div> 
                    
                    <div class="input-group">
                        <label>Question</label>
                        <input type="text" name="quiz_question[]" class="event-box" placeholder="Enter question..." required>
                    </div>

                    <div class="two-columns">
                        <div class="input-group"><input type="text" name="opt1[]" class="event-box" placeholder="Option 1" required></div>
                        <div class="input-group"><input type="text" name="opt2[]" class="event-box" placeholder="Option 2" required></div>
                    </div>
                    <div class="two-columns">
                        <div class="input-group"><input type="text" name="opt3[]" class="event-box" placeholder="Option 3" required></div>
                        <div class="input-group"><input type="text" name="opt4[]" class="event-box" placeholder="Option 4" required></div>
                    </div>

                    <div class="two-columns">
                        <div class="input-group">
                            <label>Correct Answer</label>
                            <select name="correct_answer[]" class="event-box">
                                <option value="Option 1">Option 1</option>
                                <option value="Option 2">Option 2</option>
                                <option value="Option 3">Option 3</option>
                                <option value="Option 4">Option 4</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Points</label>
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