<?php 
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    // to update tree data
    if (isset($_POST['btnConfirmEdit'])) {
        $newTreeName = $_POST['itemNameEdit'];
        $newDescription = $_POST['itemDescriptionEdit'];
        $newPoints = $_POST['itemPointsEdit'];
        $newStock = $_POST['itemStockEdit'];
        $treeId = $_POST['itemIdEdit'];

        $sqlChange = "UPDATE items SET item_name = '$newTreeName', item_description = '$newDescription', item_redeem_points = '$newPoints', item_stock = '$newStock' WHERE item_id = '$treeId'";

        if (mysqli_query($conn, $sqlChange)) {
            ?>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        alert('update successfully');
                    // directly close pop
                    const itemPopUpOverlay = document.querySelector("#itemOverlay");
                    const itemPopUp = document.querySelector("#itemPopUp");
                    itemPopUpOverlay.style.display = 'none';
                    itemPopUp.style.display = 'none';
                    window.location.href='availableTreePage.php';
                    // reload();
                    })
                    
                </script>
                
            <?php
        }

        // to not direct header let the upper code execute first;
        if (mysqli_query($conn, $sqlChange)) {
            // header("Location: availableTreePage.php?updated=1");
            // exit();
        }
    }

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

        <div id="itemOverlay"></div>

        <div id="itemPopUp">
            <div class="popUpHeader">
                <div><button id='btnExitPopUp'><i class="fa-solid fa-arrow-left"></i></button></div>
                <div id="popUpHeaderText"><b id="editTreeText">Edit Tree</b></div>
            </div>
            <?php 

                // to assign integer to point and stock to prevent cannot be parsed or out of range
                $itemPoints = 0;
                $itemStocks = 0;

                $showPopUp = false;

                if(isset($_GET['editBtn']) ){
                    // set the flag to detect the pop up
                    $showPopUp = true;
                    $itemID = $_GET['targetItemID'];
                    $itemName = $_GET['targetItemName'];
                    $itemImage = $_GET['targetItemImage'];
                    $itemDescription = $_GET['targetItemDescription'];
                    $itemPoints = $_GET['targetRedeemPoints'];
                    $itemStocks = $_GET['targetStock'];
                    $itemUserID = $_GET['targetUserID']; 
                }
            ?>
            <form action='#' method='POST' class='popUpForm'>
                <div class='popUpShow'>
                    <div class='itemPopUpInput'>
                        <label for='itemNameEdit'>Tree Name:</label>
                        <input type='text' name='itemNameEdit' id='itemNameEdit' value='<?php echo "$itemName" ?>'>
                    </div>
                    <div class='itemPopUpInput'>
                        <label for='itemDescriptionEdit'>Tree Description</label>
                        <div>
                            <textarea name='itemDescriptionEdit' id='itemDescriptionEdit' rows='3' required><?php echo "$itemDescription" ?></textarea>
                        </div>
                    </div>
                    <div class='popUpNumberSelector itemPopUpInput'>
                        <div>
                            <label for='itemPointsEdit'>Points Required:</label>
                            <input type='number' name='itemPointsEdit' id='itemPointsEdit' value='<?php echo "$itemPoints" ?>' min='0'  max='1000' required>
                        </div>
                        <div>
                            <label for='itemStockEdit'>Tree Stocks:</label>
                            <input type='number' name='itemStockEdit' id='itemStockEdit' value='<?php echo "$itemStocks" ?>' min='0'  max='1000' required>
                        </div>
                    </div>
                    <input type='hidden' name='itemIdEdit' value='<?php echo "$itemID"?>'>
                    <!-- <div class='itemPopUpInput'>
                        <label>Tree Photo</label>
                        <img src="../../<?php echo $itemImage ?>" alt="Tree Image">
                        
                        <label for="changeTreePhoto">
                            <button>
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <p>Choose Image</p>
                            </button>
                        </label>
                        <input type="file" name="btnChangeTreePhoto" id="changeTreePhoto" hidden>
                    </div> -->
                    <div class='editConfirmButton'>
                        <button name='btnConfirmEdit' type='submit' value='Confirm' id='btnConfirmEdit'><i class="fa-solid fa-circle-check" style="color: #28a745;"></i>  Confirm</button>
                    </div>
                </div>
            </form>
            <div class='navToEditPhoto'>
                <button name="btnNavToEditPhoto" id="btnNavToEditPhoto">Change Tree Photo?</button>
            </div>
        </div>

        <div id="itemPopUp2">
            <div class="popUpHeader">
                <div><button id='btnBackEditItem'><i class="fa-solid fa-arrow-left"></i></button></div>
                <div id="popUpHeaderText"><b id="editTreeText">Edit Tree</b></div>
            </div>
            
                <div class='popUpShow'>
                    <div class='itemPopUpInput'>
                        <label>Tree Photo</label>
                        <img src="../../<?php echo $itemImage ?>" alt="Tree Image">
                        
                        <label for="changeTreePhoto">
                            <button>
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <p>Choose Image</p>
                            </button>
                        </label>
                        <input type="file" name="btnChangeTreePhoto" id="changeTreePhoto" hidden>
                    </div>
                   
                </div>
        </div>
    </main>
    <script>
        
        document.addEventListener('DOMContentLoaded', () => {
            const btnEditItem = document.querySelectorAll(".itemEditBtn");
            const itemPopUpOverlay = document.querySelector("#itemOverlay");
            const itemPopUp = document.querySelector("#itemPopUp");
            const treeCards = document.querySelectorAll(".treeCard");
            const btnExitPopUp = document.querySelector("#btnExitPopUp");
            const btnNavToEditPhoto = document.querySelector("#btnNavToEditPhoto");

            // to make the button unable to click when the status is inactive
            treeCards.forEach((treeCard) => {
                const itemStatus = treeCard.querySelector('.itemStatus');
                const statusText = itemStatus.innerText;
                const itemEditBtn = treeCard.querySelector(".itemEditBtn");
                const itemDeleteBtn = treeCard.querySelector(".itemDeleteBtn");

                if (statusText === "Inactive") {
                    itemEditBtn.classList.add("disableButton");
                    itemDeleteBtn.classList.add("disableButton");
                }
            })

            <?php if ($showPopUp) {?> 
                itemPopUpOverlay.style.display = 'block';
                itemPopUp.style.display = 'flex';
            <?php } ?>

            // close pop up page when the user click overlay
            itemPopUpOverlay.addEventListener("click", () => {
            itemPopUpOverlay.style.display = 'none';
            itemPopUp.style.display = 'none';
            // window.location.href = 'availableTreePage.php';
            reload();
            })

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

        btnExitPopUp.addEventListener("click", () => {
            reload();
        })

        const btnBackToEditItem = document.querySelector("#btnBackEditItem");
        const itemPopUp2 = document.querySelector("#itemPopUp2");

        btnNavToEditPhoto.addEventListener("click", () => {
            itemPopUp2.style.display = "flex";
            itemPopUp.style.display = "none";
        })


        btnBackToEditItem.addEventListener("click", () => {
            itemPopUp2.style.display = "none";
            itemPopUp.style.display = "flex";
        })

        const reload = () => {

            sessionStorage.setItem('selectedTreeStatus', '');
            sessionStorage.setItem('selectedTreeCreator', '');
            window.location.href = 'availableTreePage.php';
        }
            
        });

        // const treeStatus = document.getElementById("filterAvailableTreeStatus");

        // // check the session has record or not, if don't have record, will become null
        // const savedStatusValue = sessionStorage.getItem("selectedTreeStatus");
        // // if there have record, will asign it into the the selectbox value
        // if (savedStatusValue !== null) { 
        //     treeStatus.value = savedStatusValue;
        // }

        // // place the listener to listen if the sleect box has change or not, if change it will assign new data inyo session
        // // and the page will refresh due to this is submit type, the set value will become can get one
        // treeStatus.addEventListener('change', function() {
        //     sessionStorage.setItem('selectedTreeStatus', this.value);
        // });

        // const treeCreator = document.querySelector("#filterAvailableTreeCreator");
        // const savedCreatorValue = sessionStorage.getItem("selectedTreeCreator");
        // if (savedCreatorValue != null) {
        //     treeCreator.value = savedCreatorValue;
        // }
        
        // // only funcyion() have their this, arrow  function don;t have this (this refer to window), but can use function(e) or (e) => , and use the e.target.value
        // treeCreator.addEventListener('change', function() {
        //     sessionStorage.setItem("selectedTreeCreator", this.value);
        // });

        // btnExitPopUp.addEventListener("click", () => {
        //     reload();
        // })

        // const btnBackToEditItem = document.querySelector("#btnBackEditItem");

        // btnBackToEditItem.addEventListener("click", () => {

        // })

        // const reload = () => {

        //     sessionStorage.setItem('selectedTreeStatus', '');
        //     sessionStorage.setItem('selectedTreeCreator', '');
        //     window.location.href = 'availableTreePage.php';
        // }
    </script>
    <script src="../../scripts/committee.js"></script>
</body>
</html>

<?php 

?>