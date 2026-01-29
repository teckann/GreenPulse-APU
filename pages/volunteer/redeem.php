<?php
    include("itemBackend.php");

    include("../../conn.php");

    
    include("../../backend/sessionData.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <script src="../../scripts/volunteer_redeem.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        @media (min-width: 1050px) {
            body {
                padding-right: 300px; 
            }
        }

        .navBar #redeemNav {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
        }

        .navBar #redeemNav span {
            color: #000000;
            
            background-color: #ffffff3c; 
            
            border-radius: 0 0 22px 22px; 
            
        }

        .navBar #redeemNav:hover {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
            border-radius: 0;
            transform: translateY(0px);

        }

        .navBar .redeemNav:hover span {
            color: #000000; 
        }
    </style>

</head>
<body>
    <?php include("header.php") ?>

    <div class="secondGeneralHeader" id="redeemSecondHeader">
 
    <div class="searchBar" id="redeemSearchBar">
            <input autocomplete="off" id="searchRedeem" class="searchArea" type="text" name="search" placeholder="Search for Merchandise/Tree">
            <button disabled class="searchButton" id="searchRedeemBtn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>

    </div>

    </div>

    <div class="pointBar" id="redeemPointBar">


        <div class="pointDetails" id="redeemPointDetails">
            <p id="pointLabel">Current Green Point :</p>


            <div class="sidePointAmount">

            <!-- point Amount will be key in by js -->
                <h1 class="pointAmount"></h1>
            </div>
            
            <div id="redeemDown">
            <hr id="redeemPointLine">

            <a href="point.php" class="viewPoint" id="redeemViewPoint">View Your Point <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div>

    </div>

    <div class="containerSmallNav" id="redeemSmallNav">
        <div class="smallNav">
            <div class="smallNavColumn" id="navRedeem1">
                <button class="smallNavBtn" id="merchandiseRedeemNav">Merchandise</button>
            </div>


            <div class="smallNavColumn" id="navRedeem2">
                <button class="smallNavBtn" id="treeStudyNav">Tree</button>
            </div>

        </div>
    </div>

    <div class="redeemMain" id="merchandiseRedeem">
        <?php 

            $sql_merchandise = "SELECT * FROM items 
                                WHERE  category = 'merchandise';";

            $merchandises = mysqli_query($conn,$sql_merchandise);
            
            addItemCard($merchandises);

        
        ?>

    </div>

    <div class="redeemMain" id="treeRedeem">
        <?php        


            $sql_tree = "SELECT * FROM items 
                                WHERE  category = 'tree';";

            $trees = mysqli_query($conn,$sql_tree);
            
            addItemCard($trees);

            mysqli_close($conn);
         ?>

    </div>

</body>
</html>