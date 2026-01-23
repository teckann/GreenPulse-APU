<?php
    include("eventBackend.php");

    include("../../conn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                <span class="amountHistory">34</span>
                <a><i class="fa-solid fa-chevron-right wide-angle"></i></a>
            </div>
      
    </div>

    <div class="historyHeader">
        <h2>Quiz History</h2>
    </div>

    <div class="historyAmount">
            <div class="labelHistory">Quiz Answered :</div>
            <div class="amountLinkHistory" >
                <span class="amountHistory">34</span>
                <a><i class="fa-solid fa-chevron-right wide-angle"></i></a>
            </div>
      
    </div>

    <div class="historyHeader">
        <h2>Redemption History</h2>
    </div>

    <div class="historyAmount">
            <div class="labelHistory">Merchandise Redeemed :</div>
            <div class="amountLinkHistory" >
                <span class="amountHistory">34</span>
                <a><i class="fa-solid fa-chevron-right wide-angle"></i></a>
            </div>
      
    </div>
    
    <div class="historyAmount" id="lastHistoryAmount">
            <div class="labelHistory">Tree Adopted :</div>
            <div class="amountLinkHistory" >
                <span class="amountHistory">34</span>
                <a><i class="fa-solid fa-chevron-right wide-angle"></i></a>
            </div>
      
    </div>

</body>
</html>