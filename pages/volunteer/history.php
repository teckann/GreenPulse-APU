<?php

    include("../../conn.php");

    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];

    $sql_historyAmount = "SELECT 
                            (SELECT COUNT(*) FROM attendance WHERE user_id = '$userID' AND attendance_status = 'Present') AS event_count,
                            (SELECT COUNT(*) FROM module_history WHERE user_id = '$userID')  AS module_count,
                            (SELECT COUNT(*) FROM tree_adoption_history WHERE user_id = '$userID')   AS tree_count,
                            (SELECT COUNT(*) FROM merchandise_purchase_history WHERE user_id = '$userID') AS merchandise_count;";

    $historyAmount = mysqli_fetch_assoc(mysqli_query($conn,$sql_historyAmount));

    $eventAmount = $historyAmount['event_count'];
    $moduleAmount = $historyAmount['module_count'];
    $treeAmount = $historyAmount['tree_count'];
    $merchandiseAmount = $historyAmount['merchandise_count']

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">


    <title>History</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
    <?php include("header.php") ?>

    <div class="profileHead">
    <div>
        <div><a href="profile.php" class="backEvent"><i class="fa-solid fa-arrow-left"></i></a> History</div>
    </div>

    </div>
    



    <div class="historyHeader" id="firstHistoryHeader">
        <h2>Event History</h2>
    </div>

    <div class="historyAmount">
            <div class="labelHistory">Event Attended :</div>
            
            <div class="amountLinkHistory" >
                <span class="amountHistory">
                    <?php echo$eventAmount ?>
                </span>
                <form method="post" action="secondaryHistory.php">
                    <button name="event" type="submit" value="event">
                        <i class="fa-solid fa-chevron-right wide-angle"></i>
                    </button>
            </form>
            </div>
      
    </div>

    <div class="historyHeader">
        <h2>Quiz History</h2>
    </div>

    <div class="historyAmount">
            <div class="labelHistory">Quiz Answered :</div>
            <div class="amountLinkHistory" >
                <span class="amountHistory">
                    <?php echo$moduleAmount ?>
                </span>
                <form method="post" action="secondaryHistory.php">
                    <button name="module" type="submit" value="module">
                        <i class="fa-solid fa-chevron-right wide-angle"></i>
                    </button>
            </form>
            </div>
      
    </div>

    <div class="historyHeader">
        <h2>Redemption History</h2>
    </div>

    <div class="historyAmount">
            <div class="labelHistory">Merchandise Redeemed :</div>
            <div class="amountLinkHistory" >
                <span class="amountHistory">
                    <?php echo$merchandiseAmount ?>
                </span>
                <form method="post" action="secondaryHistory.php">
                    <button name="merchandise" type="submit" value="merchandise">
                        <i class="fa-solid fa-chevron-right wide-angle"></i>
                    </button>
            </form>
            </div>
      
    </div>
    
    <div class="historyAmount" id="lastHistoryAmount">
            <div class="labelHistory">Tree Adopted :</div>
            <div class="amountLinkHistory" >
                <span class="amountHistory">
                    <?php echo$treeAmount ?>
                </span>
                <form method="post" action="secondaryHistory.php">
                    <button name="tree" type="submit" value="tree">
                        <i class="fa-solid fa-chevron-right wide-angle"></i>
                    </button>
            </form>
            </div>
      
    </div>

</body>
</html>