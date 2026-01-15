<?php 
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

    $sql = "SELECT * FROM items WHERE category = 'tree'";

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
    if (!empty($_GET["filterAvailableTreeCreator"])) {
        $treeCreatorStatus = $_GET["filterAvailableTreeCreator"];
    }

    if (!empty($search)) {
        $sql = "SELECT * FROM items WHERE item_name LIKE '%{$search}%' AND category = 'tree'";
    }
    else {
        if ($treeStatus === "" && $treeCreatorStatus === "") {
            $sql = "SELECT * FROM items WHERE category = 'tree'";
        }
        else if ($treeStatus === "") {
            $sql = "SELECT * FROM items WHERE user_id = '$userID' AND category = 'tree'";
        }
        else if ($treeCreatorStatus === "") {
            $sql = "SELECT * FROM items WHERE item_status = '$treeStatus' AND category = 'tree'";
        }
        else {
            $sql = "SELECT * FROM items WHERE item_status = '$treeStatus' AND user_id = '$userID' AND category = 'tree'";
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
    <title>Tree Management Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include("commiteeTemplate.php"); ?>

    <main>
        <div id="fullPage">
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
                                    $statusColor = "red";
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
                                                <input type='hidden' name='targetUserID' value='" . $row['item_id'] . "'>
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

        <div id="itemOverlay"></div>

        <div id="itemPopUp">
            <div class="popUpHeader">
                <div><button><i class="fa-solid fa-arrow-left"></i></button></div>
                <div><button><b>Edit Tree</b></button></div>
            </div>
            <?php 
                if(isset($_GET['editBtn']) ){
                    $editTreeSql = "SELECT * FROM items WHERE item_id = '{$_GET['targetUserID']}'";
                    $treeEditResult = mysqli_query($conn, $editTreeSql);
                    while ($row = mysqli_fetch_assoc($treeEditResult)) {
                        echo "
                            <form action='#' method='GET'>
                                <div class='popUpShow'>
                                    <div class='itemPopUpInput'>
                                        <label for='itemName'>Tree Name</label>
                                        <input type='text' name='itemName' id='itemName' value='" . $row['item_name'] . "'>
                                    </div>
                                </div>
                            </form>";
                    }
                }
            ?>
        </div>
    </main>
    <script>
        
        document.addEventListener('DOMContentLoaded', () => {
            const btnEditItem = document.querySelectorAll(".itemEditBtn");
            const itemPopUpOverlay = document.querySelector("#itemOverlay");
            const itemPopUp = document.querySelector("#itemPopUp");


            btnEditItem.forEach((eachEditBtn) => {
                eachEditBtn.addEventListener('click', () => {
                
                itemPopUpOverlay.style.display = 'block';
                itemPopUp.style.display = 'block';

            }) ;
            });
        });

        const treeStatus = document.getElementById("filterAvailableTreeStatus");

        // check the session has record or not, if don't have record, will become null
        const savedStatusValue = sessionStorage.getItem("selectedTreeStatus");
        // if there have record, will asign it into the the selectbox value
        if (savedStatusValue !== null) { 
            treeStatus.value = savedStatusValue;
        }

        // place the listener to listen if the sleect box has change or not, if change it will assign new data inyo session
        // and the page will refresh due to this is submit type, the set value will become can get one
        treeStatus.addEventListener('change', function() {
            sessionStorage.setItem('selectedTreeStatus', this.value);
        });

        const treeCreator = document.querySelector("#filterAvailableTreeCreator");
        const savedCreatorValue = sessionStorage.getItem("selectedTreeCreator");
        if (savedCreatorValue != null) {
            treeCreator.value = savedCreatorValue;
        }
        
        // only funcyion() have their this, arrow  function don;t have this (this refer to window), but can use function(e) or (e) => , and use the e.target.value
        treeCreator.addEventListener('change', function() {
            sessionStorage.setItem("selectedTreeCreator", this.value);
        });
    </script>
    <script src="../../scripts/committee.js"></script>
</body>
</html>

<?php 

?>