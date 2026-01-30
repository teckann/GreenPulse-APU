<?php
    include("pointBackend.php");

    include("../../conn.php");

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">


    <title>Point</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
    <?php include("header.php") ?>

    <div id="pointHead">
        <form action="profile.php">
    <div>
        <div><button class="backPoint" id="backFromPoint"><i class="fa-solid fa-arrow-left"></i> Point</button>  </div>
    </div>
</form>
    </div>
<div id="containerForDesktop">
    <div id="realPointBigContainer">
        <div id="realPointBar">


            <div class="pointDetails" id="realPointDetails">
                <p id="pointLabel">Current Green Point :</p>
                <!-- point Amount will be key in by js -->
                <h1 class="pointAmount"></h1>

                <hr id="realPointLine">
            </div>
        </div>


    <div id="totalPointBar">
        <div>
        <div id="totalPointBar-left" >
        
            <?php 

                $userID = $_SESSION["userID"];
                $sql_champ_badge= "SELECT * 
                        FROM badges b JOIN milestone m
                        ON b.badge_id = m.badge_id
                        WHERE m.user_id = '$userID'
                        ORDER BY b.points_required DESC
                        LIMIT 1;";

                $champBadge = mysqli_fetch_assoc(mysqli_query($conn,$sql_champ_badge));

                if(mysqli_num_rows(mysqli_query($conn,$sql_champ_badge)) <= 0){
                    $champImg = '';
                    $champName = 'No Badge';

                }else{

                    $champImg = $champBadge['badge_image'];
                    $champName = $champBadge['badge_name'];
                }

                


                echo '<img src="../../'.$champImg.'" alt="Badge Picture" class="badgePic">'; 

            
            ?>

            
            


        </div>
        </div>

        <div id="totalPointDetails">
            <p id="badgeName"><?php echo$champName; ?></p>
            <p id="totalPointLabel">Total Earned Green Point : </p>
            <p id="totalEarnedPoint">
                <?php
                    echo getTotalPoint($conn,$userID);
                ?> GP </p>
            

        </div>
</div>
        <div id="realPointDown">
            
            <!-- arrange the progrees through the width of currentProgress div -->
            <div class="progressBar" id="pointProgressBar">
                <div class="currentProgress">

                </div>
            </div>

            <p id="realPointMilestone">Next Milestone : <span class="nextMilestone"></span></p>

            <a href="badgeMilestone.php"  id="linkBadgeMilestone" >Badge and Milestone &nbsp  <i class="fa-solid fa-arrow-right"></i></a>

        </div>
    


    </div>
    <div id="pointFlowBtnContainer">
        <form action="pointflow.php" method="post">
            <button type="submit" name="pointFlow" value="earnedPoint" class="pointFlowBtn" >
                Points Earned
            </button>
            <button type="submit" name="pointFlow" value="spentPoint" class="pointFlowBtn">
                Points Spent
            </button>
        </form>
    </div>
</div>

</body>
</html>