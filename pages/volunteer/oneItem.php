<?php

    include("../../conn.php");

    include("../../backend/sessionData.php");

    include("../../backend/utility.php");

    $userID = $_SESSION["userID"];

    if(isset($_POST['tree']) || isset($_POST['merchandise'])){


        if(isset($_POST['tree'])){

            $item_id = $_POST['tree'];

            $typeToShow = 'Tree';

        }else if(isset($_POST['merchandise'])){

            $item_id = $_POST['merchandise'];

            $typeToShow = 'Merchandise';

        }else{
            header("Location: redeem.php");
            exit();
        }


        $sql_one_item = "SELECT * FROM items
                          WHERE item_id = '$item_id';";

        $item = mysqli_fetch_assoc(mysqli_query($conn, $sql_one_item));

        $type = $item['category'];


    }
    

    if(isset($_POST["totalCost"])){

        $totalCost = $_POST["totalCost"];

        $sql_user_points = "SELECT * FROM users WHERE user_id = '$userID';";

        $userPoints = mysqli_fetch_assoc(mysqli_query($conn, $sql_user_points))["green_points"];

        if($userPoints >= $totalCost){

            $newPoints = $userPoints - $totalCost;

            

            $sql_update_points = "UPDATE users SET
                                    green_points = $newPoints
                                    WHERE user_id = '$userID';";

            if($type == 'merchandise') {

                $newID = newID($conn, 'merchandise_purchase_history', 'MP');

                $amount = $_POST["quantity"];

                $sql_insert_history = "INSERT INTO merchandise_purchase_history
                                        (merchandise_purchase_id, item_id, user_id, merchandise_purchase_datetime, amount)
                                        VALUES
                                        ('$newID', '$item_id', '$userID', NOW(), $amount);";


                if(mysqli_query($conn, $sql_insert_history)){
                    mysqli_query($conn, $sql_update_points);
                    echo '<script>alert("Redemption Successful! 🎉🎉");
                    

                            let form = document.createElement("form");
                            form.method = "POST";
                            form.action = "oneModule.php";
                            
                            let input = document.createElement("input");
                            input.type = "hidden";
                            input.name = "'.$type.'";
                            input.value = "'.$item_id.'";
                            
                            form.appendChild(input);
                            document.body.appendChild(form);
                            form.submit();

                            })
                            </script>';





                    
                }

            }else if($type == 'tree'){
                $newID = newID($conn, 'tree_adoption_history', 'TA');

                $givenName = $_POST["givenName"];

                $sql_insert_history = "INSERT INTO tree_adoption_history
                                        (tree_adoption_id, item_id, user_id, given_name, tree_adoption_datetime, fertilization_datetime, tree_adoption_status)
                                        VALUES
                                        ('$newID', '$item_id', '$userID', '$givenName', NOW(), NULL, 'Active');";


                if(mysqli_query($conn, $sql_insert_history)){
                    mysqli_query($conn, $sql_update_points);
                    echo '<script>alert("Adoption Successful!");
                    
                            let form = document.createElement("form");
                            form.method = "POST";
                            form.action = "oneModule.php";
                            
                            let input = document.createElement("input");
                            input.type = "hidden";
                            input.name = "'.$type.'";
                            input.value = "'.$item_id.'";
                            
                            form.appendChild(input);
                            document.body.appendChild(form);
                            form.submit();

                            })
                            </script>';

                }


            }
            

            
        }else{
            echo '<script>alert("Not enought Point 😭😭");</script>';
            header("Location: redeem.php");
            exit();
        }

    }
    if(!$item_id) {
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
        <form id="backOneModule" action="redeem.php" method="post">
        <div><button class="backPoint" id="backFromPoint"><i class="fa-solid fa-arrow-left"></i> <?php echo$typeToShow; ?></button>  </div>
        </form>
    </div>

    </div>

    <div class="itemContainer">

    <div class="itemCard">

        <div class="imageBox">
            <img src="../../<?php echo $item['item_image']; ?>" alt="Item Image" class="itemImg">
        </div>
        <form action="oneItem.php" method="post" id="redeemOrAdoptForm">

        <div class="itemContent">
            <h1 class="itemName" > <?php echo $item['item_name']; ?></h1>
            <p class="itemDescription">
                <?php echo$item['item_description']; ?>
            </p>

            <?php if($type == 'merchandise'){ ?>
            <div class="quantityBox">
                <button class="quantityBtn" type="button" id="minusBtn"><i class="fa-solid fa-minus"></i></button>

                <span id="itemQuantityShow">1</span>
                <input type="hidden" name="quantity" id="quantityInput" value="1">
                <input type="hidden" name="pointPerItem" id="pointPerItem" value="<?php echo$item['item_redeem_points']; ?>">


                <button class="quantityBtn" type="button" id="plusBtn"><i class="fa-solid fa-plus"></i></button>
            </div>

            <?php }else if($type == 'tree'){ ?>
                <input type="hidden" name="givenName" id="givenNameInput">
             <?php } ?>

            


        </div>
        
        <input type="hidden" name="<?php echo$type ?>" value="<?php echo$item_id ?>" id="typeAndId">
        <input type="hidden" name="totalCost" value="<?php echo$item['item_redeem_points']; ?>" id="toalCostInput">



        <button type="button" class="thBtn" id="itemRedeemBtn" > 
            <?php echo(($type == 'tree') ? 'Adopt' : 'Redeem'); ?> (-<?php echo$item['item_redeem_points']; ?> GP) 
        </button>

        </form>


    </div>

    </div>



    
</body>
</html>

<?php 


mysqli_close($conn)
?>