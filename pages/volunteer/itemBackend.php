<?php
    function addItemCard($items) {
        if(mysqli_num_rows($items) > 0){
            while($oneItem = mysqli_fetch_assoc($items)){
                echo'      
                    <div class="redeemCard">

                    <div class="redeemPicBox">
                        <img src="../../'.$oneItem["item_image"].'" alt="Module Cover" class="redeemPic">
                    </div>

                    <div class="centerRedeem">
                    <p class="redeemCardTitle">'.$oneItem["item_name"].'</p>
                    <P class="redeemCardDetail">'.$oneItem["item_description"].'</P>
                    </div>
                    <div>
                    <form action="oneItem.php" method="post">
                    <button class="redeemCardBtn" type="submit" name="'.$oneItem["category"].'" value="'.$oneItem["item_id"].'">Redeem ('.$oneItem["item_redeem_points"].'GP)</button>
                    </form>
                    </div>
                    </div>
                ';
            }
        }else{
            echo '<p class="noEvents">More items coming soon</p>';
        }
    } 

    if(isset($_GET["searchMerchandise"])){


        include("../../conn.php");

        $toSearch = $_GET["searchMerchandise"];


        $sql_search_merchandise = "SELECT * FROM items 
                            WHERE  category = 'merchandise'
                            AND item_name LIKE '%$toSearch%';";

        $findMerchandises = mysqli_query($conn,$sql_search_merchandise);
        
        addItemCard($findMerchandises);

        mysqli_close($conn);

    }elseif (isset($_GET["searchTree"])){

        include("../../conn.php");


        $toSearch = $_GET["searchTree"];


        $sql_search_tree = "SELECT * FROM items 
                            WHERE  category = 'tree'
                            AND item_name LIKE '%$toSearch%';";

        $findTrees = mysqli_query($conn,$sql_search_tree);
        
        addItemCard($findTrees);

        mysqli_close($conn);

    }

    
?>