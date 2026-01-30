<?php
    include("../../conn.php");

    
    include("badgeBackend.php");

    if(isset($_POST["claimBadge"])){
        $badgeToClaim = $_POST["claimBadge"];

        $sql_insert_milestone = "INSERT INTO milestone
                                    (user_id, badge_id, issue_date)
                                    VALUES
                                    ('$userID', '$badgeToClaim', NOW());";

        if(mysqli_query($conn, $sql_insert_milestone)){

            echo '<script>
                alert("Badge CLAIMED");
                

            
            </script>';

            header('Location: badgeMilestone.php');
        }

    }



    $userTotalPoints = getTotalPoint($conn, $userID);

    $sql_all_badges = "SELECT * FROM badges ORDER BY points_required DESC;";

    $allBadges = mysqli_query($conn, $sql_all_badges);

    $sql_count_badges = "SELECT
                          (SELECT COUNT(*) FROM badges) AS total_badges,
                          (SELECT COUNT(*) FROM milestone WHERE user_id = '$userID') AS owned_badges;";

    $countBadges = mysqli_fetch_assoc(mysqli_query($conn, $sql_count_badges));

    $totalBadges = $countBadges["total_badges"];

    $totalOwned = $countBadges["owned_badges"];

    $badgesNotOwned = $totalBadges - $totalOwned;

    $gapPerBadges = 100/$totalBadges;

    $baseFill = $gapPerBadges * $totalOwned;

    $currentGapPercent = ((getTotalPoint($conn, $userID) - getPrevRequiredPoint($conn, $userID)) / getRemainmingPoint($conn, $userID))*20;

    $fillPercentage = $baseFill + $currentGapPercent;

    if($fillPercentage >100){
        $fillPercentage = 100;
    }


    $hisghestBadges = mysqli_query($conn, $sql_all_badges);

    while ($row = mysqli_fetch_assoc($hisghestBadges)){
        $hisghestRequired = $row["points_required"];
        break;
        
    }






    if($hisghestRequired <= 0){
        $hisghestRequired = 1;
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <script src="../../scripts/volunteer_study.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <?php include("header.php") ?>

    <div id="makeItFixed">    
    <div class="eventHead" id="availableEventHead">
        <div>
            <div>
                <a href="event.php" class="backEvent">
                    <i class="fa-solid fa-arrow-left"></i>
                    Badge & Milestone
                </a> 
            </div>
        </div>
    </div>



        <div class="containerSmallNav">
            <div class="smallNav">
                <div class="smallNavColumn" id="navBadge">
                    <button class="smallNavBtn" id="badgeNav">Badge</button>
                </div>


                <div class="smallNavColumn" id="navMilestone">
                    <button class="smallNavBtn" id="milestoneNav">Milestone</button>
                </div>

            </div>
        </div>

    </div>

    <div class="someSpace">

    </div>

 <div class="badgeBigContainer" id="badgeDiv">
    <div class="champHeader">
        <div class="champTitle">Champion Badges</div>
        <div class="champText">Your Most Prestigious Badges live Here</div>
    </div>





    


    <?php 
    
        $sql_champ_badge= "SELECT * 
                            FROM badges b JOIN milestone m
                            ON b.badge_id = m.badge_id
                            WHERE m.user_id = '$userID'
                            ORDER BY b.points_required DESC
                            LIMIT 1;";

        $champBadge = mysqli_fetch_assoc(mysqli_query($conn,$sql_champ_badge));



    ?>
    


    <div class="champCard">
            <div class="champImageBox">
                <img src="../../<?php echo $champBadge['badge_image']; ?>" alt="badge Image" class="champImg">
            </div>
            <div class="champContent">

                <h2 class="champName" > <?php echo $champBadge['badge_name']; ?></h2>

                <div class="champBox">
                    <div class="champRow">
                    <span class="champLabel">Required Points :</span>
                    <span class="champDate"><?php echo$champBadge['points_required']; ?></span>
                    </div>
                    <div class="champRow">
                    <span class="champLabel">Achieved By :</span>
                    <span class="champDate"><?php echo$champBadge['issue_date']; ?></span>
                    </div>
                </div>
            </div>
    </div>

    <div class="rbHeader">
        <div class="rbhTitle">Badges</div>
        <div class="rbhText">Collected: 20/50</div>
    </div>

    <div class="realBadgeContainer">
    
    <?php

        $sql_my_badge= "SELECT * 
                        FROM badges b JOIN milestone m
                        ON b.badge_id = m.badge_id
                        WHERE m.user_id = '$userID';";


        $myBadge = mysqli_query($conn,$sql_my_badge);
        $myBadgeForMilestone = mysqli_query($conn,$sql_my_badge);


        if(mysqli_num_rows($myBadge) > 0){
            while($oneBadge = mysqli_fetch_assoc($myBadge)){

    ?>
    <div class="realBadgeCard">
        <div class="realBadgeImageBox">
            <img src="../../<?php echo $oneBadge['badge_image']; ?>" alt="badge Image" class="realBadgeImg">
        </div>

            <div class="realBadgeName" > <?php echo $oneBadge['badge_name']; ?></div>

            <div class="realBadgeBox">
                <div class="rbRow">
                    <span class="rbLabel">Required Points :</span>
                    <span class="rbDate"><?php echo$oneBadge['points_required']; ?></span>
                </div>
                <div class="rbRow">
                    <span class="rbLabel">Achieved By :</span>
                    <span class="rbDate"><?php echo$oneBadge['issue_date']; ?></span>
                </div>
            </div>

    </div>

    <?php 
            }
        }

        ?>
    </div>
</div>

    <div class="badgeMilestoneMain" id="milestoneDiv">
        <div class="milestoneContainer">

            <div class="totalEarnBar" >
                <div class="totalEarnedFill" style="height: <?php echo $fillPercentage;?>%;">

                </div>
            </div>

            <?php 

                $ownedBadgeID = [];
        
                while($row = mysqli_fetch_assoc($myBadgeForMilestone)){
                    $ownedBadgeID[] = $row['badge_id'];
                }
            
            while ($row = mysqli_fetch_assoc($allBadges)){

                $alreadyGot = false;
                $canClaim = false;


                $alreadyGot = in_array($row["badge_id"], $ownedBadgeID);

                if(!$alreadyGot && ($userTotalPoints >= $row["points_required"])){
                    $canClaim = true;

                }

            
            
            ?>

            <div class="oneMilestone">
                <div class="omLine">
                    <span class="omRequiredPoint">
                        <?php echo $row["points_required"] ?>
                    </span>
                </div>

                <div class="omCard">
                    <div class="omImageBox">
                        <img src="../../<?php echo $row["badge_image"] ?>" alt="Badge Image" class="omImg">

                    </div>
                    <div class="omName">
                        <?php echo $row["badge_name"] ?>
                    </div>
                    <div class="omClaim">
                        <?php if($alreadyGot){ ?>
                            <button class="omBtn"
                                    style="background-color: #85858535;
                                    border: 2px solid #63636396;;">
                                Achieved
                            </button>

                        <?php }else if($canClaim){ ?>
                        <form action="" method="post">
                            <button class="omBtn"
                                    style="background-color: #63fb68d1;
                                    border: 2px solid #b7f18796;
                                    animation-name: heartBeat;
                                    animation-duration: 2s;
                                    animation-iteration-count: infinite;"
                                    
                                    name="claimBadge"
                                    type="submit"
                                    value="<?php echo$row["badge_id"] ?>"
                                    >
                                Claim
                            </button>
                            </form>
                        <?php }else{ ?>
                            <button class="omBtn"
                                style="background-color: #4f4f4fe5;
                                border: 2px solid #63636396;;">
                                <?php echo $row["points_required"] ?> GP
                            </button>

                        <?php } ?>
                    </div>


                </div>

            </div>

            <?php } ?>

        </div>

    </div>

        




</body>
</html>