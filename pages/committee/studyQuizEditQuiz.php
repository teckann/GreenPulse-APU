<?php
    include("../../backend/sessionData.php"); 
    include("../../conn.php");
    include("../../backend/utility.php");

    $module_id = isset($_GET['module_id']) ? $_GET['module_id'] : null;
    
    if (!$module_id) {
        echo "<script>alert('Module ID missing.'); window.history.back();</script>";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $quiz_id = $_POST['quiz_id'];
        $question = mysqli_real_escape_string($conn, $_POST['quiz_question']);
        $opt1 = mysqli_real_escape_string($conn, $_POST['opt1']);
        $opt2 = mysqli_real_escape_string($conn, $_POST['opt2']);
        $opt3 = mysqli_real_escape_string($conn, $_POST['opt3']);
        $opt4 = mysqli_real_escape_string($conn, $_POST['opt4']);
        $ans = mysqli_real_escape_string($conn, $_POST['correct_answer']);
        $pts = mysqli_real_escape_string($conn, $_POST['points']);

        $sqlUpdate = "UPDATE quiz SET 
                        quiz_question = '$question',
                        option1 = '$opt1',
                        option2 = '$opt2',
                        option3 = '$opt3',
                        option4 = '$opt4',
                        answer = '$ans',
                        quiz_given_point = '$pts'
                      WHERE quiz_id = '$quiz_id'";

        if (mysqli_query($conn, $sqlUpdate)) {
            echo "<script>alert('Question Updated!'); window.location.href='studyQuizEditQuiz.php?module_id=$module_id&selected_quiz_id=$quiz_id';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    $sqlQuestions = "SELECT * FROM quiz WHERE module_id = '$module_id'";
    $resultQuestions = mysqli_query($conn, $sqlQuestions);
    $questionsList = [];

    while($row = mysqli_fetch_assoc($resultQuestions)) {
        $questionsList[] = $row;
    }

    // show the question to display
    $selectedQuizId = isset($_POST['quiz_id']) ? $_POST['quiz_id'] : (isset($_GET['selected_quiz_id']) ? $_GET['selected_quiz_id'] : '');
    
    if (empty($selectedQuizId) && !empty($questionsList)) {
        $selectedQuizId = $questionsList[0]['quiz_id'];
    }

    
    $currentQuestion = null;
    foreach($questionsList as $q) {
        if ($q['quiz_id'] === $selectedQuizId) {
            $currentQuestion = $q;
            break;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quiz Questions</title>
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
            <h1>EDIT QUIZ QUESTIONS</h1>
            <p>SELECT AND MODIFY QUESTIONS.</p>
        </div>
    </div>


    <section class="event-controls-event-main">
        <div class="white-color-box">
            
            <form action="#" method="POST">
                <div class="input-group">
                    <div class="row">
                        <label>Select Question to Edit</label>
                    </div>
                    <select id="questionDropdown" name="quiz_selector" class="event-box" onchange="changeQuestion()">
                        <?php foreach($questionsList as $q): ?>
                            <option value="<?php echo $q['quiz_id']; ?>" 
                                <?php echo ($currentQuestion && $currentQuestion['quiz_id'] == $q['quiz_id']) ? 'selected' : ''; ?>>
                                <?php echo $q['quiz_question']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if($currentQuestion): ?>
                    <input type="hidden" name="quiz_id" value="<?php echo $currentQuestion['quiz_id']; ?>">

                    <div class="input-group">
                        <div class="row">
                            <label>Quiz Question</label>
                            <span> *</span>
                        </div>
                        <input type="text" name="quiz_question" value="<?php echo $currentQuestion['quiz_question']; ?>" class="event-box" required>
                    </div>

                    <div class="two-column">
                        <div class="input-group">
                            <div class="row"><label>Option 1</label></div>
                            <input type="text" name="opt1" value="<?php echo $currentQuestion['option1']; ?>" class="event-box" required>
                        </div>

                        <div class="input-group">
                            <div class="row"><label>Option 2</label></div>
                            <input type="text" name="opt2" value="<?php echo $currentQuestion['option2']; ?>" class="event-box" required>
                        </div>
                    </div>

                    <div class="two-column">
                        <div class="input-group">
                            <div class="row"><label>Option 3</label></div>
                            <input type="text" name="opt3" value="<?php echo $currentQuestion['option3']; ?>" class="event-box" required>
                        </div>

                        <div class="input-group">
                            <div class="row"><label>Option 4</label></div>
                            <input type="text" name="opt4" value="<?php echo $currentQuestion['option4']; ?>" class="event-box" required>
                        </div>
                    </div>

                    <div class="two-column">
                        <div class="input-group">
                            <div class="row"><label>Correct Answer</label></div>
                            <select name="correct_answer" class="event-box">
                                <option value="Option 1" <?php echo ($currentQuestion['answer'] == 'Option 1') ? 'selected' : ''; ?>>Option 1</option>
                                <option value="Option 2" <?php echo ($currentQuestion['answer'] == 'Option 2') ? 'selected' : ''; ?>>Option 2</option>
                                <option value="Option 3" <?php echo ($currentQuestion['answer'] == 'Option 3') ? 'selected' : ''; ?>>Option 3</option>
                                <option value="Option 4" <?php echo ($currentQuestion['answer'] == 'Option 4') ? 'selected' : ''; ?>>Option 4</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <div class="row"><label>Points Given</label></div>
                            <input type="number" name="points" value="<?php echo $currentQuestion['quiz_given_point']; ?>" class="event-box" required>
                        </div>
                    </div>

                    <div class="space"></div>

                    <button type="submit" class="btn-create-event">
                        Save Changes to Question
                    </button>
                <?php else: ?>
                    <p>No questions found for this module.</p>
                <?php endif; ?>
                <div class = "space"></div>
                <div class = "short-tagline">
                    Create. Inspire. Impact.
                </div>
            </form>
        </div>
    </section>
    <?php include ("hamburgerMenu.php");?>
    <script>
        function changeQuestion() {
            var select = document.getElementById("questionDropdown");
            var quizId = select.options[select.selectedIndex].value;
            window.location.href = "?module_id=<?php echo $module_id; ?>&selected_quiz_id=" + quizId;
        }
    </script>
</body>
</html>