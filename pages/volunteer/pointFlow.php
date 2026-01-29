<?php

    include("pointFlowBackend.php");

    $currentMonth = date('Y-m');
    $selectedMonth = isset($_REQUEST['selectedMonth']) ? $_REQUEST['selectedMonth'] : $currentMonth;

    if(isset($_POST['pointFlow'])){

    $showing = $_POST['pointFlow'];

    if($_POST['pointFlow'] == 'earnedPoint'){

        $backTitle = 'Points Earned';

    }else if($_POST['pointFlow'] == 'spentPoint'){

        $backTitle = 'Points Spent';

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
    <script src="../../scripts/volunteer_point.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
    <?php include("header.php") ?>

    <div id="pointHead">
    <div>
        <form action="point.php">
        <div><button class="backPoint" id="backFromPoint"><i class="fa-solid fa-arrow-left"></i> <?php echo $backTitle ?> </button>  </div>
        </form>
    </div>

    </div>

    <form action="pointTable.php" method="get">

    <div class="monthContainer">
        <div>
        <input type="month" data-showing-pf="<?php echo $showing; ?>" id="pfMonthShowing" class="monthToShow" name="selectedMonth" max="<?php echo (date('Y-m')) ?>" min="<?php echo(date('Y-m', strtotime("-4 months"))) ?>" value="<?php echo $selectedMonth; ?>">
        </div>
    </div>

    <div class="pointFlowContainer">
        <?php 
        
            printPointFlowContent($conn, $userID, $selectedMonth, $showing)
        
        ?>
    </div>
    </form>





    

</body>
</html>

<?php 
}else{
    header("Location: point.php");
    exit();
}

mysqli_close($conn)
 ?>