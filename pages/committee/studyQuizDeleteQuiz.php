<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    if (!isset($_GET['module_id'])) {
        echo "<script>alert('No module selected!'); window.location.href='studyQuizMain.php';</script>";
        exit;
    }

    $moduleID = mysqli_real_escape_string($conn, $_GET['module_id']);

    $sqlModule = "SELECT * FROM modules WHERE module_id = '$moduleID'";
    $resultModule = mysqli_query($conn, $sqlModule);

    if (mysqli_num_rows($resultModule) <= 0) {
        echo "<script>alert('Module not found!'); window.location.href='studyQuizMain.php';</script>";
        exit;
    }

    $moduleData = mysqli_fetch_assoc($resultModule);

    if ($moduleData['user_id'] != $_SESSION['userID']) {
        echo "<script>alert('You do not have permission to delete these quizzes!'); window.location.href='studyQuizModule.php?module_id=$moduleID';</script>";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_confirm'])) {
        if (!empty($_POST['quiz_to_delete'])) {
            $idsToDelete = $_POST['quiz_to_delete'];

            $idsString = "'" . implode("','", $idsToDelete) . "'";

            $sqlUpdate = "UPDATE quiz SET quiz_status = 'Inactive' WHERE quiz_id IN ($idsString)";

            if (mysqli_query($conn, $sqlUpdate)) {
                addLog($conn, $_SESSION['userID'], "Delete Quiz: $moduleID");
                echo "<script>alert('Selected questions deleted successfully!'); window.location.href='studyQuizModule.php?module_id=$moduleID';</script>";
            } else {
                echo "<script>alert('Error deleting questions!'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Please select at least one question to delete.'); window.history.back();</script>";
        }
        exit;
    }

    $sqlQuiz = "SELECT * FROM quiz WHERE module_id = '$moduleID' AND quiz_status = 'Active' ORDER BY quiz_id ASC";
    $resultQuiz = mysqli_query($conn, $sqlQuiz);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Quiz Questions</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
    
</head>
<body>
    <?php include ("header.php");?>

    <div class="header-content">
        <div class="back-icon" onclick="window.location.href='studyQuizModule.php?module_id=<?php echo $moduleID; ?>'">
            <i class="fas fa-arrow-left"></i>
        </div>
        <div class="heroSection">
            <h1>DELETE QUIZZES</h1>
            <p><?php echo $moduleData['module_name']; ?></p>
        </div>
    </div>

    <section class="event-controls-event-main">
        <div class = "white-color-box">
            
            <span class="title">SELECT QUESTIONS TO DELETE</span>
            <p class = "instruction">
                Check the box next to the questions you want to remove. 
                This will set their status to Inactive.
            </p>

            <?php if (mysqli_num_rows($resultQuiz) > 0): ?>
                
                <form method="POST" action="studyQuizDeleteQuiz.php?module_id=<?php echo $moduleID; ?>">
                    
                    <div class="quiz-list-container">
                        <?php 
                            while ($quizRow = mysqli_fetch_assoc($resultQuiz)) {
                                $qid = $quizRow['quiz_id'];
                                $qText = ($quizRow['quiz_question']);
                                $pts = $quizRow['quiz_given_point'];
                        ?>
                        <label class="delete-selection-item">
                            <input type="checkbox" name="quiz_to_delete[]" value="<?php echo $qid; ?>" class="delete-checkbox">
                            <div class="question-preview">
                                <strong>ID: <?php echo $qid; ?></strong> - <?php echo $qText; ?>
                                <span class="badge-points"><?php echo $pts; ?> pts</span>
                            </div>
                        </label>
                        <?php 
                            } 
                        ?>
                    </div>

                    <div class="btn-group-actions">
                        <button type="submit" name="delete_confirm" class="btn-create-event" style="background-color: #dc3545;">
                            Delete Selected Questions
                        </button>
                    </div>

                </form>

            <?php else: ?>
                <div style="text-align:center; padding: 40px;">
                    <i class="fas fa-check-circle"></i>
                    <h3>All Clear!</h3>
                    <p>There are no active questions in this module to delete.</p>
                    <button onclick="window.location.href='studyQuizModule.php?module_id=<?php echo $moduleID; ?>'" class="btn-create-event">Back to Module</button>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <?php include ("hamburgerMenu.php");?>
</body>
</html>