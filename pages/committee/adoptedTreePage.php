<?php 
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    $sql = "SELECT * FROM tree_adoption_history";

    // to see what type of tree user adoption have
    // $allRecords = mysqli_query($conn, $sql);

    // $allTrees = array();

    // while ($eachRow = mysqli_fetch_assoc($allRecords)) {
    //     $allTrees[] = $eachRow["item_id"];
    // }

    // to retrive the unique item is by using the array_unique, the first exist index become key, the unique value become value
    // then just use array_values get value
    // $uniqueItems = array_values(array_unique($allTrees));

    // function treeNames($conn, array $uniqueItemList) {
    //     $uniqueTreeName = array();
    //     foreach ($uniqueItemList as $eachItem) {
    //         $sqlSearch = "SELECT * FROM items WHERE item_id = '$eachItem' AND category = 'tree'";
    //         $searchResult = mysqli_query($conn, $sqlSearch);

    //         while ($row = mysqli_fetch_assoc($searchResult)) {
    //             $uniqueTreeName[] = $row["item_name"];
    //         }
    //     }
    //     return $uniqueTreeName;
    // }

    // $treeNameFilters = treeNames($conn, $uniqueItems);

    $search = '';
    $treeStatus = '';
    $treeCreatorStatus = '';

    // check is the search is used or not
    if (!empty($_GET["searchTree"])) {
        $search = $_GET["searchTree"];
    }

    $treeTypeStatus ='';
    
    

    //assign the filter value first
    if (!empty($_GET["filterAvailableTreeStatus"])) {
        $treeStatus = $_GET["filterAvailableTreeStatus"];
    }
    if (!empty($_GET["filterAvailableTreeType"])) {
        ?>
            <!-- <script>alert('has data')</script> -->
        <?php
        $treeTypeStatus = $_GET["filterAvailableTreeType"];
    }

    if (!empty($search)) {
        $sql = "SELECT * FROM tree_adoption_history WHERE given_name LIKE '%{$search}%'";
    }
    else {
        if ($treeStatus === "" && $treeTypeStatus === "") {
            $sql = "SELECT * FROM tree_adoption_history";
             ?>
                <!-- <script>alert('hihi');</script> -->
            <?php
        }
        else if ($treeStatus === "") {

            ?>
                <!-- <script>alert('hihi');</script> -->
            <?php
            $sql = "SELECT * FROM tree_adoption_history T INNER JOIN items I ON T.item_id = I.item_id WHERE I.item_name = '$treeTypeStatus'";
        }
        else if ($treeTypeStatus === "") {
            $sql = "SELECT * FROM tree_adoption_history T INNER JOIN items I ON T.item_id = I.item_id WHERE T.tree_adoption_status = '$treeStatus'";
        }
        else {
            $sql = "SELECT * FROM tree_adoption_history T INNER JOIN items I ON T.item_id = I.item_id WHERE I.item_name = '$treeTypeStatus' AND T.tree_adoption_status = '$treeStatus'";
        }
    }



    // $sql = "SELECT * from items where item_name like '%{$search}%'";
    $result = mysqli_query($conn, $sql);

    // while ($rows = mysqli_fetch_assoc($result)) {
    //     echo "<script>alert(' ". $rows['tree_adoption_id']. " ');</script>";
    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopted Tree Management Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include("header.php"); ?>

    <div id="fullPage">
            <div id="upperTree">
                <div id="treeManageText">
                    <h1>Tree Management <i class="fa-solid fa-tree" style="color: #228B22;"></i></h1>
                    <p>Add new, manage available tree adoption for volunteers to redeem</p>
                </div>
                <button id="btnMarkAllFertilized" name="btnMarkAllFertilizedItem"><span class="showDesktop">Mark All As Fertilized</span><span class="showMobile">Fertilize<br>All  <i class="fa-solid fa-flask"></i></span></button>
            </div>
            <div id="showTreeClass">
                <button id="btnAvailableTree" class="treeClass">
                    <a href="availableTreePage.php" style="text-decoration: none;">
                        <i class="fa-solid fa-circle-check" style="color: #28a745;"></i>
                        <p><b>Available Tree</b></p>
                    </a>
                </button>
                <button id="btnAdoptedTree" class="treeClass">
                    <a href="adoptedTreePage.php" style="text-decoration: none;">
                        <i class="fa-solid fa-house" style="color: #2e8b57;"></i>
                        <p><b>Adopted Tree</b></p>
                    </a>
                </button>
            </div>
            <hr>
            <div id="displayTreeCard">
                <div id="upperTreeCard">
                    <form action="" method="GET">
                        <div id="treeSearchBar">
                            <i class="fa-solid fa-magnifying-glass" for="searchTree" id="treeSearchIcon"></i>
                            <input type="text" id="searchTree" name="searchTree" placeholder="Search Tree by Name">
                        </div>
                        <div id="filterBar">
                            <div>
                                <label for="filterAvailableTreeStatus">Tree Status: </label>
                                <select name="filterAvailableTreeStatus" id="filterAvailableTreeStatus" class="filterTree">
                                    <option value="">All Status</option>
                                    <option value="Planted">Planted</option>
                                    <option value="Germinating">Germinating</option>
                                    <option value="Growing">Growing</option>
                                    <option value="Mature">Mature</option>
                                    <option value="Diseased">Diseased</option>
                                    <option value="Dead">Dead</option>
                                </select>
                            </div>

                            <div>
                                <label for="filterAvailableTreeType">Tree Type: </label>
                                <select name="filterAvailableTreeType" id="filterAvailableTreeType" class="filterTree">
                                    <option value="">All Types</option>
                                    <?php
                                        $uniqueTreeSql = "SELECT DISTINCT item_name FROM items I INNER JOIN tree_adoption_history T ON I.item_id = T.item_id ORDER BY item_name ASC";
                                        $resultOfTreeName = mysqli_query($conn, $uniqueTreeSql);

                                        $treeArray = array();

                                        while ($row = mysqli_fetch_assoc($resultOfTreeName)) {
                                            $treeArray[] = $row["item_name"];
                                        }

                                        foreach ($treeArray as $treeName) {
                                            echo "
                                            <option value='" . $treeName . "'>" .$treeName . "</option>
                                            ";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="showTreeCardsSpace">
                    <div class="showTreeCards">
                        <?php 
                            $trees = array();
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Planted
                                    // Germinating
                                    // Growing
                                    // Mature
                                    // Diseased
                                    // Dead"
                                $trees[] = $row;
                                $rowStatus = $row["tree_adoption_history"];
                                $statusColor = "";
                                if ($rowStatus === "Planted") {
                                    $statusColor = "#A8E6A3";
                                }
                                    else if ($rowStatus = "Germinating") {
                                    $statusColor = "#4DB6AC";
                                }
                                else if ($rowStatus = "Growing") {
                                    $statusColor = "#43A047";
                                }
                                else if ($rowStatus = "Mature") {
                                    $statusColor = "#1B5E20";
                                }
                                else if ($rowStatus = "Diseased") {
                                    $statusColor = "#FB8C00";
                                }
                                else {
                                    $statusColor = "red";
                                }

                                // $targetID = $row
                                $findUser = "SELECT * FROM users WHERE user_id = '{$row['adopted_tree_history.user_id']}'";
                                $userResult = mysqli_query($conn, $findUploadName);
                                $userName = mysqli_fetch_assoc($userResult)['name'];

                                $adoptDate = date("d M Y", strtotime($row['tree_adoption_date']));

                                $fertilizeInDB = $row['fertilization_datetime'];
                                $showFertilizeText = "";

                                if (!empty($fertilizeInDB) && $fertilizeInDB !== '0000-00-00 00:00:00') {
                                    $fertilizeDT = new DateTime($fertilizeInDB);
                                    $nowDT = new DateTime(); 
                                    if ($fertilizeDT->format('Y-m-d') === $nowDT->format('Y-m-d')) {
                                        // if today fertilized
                                        $showFertilizeText = "Today, " . $fertilizeDT->format('H:i');
                                    } 
                                    else {
                                        // if in different day
                                        $showFertilizeText = $fertilizeDT->format('d M Y, H:i');
                                    }
                                } else {
                                    $showFertilizeText = '-'; // No fertilization date
                                }


                                echo "
                                    <div class='treeCard'>
                                        <div class='upItemCard'>
                                            <div>
                                                <div>
                                                    <b class='itemId'>" . $row["item_id"] . "</b>
                                                </div>
                                                <div>
                                                    <p class='itemName'>" . $row["item_name"] ."</p>
                                                </div>
                                            </div>
                                            <div class='itemStatusContainer'>
                                                <p class='itemStatus' style='background-color: ". $statusColor ."'>". $row["item_status"] ."</p>
                                            </div>
                                        </div>
                                        <div class='middleItemCard'>
                                            <div class='itemImage'>
                                                <img src='../../". $row['item_image'] ."' alt='tree image'>
                                            </div>
                                            <div class='itemInventory'>
                                                <div class='treePoint'>
                                                    <b>Points Required:</b>
                                                    <p>" . $row['item_redeem_points'] . "</p>
                                                </div>
                                                <div class='itemStock'>
                                                    <b>Stocks:</b>
                                                    <p>" . $row['item_stock'] . "</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='itemInfo'>
                                            <div class='itemDescription'>
                                                <b>Description:</b>
                                                <p>" . $row['item_description'] . "</p>
                                            </div>
                                            <div class='itemUploadInfo'>
                                                <p><i>Uploaded by " . $uploaderName . "</i></p>
                                                <p> (" . $uploadDate . ")</p>
                                            </div>
                                        </div>
                                        <div class='itemButton'>
                                            <form action='#' method='GET'>
                                                <input type='hidden' name='targetItemID' value='" . $row['item_id'] . "'>
                                                <input type='hidden' name='targetUserID' value='" . $row['user_id'] . "'>
                                                <input type='hidden' name='targetItemName' value='" . $row['item_name'] . "'>
                                                <input type='hidden' name='targetItemImage' value='" . $row['item_image'] . "'>
                                                <input type='hidden' name='targetItemDescription' value='" . $row['item_description'] . "'>
                                                <input type='hidden' name='targetRedeemPoints' value='" . $row['item_redeem_points'] . "'>
                                                <input type='hidden' name='targetStock' value='" . $row['item_stock'] . "'>
                                                <button type='submit' name='deleteBtn' class='itemDeleteBtn'>Delete</button>
                                                <button type='submit' name='editBtn' class='itemEditBtn'>Edit</button>
                                                
                                            </form>
                                        </div>
                                    </div>";
                            }
                        ?>                
                    </div>
                </div>
            </div>
        </div>
        <script src="../../scripts/committee.js"></script>
</body>
</html>