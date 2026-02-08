<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");


    if (isset($_POST["btnConfirmChangeSafetyQuestion"])) {
        $question1 = $_POST["newSafetyQuestionSelect1"];
        $question2 = $_POST["newSafetyQuestionSelect2"];
        $answer1 = trim($_POST["newSafetyQuestionAnswer1"]);
        $answer2 = trim($_POST["newSafetyQuestionAnswer2"]);

        if ($question1 == "" || $question2 == "") {
            $errorMessage = "Please select both questions to change.";
        }
        else if ($question1 == $question2) {
            $errorMessage = "Please dont select same question.";
        }
        else if (empty($answer1) || empty($answer2)) {
            $errorMessage = "Please fill in all the fields provided.";
        }
        else {
            $sqlUpdateSafetyQuestion = "UPDATE users SET safety_question_1 = '$question1', answer_1 = '$answer1', safety_question_2 = '$question2', answer_2 = '$answer2' WHERE user_id = '$userID'";

            if (mysqli_query($conn, $sqlUpdateSafetyQuestion)) {

                addLog($conn, $userID, "Update Security Question ($userID)");
                ?>
                    <script>
                        alert("Security Question Update Successfully");
                        window.location.href = "index.php";
                    </script>
                <?php
            }
        }

        ?>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const selectBox1 = document.querySelector("#newSafetyQuestionSelect1");
                    const selectBox2 = document.querySelector("#newSafetyQuestionSelect2");
                    const answerBox1 = document.querySelector("#newSafetyQuestionAnswer1");
                    const answerBox2 = document.querySelector("#newSafetyQuestionAnswer2");

                    selectBox1.value = <?php echo json_encode($question1) ?>;
                    selectBox2.value = <?php echo json_encode($question2) ?>;
                    answerBox1.value = <?php echo json_encode($answer1) ?>;
                    answerBox2.value = <?php echo json_encode($answer2) ?>;
                })
                alert('<?php echo $errorMessage ?>');
            </script>
        <?php
    }
    else {
        $sqlSelectSafetyQuestion = "SELECT * FROM users WHERE user_id = '$userID'";

        $result = mysqli_query($conn, $sqlSelectSafetyQuestion);

        if ($row = mysqli_fetch_assoc($result)) {
            $dataSafetyQuestion1 = $row["safety_question_1"];
            $dataSafetyQuestion2 = $row["safety_question_2"];
            $dataSafetyQuestionAnswer1 = $row["answer_1"];
            $dataSafetyQuestionAnswer2 = $row["answer_2"];

            if ($dataSafetyQuestion1 == null) {
                $dataSafetyQuestion1 = "";
            }
            if ($dataSafetyQuestion2== null)
                $dataSafetyQuestion2 = "";
            ?>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const selectBox1 = document.querySelector("#newSafetyQuestionSelect1");
                        const selectBox2 = document.querySelector("#newSafetyQuestionSelect2");
                        const answerBox1 = document.querySelector("#newSafetyQuestionAnswer1");
                        const answerBox2 = document.querySelector("#newSafetyQuestionAnswer2");

                        selectBox1.value = <?php echo json_encode($dataSafetyQuestion1); ?>;
                        selectBox2.value = <?php echo json_encode($dataSafetyQuestion2); ?>;
                        answerBox1.value = <?php echo json_encode($dataSafetyQuestionAnswer1); ?>;
                        answerBox2.value = <?php echo json_encode($dataSafetyQuestionAnswer2); ?>;
                    })
                </script>
            <?php
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include ("header.php") ?>

    <div id="changeSafetyQuestionUpperPart">
        <div><button id='btnBackToSecurityMainPage' class='btnExitPopUps'><a href="securityMainPage.php"><i class="fa-solid fa-arrow-left"></i></a></button></div>
        <div id="changeSafetyQuestionTextPart"><b id="changeSafetyQuestionText">Security Question Changing Page</b></div>
    </div>
    <form action="#" method="POST">
        <div id="changeSafetyQuestionBottomPart">
            <div class="changeSafetyQuestionForm">
                <div class="changeSafetyQuestionInput1">
                    <div class="newSafetyQuestion1">
                        <label for="newSafetyQuestionSelect1" class="upText">Question 1:</label>
                        <select name="newSafetyQuestionSelect1" id="newSafetyQuestionSelect1" class="upText">
                            <option value="">-- Please Select --</option>
                            <option value="What is your secondary school name?">What is your secondary school name?</option>
                            <option value="What is your mother's middle name?">What is your mother's middle name?</option>
                            <option value="What is your favorite color?">What is your favorite color?</option>
                            <option value="What is your first car brand?">What is your first car brand?</option>
                            <option value="What is the city name were you born in?">What is the city name were you born in?</option>
                        </select>
                    </div>
                    <div id="safetyQuestionAnswer1" class="newSafetyQuestion1">
                        <label for="newSafetyQuestionAnswer1" class="upText">Question 1 Answer:</label>
                        <input type="text" name="newSafetyQuestionAnswer1" id="newSafetyQuestionAnswer1" class="upText" required>
                    </div>
                </div>
                <div class="changeSafetyQuestionInput2">
                    <div class="newSafetyQuestion2">
                        <label for="newSafetyQuestionSelect2" class="upText">Question 2:</label>
                        <select name="newSafetyQuestionSelect2" id="newSafetyQuestionSelect2" class="upText">
                            <option value="">-- Please Select --</option>
                            <option value="What is your secondary school name?">What is your secondary school name?</option>
                            <option value="What is your mother's middle name?">What is the middle name of your mother?</option>
                            <option value="What is your favorite color?">What is your favorite color?</option>
                            <option value="What is your first car brand?">What is your first car brand?</option>
                            <option value="What is the city name were you born in?">What is the city name were you born in?</option>
                        </select>
                    </div>
                    <div id="safetyQuestionAnswer2" class="newSafetyQuestion2">
                        <label for="newSafetyQuestionAnswer2" class="upText">Question 2 Answer:</label>
                        <input type="text" name="newSafetyQuestionAnswer2" id="newSafetyQuestionAnswer2" class="upText" required>
                    </div>
                </div>
                <div class="changeSafetyQuestionBtns">
                    <button class="btnConfirmChangeSafetyQuestion" name="btnConfirmChangeSafetyQuestion">Confirm</button>
                </div>
            </div>
        </div>
    </form>
    <?php include ("hamburgerMenu.php");?>
</body>
</html>