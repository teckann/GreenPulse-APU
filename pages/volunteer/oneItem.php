<?php

    include("../../conn.php");

    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];

    if(isset($_POST['tree']) || isset($_POST['merchandise'])){


        if(isset($_POST['tree'])){

            $item_id = $_POST['tree'];

            $type = 'Tree';

        }else if(isset($_POST['merchandise'])){

            $item_id = $_POST['merchandise'];

            $type = 'Merchandise';

        }else{
            header("Location: redeem.php");
            exit();
        }


        $sql_one_item = "SELECT * FROM items
                          WHERE item_id = '$item_id';";

        $item = mysqli_fetch_assoc(mysqli_query($conn, $sql_one_item));


    }else {
        header("Location: redeem.php");
        exit();
    }
    // if (!$item) {
    //     // echo "<script>alert('Item not found.');
    //     //         window.location.href='history.php';
    //     //       </script>";
    //     // exit();
    // }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <link rel="stylesheet" href="../../styles/volunteer_2.css">
    <script src="../../scripts/volunteer.js"></script>
    <script src="../../scripts/volunteer_redeem.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body><?php include("header.php") ?>

    <div id="pointHead">
    <div>
        <form id="backOneModule" action="history.php" method="post">
        <input type="hidden" name="oneModule" value="<?php echo $module_id; ?>">
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

            <div class="quantityBox">
                <button class="quantityBtn" id="minusBtn"><i class="fa-solid fa-minus"></i></button>

                <span id="itemQuantityShow">1</span>
                <input type="hidden" name="quantity" id="quantityInput" value="1">
                <input type="hidden" name="quantity" id="pointPerItem" value="<?php echo$item['item_redeem_points']; ?>">


                <button class="quantityBtn" id="plusBtn"><i class="fa-solid fa-plus"></i></button>
            </div>

            


        </div>
        
        <button class="thBtn" id="itemRedeemBtn" name="totalCost" value="<?php echo$item['item_redeem_points']; ?>"> Redeem (-<?php echo$item['item_redeem_points']; ?> GP) </button>

    </div>

    </div>



    
</body>
</html>

<?php 


mysqli_close($conn)
?>