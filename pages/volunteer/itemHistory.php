<?php

    include("../../conn.php");

    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];

    
    if(isset($_POST['tree'])){

        $item_id = $_POST['tree'];

        $type = 'Tree';


        $sql_historyTree = "SELECT tah.*, items.*
                            FROM tree_adoption_history tah
                            JOIN items ON tah.item_id = items.item_id
                            WHERE tah.user_id = '$userID' 
                            AND tah.tree_adoption_id = '$item_id';";

        $item = mysqli_fetch_assoc(mysqli_query($conn, $sql_historyTree));

        if($item){
            $date = date('Y-m-d', strtotime($item['tree_adoption_datetime']));

            $dateLabel = 'Adopted';

            $pointCost = $item['item_redeem_points'];            
        }



    }else if(isset($_POST['merchandise'])){

        $item_id = $_POST['merchandise'];

        $type = 'Merchandise';

        $sql_historyMerchandise = "SELECT mph.*, items.*
                                   FROM merchandise_purchase_history mph
                                   JOIN items ON mph.item_id = items.item_id
                                   WHERE mph.user_id = '$userID' 
                                   AND mph.merchandise_purchase_id = '$item_id';";

        $item = mysqli_fetch_assoc(mysqli_query($conn, $sql_historyMerchandise));

        if($item) {
            $date = date('d F Y', strtotime($item['merchandise_purchase_datetime']));

            $dateLabel = 'Redeemed';

            $totalCost = $item['amount'] * $item['item_redeem_points'];

            $pointCost = $item['item_redeem_points'] . ' GP x ' . $item['amount'] . ' = ' . $totalCost;
        }

    }else{
        header("Location: history.php");
        exit();
    }

    if (!$item) {
        echo "<script>alert('Item not found.');
                window.location.href='history.php';
              </script>";
        exit();
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
<body><?php include("header.php") ?>

    <div id="pointHead">
    <div>
        <form id="backOneModule" action="secondaryHistory.php" method="post">
        <input type="hidden" name="<?php echo $item["category"]; ?>" value="<?php echo $item["category"]; ?>">
        <div><button class="backPoint" id="backFromPoint"><i class="fa-solid fa-arrow-left"></i><?php echo$type; ?></button>  </div>
        </form>
    </div>

    </div>

    <div class="itemContainer">

    <div class="itemCard">

        <div class="imageBox">
            <img src="../../<?php echo $item['item_image']; ?>" alt="Item Image" class="itemImg">
        </div>

        <div class="itemContent">
            <h1 class="itemName" > <?php echo $item['item_name']; ?></h1>
            <p class="itemDescription">
                <?php echo$item['item_description']; ?>
            </p>

            <div class="redeemDateBox">
                <span class="dbLabel"><?php echo$dateLabel; ?> By :</span>
                <span class="dbDate"><?php echo$date; ?></span>

                <span class="dbLabel">Cost :</span>
                <span class="dbDate"><?php echo$pointCost ?> GP</span>

            </div>

            <?php     if(isset($_POST['tree'])){ ?>
            <button class="thBtn"> View This Tree </button>
            <?php } ?>

        </div>

    </div>

    </div>



    
</body>
</html>

<?php 


mysqli_close($conn)
?>