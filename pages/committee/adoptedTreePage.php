<?php 
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    $sql = "SELECT * FROM tree_adoption_history";

    // to see what type of tree user adoption have
    $allRecords = mysqli_query($conn, $sql);

    $allTrees = array();

    while ($eachRow = mysqli_fetch_assoc($allRecords)) {
        $allTrees[] = $eachRow["item_id"];
    }

    // to retrive the unique item is by using the array_unique, the first exist index become key, the unique value become value
    // then just use array_values get value
    $uniqueItems = array_values(array_unique($allTrees));

    function treeNames($conn, array $uniqueItemList) {
        $uniqueTreeName = array();
        foreach ($uniqueItemList as $eachItem) {
            $sqlSearch = "SELECT * FROM items WHERE item_id = '$eachItem' AND category = 'tree'";
            $searchResult = mysqli_query($conn, $sqlSearch);

            while ($row = mysqli_fetch_assoc($searchResult)) {
                $uniqueTreeName[] = $row["item_name"];
            }
        }
        return $uniqueTreeName;
    }

    $treeNameFilters = treeNames($conn, $uniqueItems);

    

    foreach ($haha as $eachUniqueTreeType) {
        echo "<script>alert('$eachUniqueTreeType');</script>";
    }

    $search = '';
    $treeStatus = '';
    $treeCreatorStatus = '';

    // check is the search is used or not
    if (!empty($_GET["searchTree"])) {
        $search = $_GET["searchTree"];
    }

    //assign the filter value first
    if (!empty($_GET["filterAvailableTreeStatus"])) {
        $treeStatus = $_GET["filterAvailableTreeStatus"];
    }
    if (!empty($_GET["filterAvailableTreeType"])) {
        $treeTypeStatus = $_GET["filterAvailableTreeType"];
    }

    if (!empty($search)) {
        $sql = "SELECT * FROM tree_adoption_history WHERE given_name LIKE '%{$search}%'";
    }
    else {
        if ($treeStatus === "" && $treeTypeStatus === "") {
            $sql = "SELECT * FROM tree_adoption_history";
        }
        else if ($treeStatus === "") {
            $sql = "SELECT * FROM tree_adoption_history WHERE ";
        }
        else if ($treeTypeStatus === "") {
            $sql = "SELECT * FROM tree_adoption_history WHERE item_status = '$treeStatus' AND category = 'tree'";
        }
        else {
            $sql = "SELECT * FROM tree_adoption_history WHERE item_status = '$treeStatus' AND user_id = '$userID' AND category = 'tree'";
        }
    }


    // $sql = "SELECT * from items where item_name like '%{$search}%'";
    $result = mysqli_query($conn, $sql);
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
                <button id="btnAddItem" name="btnAddItem"><span class="showDesktop">Add Tree</span><span class="showMobile"><i class="fa-solid fa-plus" style="color: white;"></i></span></button>
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
                                    <option value="Inactive">Germinating</option>
                                    <option value="Inactive">Growing</option>
                                    <option value="Inactive">Mature</option>
                                    <option value="Inactive">Diseased</option>
                                    <option value="Inactive">Dead</option>
                                </select>
                            </div>

                            <div>
                                <label for="filterAvailableTreeType">Tree Type: </label>
                                <select name="filterAvailableTreeType" id="filterAvailableTreeType" class="filterTree">
                                    <option value="">All Types</option>
                                    <?php
                                        foreach ($treeNameFilters as $treeName) {
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
                                $trees[] = $row;
                                $statusColor = "";
                                if ($row["item_status"] === "Active") {
                                    $statusColor = "green";
                                }
                                else {
                                    $statusColor = "#dc3545";
                                }

                                // $targetID = $row
                                $findUploadName = "SELECT * FROM users WHERE user_id = '{$row['user_id']}'";
                                $uploaderResult = mysqli_query($conn, $findUploadName);
                                $uploaderName = mysqli_fetch_assoc($uploaderResult)['name'];
                                $uploadDate = date("d M Y", strtotime($row['posted_date']));

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
</body>
</html>