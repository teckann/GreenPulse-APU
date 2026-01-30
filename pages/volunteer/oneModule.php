<?php

    include("../../conn.php");

    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];



    if(isset($_POST["oneModule"])){
        $module_id = $_POST["oneModule"];

        

        $sql_one_module = "SELECT *,
                             (SELECT highest_score FROM module_history WHERE module_id = '$module_id' AND user_id = '$userID') AS highest_score,
                             (SELECT COUNT(*)FROM quiz WHERE module_id = '$module_id') AS total_quiz,
                             (SELECT SUM(quiz_given_point) FROM quiz WHERE module_id = '$module_id') AS total_points
                             FROM modules WHERE module_id = '$module_id';";

        $clickedModule = mysqli_fetch_assoc(mysqli_query($conn,$sql_one_module));

        if($clickedModule["module_status"] == "Active" && ($clickedModule["total_quiz"] > 0)){
            $disabledOrNot = '';
        }else{
            $disabledOrNot = 'disabled';
        }


        if(isset($clickedModule["highest_score"])){
            $btn = 'Redo The Quiz';
        }else{
            $btn = 'Start The Quiz';
        }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">


    <title>Module</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <script src="../../scripts/volunteer_study.js"></script>

    <?php 
    
    if($disabledOrNot == ''){
    
    
    ?>

    <style>
        .quizBtn:hover {
            transform: translateY(-2px);

            box-shadow: 0 6px 20px rgba(198, 255, 0, 0.6);
            
            color: #ccff33;
            background-color: #1b5e20;
        }

        .quizBtn {
            background-color: #c6ff00;
            color: #1b5e20;
        }
    </style>

    <?php  }else{ ?>
    <style>
        .quizBtn {
            background-color: #a5a5a5;
            color: #000000;
        }
    </style>


    <?php } ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body><?php include("header.php") ?>

    <div class="profileHead">
        <div>
            <form action="study.php">
            <button class="backEvent" id="oneModuleBack">
                <i class="fa-solid fa-arrow-left"></i>
            </button> 
            </form>
        </div>
    </div>

    <div class="moduleDetailContainer">

        <div class="oneModuleLeft">
            <div class="moduleFirstSection">
                <h1 class="oneModuleTitle"><?php echo$clickedModule["module_name"]; ?></h1>
            </div>

            <div class="moduleDescriptionBox">
                <h3 class="descLabel">Description</h3>
                <p class="descText">
                    <?php echo$clickedModule["module_description"]; ?>
                </p>
            </div>

            <div class="oneModuleMaterial" id="studyVideoMaterial">
                <video controls muted paused class="oneModuleVid">
                    <source src="../../<?php echo$clickedModule["module_video"]; ?>" type="video/mp4">
                </video>
            </div>

            <div class="oneModuleMaterial" id="oneModulePdfBox">
                <iframe allowfullscreen  src="../../<?php echo$clickedModule["module_material"]; ?>#view=FitH" class="oneModulePdf"></iframe>
            </div>




        </div>

        <div class="oneModuleRight">
            
            <div class="oneModule-infoCard">
                
                <div class="infoRow">
                    <div class="infoIcon"><i class="fa-regular fa-calendar"></i></div>
                    <div class="infoText">
                        <div class="infoLabel">Total Points </div>
                        <div class="infoToFill1"><?php echo $clickedModule["total_points"]; ?></div>
                    </div>
                </div>

                <div class="infoRow">
                    <div class="infoIcon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="infoText">
                        <div class="infoLabel">Total quiz </div>
                        <div class="infoToFill1"><?php echo$clickedModule["total_quiz"]; ?></div>
                    </div>
                </div>


                <div class="infoRow" id="infoRow-last">
                    <div class="infoText" id="infoText-last">
                        <div class="infoLabel">Score</div>

                        <?php
                        if(isset($clickedModule["highest_score"])){
                            echo'<div class="oneModuletAvailability">
                                <span>'.$clickedModule["highest_score"].' /  '.$clickedModule["total_quiz"].'</span>
                                <span class="maxSlot"> ';

                                    if($clickedModule["highest_score"] == $clickedModule["total_quiz"]){
                                        echo'YAY! Yout Got All Right!';
                                    }else{
                                        echo'Oh O 🫣';
                                    }
                                        
                            echo'</span>
                            </div>
                            
                            <div class="oneModuleProgressBar">
                                <div class="oneModuleProgressFill" style="width:
                                '. ($clickedModule["highest_score"]/$clickedModule["total_quiz"]*100).'%">
                                </div>
                            </div>';
                        }else{
                            echo'<div class="oneEventAvailability">
                                <span> No record </span>
                            </div>';
                        }
                        ?>

                    </div>
                </div>

                <form action="oneQuiz.php" method="post">

                <?php 
                echo'<button '.$disabledOrNot.' class="quizBtn" name="answerQuiz" type="submit" value="'.$module_id.'">'.$btn.'</button>' 
                ?>

                </form>

            </div>
        </div>

    </div>

    
</body>
</html>

<?php 
}else{
    header('Location: study.php');
}
mysqli_close($conn); ?>