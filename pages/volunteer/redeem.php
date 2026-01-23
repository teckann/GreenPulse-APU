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

    <style>
        @media (min-width: 1050px) {
            body {
                padding-right: 300px; 
            }
        }
    </style>

</head>
<body>
    <?php include("header.php") ?>

    <div class="secondGeneralHeader" id="redeemSecondHeader">
 
    <div class="searchBar" id="redeemSearchBar">
        <form class="studySearchForm" >
            <input autocomplete="off" id="searchStudy" class="searchArea" type="text" name="search" placeholder="Search for Merchandise/Tree">
            <button class="searchButton" id="searchEventBtn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
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
        <div class="redeemCard">

            <div class="redeemPicBox">
                <img src="../../src/eventPosters/poster1.png" alt="Module Cover" class="redeemPic">
            </div>

            <div class="centerRedeem">
            <p class="redeemCardTitle">GreenPulse T-Shirt</p>
            <P class="redeemCardDetail">A GreenPulse branded T-shirt supporting green init..</P>
            </div>

            <button class="redeemCardBtn">Redeem (600GP)</button>
        </div>

                <div class="redeemCard">

            <div class="redeemPicBox">
                <img src="../../src/itemImages/item1.png" alt="Module Cover" class="redeemPic">
            </div>

            <div class="centerRedeem">
            <p class="redeemCardTitle">GreenPulse T-Shirt</p>
            <P class="redeemCardDetail">A GreenPulse branded T-shirt supporting green init..</P>
            </div>

            <button class="redeemCardBtn">Redeem (600GP)</button>
        </div>

                <div class="redeemCard">

            <div class="redeemPicBox">
                <img src="../../src/itemImages/item1.png" alt="Module Cover" class="redeemPic">
            </div>

            <div class="centerRedeem">
            <p class="redeemCardTitle">GreenPulse T-Shirt</p>
            <P class="redeemCardDetail">A GreenPulse branded T-shirt supporting green init..</P>
            </div>

            <button class="redeemCardBtn">Redeem (600GP)</button>
        </div>

                <div class="redeemCard">

            <div class="redeemPicBox">
                <img src="../../src/itemImages/item1.png" alt="Module Cover" class="redeemPic">
            </div>

            <div class="centerRedeem">
            <p class="redeemCardTitle">GreenPulse T-Shirt</p>
            <P class="redeemCardDetail">A GreenPulse branded T-shirt supporting green init..</P>
            </div>

            <button class="redeemCardBtn">Redeem (600GP)</button>
        </div>

                <div class="redeemCard">

            <div class="redeemPicBox">
                <img src="../../src/itemImages/item1.png" alt="Module Cover" class="redeemPic">
            </div>

            <div class="centerRedeem">
            <p class="redeemCardTitle">GreenPulse T-Shirt</p>
            <P class="redeemCardDetail">A GreenPulse branded T-shirt supporting green init..</P>
            </div>

            <div>
                <button class="redeemCardBtn">Redeem (600GP)</button>
            </div>
            
        </div>

    </div>

    <div class="redeemMain" id="treeRedeem">

    </div>

</body>
</html>