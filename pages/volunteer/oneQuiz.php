<?php

    include("../../conn.php");

    include("../../backend/sessionData.php");

    include("../../backend/utility.php");

    $userID = $_SESSION["userID"];

    
    $moduleTitle = '';




    if(isset($_POST["submitQuizAnswer"])){
        $module_id = $_POST["submitQuizAnswer"];

        $sql_point_answer = "SELECT * FROM quiz WHERE module_id = '$module_id';";

        $qna = mysqli_query($conn, $sql_point_answer);


        $totalPoint = 0;

        $totalQuiz = 0;
        $totalCorrectQuiz = 0;

        while($question = mysqli_fetch_assoc($qna)){
            $questionId = $question['quiz_id'];
            $totalQuiz++;

            if (isset($_POST[$questionId])){
                $userAnswer = $_POST[$questionId];

                if($userAnswer == $question['answer']){
                    $totalPoint += $question['quiz_given_point'];
                    $totalCorrectQuiz++;

                }
            }
        }

        $sql_attempt_times = "SELECT * FROM module_history
                                WHERE user_id = '$userID'
                                AND module_id = '$module_id'";

        $answeredRecord = mysqli_fetch_assoc(mysqli_query($conn, $sql_attempt_times));

        

        if(!$answeredRecord){

            

            $sql_insert_record = "INSERT INTO module_history 
                                    (module_id, user_id, highest_score, awarded_points, total_attempt, finish_datetime) 
                                    VALUES 
                                    ('$module_id', '$userID', '$totalCorrectQuiz', '$totalPoint', 1, NOW());";

            mysqli_query($conn, $sql_insert_record);

            $moduleLogID = newID($conn, "log", "L");

            $sql_module_log = "INSERT INTO log
                                    (log_id, user_id, log_event, log_datetime)
                                    VALUES
                                    ($moduleLogID, '$userID', 'Answered module $module_id', NOW());";

            mysqli_query($conn, $sql_module_log);

            

            if ($totalPoint > 0){
                $sql_add_point = "UPDATE users SET 
                                    green_points = green_points + $totalPoint, 
                                    total_earned = total_earned + $totalPoint 
                                    WHERE user_id = '$userID';";

                mysqli_query($conn, $sql_add_point);
            }

            $alert = 'Quiz Completed! You earned '.$totalPoint.' Green Points 🎉';
        }else {

            $addedAttempt = $answeredRecord['total_attempt'] + 1;


            $lastHighest = $answeredRecord['highest_score'];

            $newHighest = ($totalCorrectQuiz > $lastHighest) ? $totalCorrectQuiz : $lastHighest;

            $toUpdateHighest = $newHighest;

            $sql_update_highest = "UPDATE module_history SET 
                                    total_attempt = '$addedAttempt', 
                                    highest_score = '$toUpdateHighest', 
                                    finish_datetime = NOW() 
                                    WHERE user_id = '$userID' AND module_id = '$module_id';";

            mysqli_query($conn, $sql_update_highest);

            $alert = 'Re-Attempt Completed you got '.$totalCorrectQuiz.' correct! New Score: '.$toUpdateHighest.'.';

        }

            echo '<script>
                    document.addEventListener("DOMContentLoaded",() =>{
                    alert("'.$alert.'");
                    
                    let form = document.createElement("form");
                    form.method = "POST";
                    form.action = "oneModule.php";
                    
                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "oneModule";
                    input.value = "'.$module_id.'";
                    
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();

                    })
                </script>';

            exit();

        
    }else if(isset($_POST["answerQuiz"])){

        $module_id = $_POST['answerQuiz'];

        $sql_module = "SELECT * FROM modules 
                        WHERE module_id = '$module_id'";

        $chosenModule = mysqli_fetch_assoc(mysqli_query($conn, $sql_module));

        $moduleTitle = $chosenModule["module_name"];

        $sql_quiz = "SELECT * FROM quiz WHERE module_id = '$module_id';";

        $result_quiz = mysqli_query($conn, $sql_quiz);

        $totalQuestions = mysqli_num_rows($result_quiz);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">


    <title>Quiz</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <script src="../../scripts/volunteer_study.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body><?php include("header.php") ?>

    <div id="pointHead">
    <div>
        <form id="backOneModule" action="oneModule.php" method="post">
        <input type="hidden" name="oneModule" value="<?php echo $module_id; ?>">
        <div><button class="backPoint" id="backFromPoint"><i class="fa-solid fa-arrow-left"></i> Stop Answering </button>  </div>
        </form>
    </div>

    </div>

    <form action="oneQuiz.php" method="post" id="quizForm">
       <div class="quizContainer">


            <div class="quizQuestions">

            <div class="quizInfo">
                <h2><?php echo$moduleTitle; ?></h2>
                <p>This quiz contains <?php echo $totalQuestions; ?> questions</p>


            </div>


            <?php 
                $questionCount = 1;
                while($q = mysqli_fetch_assoc($result_quiz)){

            ?>

                <div class="qqCard">
                    <label for="" class="qqLabel"><?php echo $questionCount.'. '.$q["quiz_question"]; ?></label>
                    <div class="qqOptions">
                        <label class="qqOptionLabel">
                            <input type="radio" name="<?php echo $q["quiz_id"]; ?>" value="option 1" required>
                            <?php echo $q["option1"]; ?>
                        </label>
                        <label class="qqOptionLabel">
                            <input type="radio" name="<?php echo $q["quiz_id"]; ?>" value="option 2">
                            <?php echo $q["option2"]; ?>
                        </label>
                        <label class="qqOptionLabel">
                            <input type="radio" name="<?php echo $q["quiz_id"]; ?>" value="option 3">
                            <?php echo $q["option3"]; ?>
                        </label>
                        <label class="qqOptionLabel">
                            <input type="radio" name="<?php echo $q["quiz_id"]; ?>" value="option 4">
                            <?php echo $q["option4"]; ?>
                        </label>

                    </div>
                </div>

            <?php 
                $questionCount++;
                }

            ?>





            </div>

            <div class="submitAnswer">

                <h3>Done?</h3>
                <button type="submit" class="submitQuizBtn" name="submitQuizAnswer" value="<?php echo$module_id; ?>">
                    Submit The Answer
                </button>
            </div>

       </div>     
    </form>



    
</body>
</html>

<?php 

}else{
    header("Location: study.php");
    exit();
}

mysqli_close($conn)
?>