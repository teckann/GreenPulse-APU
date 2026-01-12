<?php 
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

    $sql = "SELECT * FROM items WHERE category = 'tree'";

    if (!empty($_GET["filterAvailableTreeStatus"])) {
        $status = $_GET["filterAvailableTreeStatus"];
    }
    
    $isStatus = !empty($_GET['searchTree']);
    $isCreater = !empty($_GET["filterAvailableTreeCreator"]);

    $search = "";
    if ($isStatus) {
        $search = $_GET['searchTree'];
        echo "<script>alert('$search')</script>";
        $sql = "SELECT * FROM items WHERE item_name LIKE '%{$search}%' AND category = 'tree'";
    }
    elseif ($isStatus && $isCreater) {
        $sql = "SELECT * FROM items WHERE    item_status = '$status' and user_id = '$userID' AND category = 'tree'";
    }
    elseif (!$isStatus && $isCreater) {
        $sql = "SELECT * FROM items WHERE user_id = '$userID' AND category = 'tree'";
    }
    else if ($isStatus && !$isCreator) {
        $sql = "SELECT * FROM items WHERE item_status = '$status' AND category = 'tree'";
    }

    // $sql = "SELECT * from items where item_name like '%{$search}%'";
    $result = mysqli_query($conn, $sql);

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree Management Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include("commiteeTemplate.php"); ?>

    <main>
        <div id="upperTree">
            <div id="treeManageText">
                <h1>Tree Management <i class="fa-solid fa-tree" style="color: #228B22;"></i></h1>
                <p>Add new, manage available tree adoption for volunteers to redeem</p>
            </div>
            <button><span class="showDesktop" name="addTreeButton">Add Tree</span><span class="showMobile"><i class="fa-solid fa-plus" style="color: white;"></i></span></button>
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
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <div>
                            <label for="filterAvailableTreeCreator">Trees Created by: </label>
                            <select name="filterAvailableTreeCreator" id="filterAvailableTreeCreator" class="filterTree">
                                <option value="">All Users</option>
                                <option value="user">Me</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            
            <div id="showTreeCards">
                <?php 
                    $trees = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $trees[] = $row;
                        $statusColor = "";
                        if ($row["item_status"] === "Active") {
                            $statusColor = "green";
                        }
                        else {
                            $statusColor = "red";
                        }

                        // $targetID = $row
                        $findUploadName = "SELECT * FROM users WHERE user_id = '{$row['user_id']}'";
                        $uploaderResult = mysqli_query($conn, $findUploadName);
                        $uploaderName = mysqli_fetch_assoc($uploaderResult)['name'];

                        echo "<div class='treeCard'>
                                <div class='upItemCard'>
                                    <div>
                                        <div>
                                            <p><b>" . $row["item_id"] . "</b></p>
                                            <p class='treeName'>". $row["item_name"] ."</p>
                                        </div>
                                        <div>
                                            <p class='treeNameInCard'>" . $row["item_status"] ."</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class='treeStatus' style='background-color: ". $statusColor ."'>". $row["item_status"]."</p>
                                    </div>
                                </div>
                                <div class='middleItemCard'>
                                    <div class='itemImage'>
                                        <img src='../../". $row['item_image'] ."' alt='tree image'>
                                    </div>
                                    <div class='itemInventory'>
                                        <div class='treePoint'>
                                            <p><b>Points Required:</b></p>
                                            <p>" . $row['item_redeem_points'] . "</p>
                                        </div>
                                        <div class='itemStock'>
                                            <p><b>Stocks:</b></p>
                                            <p>" . $row['item_stock'] . "</p>
                                        </div>
                                    </div>
                                </div>
                                <div class='itemInfo'>
                                    <div class='itemDescription'>
                                        <p>Description:</p>
                                        <p>" . $row['item_description'] . "</p>
                                        <script>alert('".$uploaderName."')</script>
                                    </div>
                                    <div class='itemUploadInfo'>
                                        <p>Updated by " . $uploaderName . "</p>
                                        <p>Uploaded Date: " . $row['posted_date'] . "</p>
                                    </div>
                                </div>
                            </div>";
                    }
                ?>                
            </div>
        </div>
    </main>
    <script src="../../scripts/committee.js"></script>
</body>
</html>

<?php 

?>