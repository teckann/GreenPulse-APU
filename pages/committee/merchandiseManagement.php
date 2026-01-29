<?php 
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    // to update merchandise data
    if (isset($_POST['btnConfirmEdit'])) {
        $newMerchandiseName = $_POST['itemNameEdit'];
        $newDescription = $_POST['itemDescriptionEdit'];
        $newPoints = $_POST['itemPointsEdit'];
        $newStock = $_POST['itemStockEdit'];
        $merchandiseId = $_POST['itemIdEdit'];

        $sqlChange = "UPDATE items SET item_name = '$newMerchandiseName', item_description = '$newDescription', item_redeem_points = '$newPoints', item_stock = '$newStock' WHERE item_id = '$merchandiseId'";

        if (mysqli_query($conn, $sqlChange)) {

            // record activity into logs
            addLog($conn, $userID, "Update Merchandise Information ($merchandiseId)");
            ?>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                    alert('update successfully');
                    // directly close pop
                    const itemPopUpOverlay = document.querySelector("#itemOverlay");
                    const itemPopUp = document.querySelector("#itemPopUp");
                    itemPopUpOverlay.style.display = 'none';
                    itemPopUp.style.display = 'none';
                    window.location.href='merchandiseManagement.php';
                    // reload();
                    })
                    
                </script>
                
            <?php
        }
    }

    if (isset($_POST['btnDeleteMerchandise'])) {
        $merchandiseID = $_POST['deleteMerchandiseID'];
        

        $sqlDelete = "UPDATE items SET item_status = 'Inactive' WHERE item_id = '$merchandiseID'";

        if (mysqli_query($conn, $sqlDelete)) { 

        // record actifivy into logs
        addLog($conn, $userID, "Delete Merchandise ($merchandiseID)");
            ?>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    alert('Merchandise deleted successfully');
                    const itemPopUpOverlay = document.querySelector("#itemOverlay");
                    const deletePopUp = document.querySelector("#itemPopUp3");
                    itemPopUpOverlay.style.display = 'none';
                    deletePopUp.style.display = 'none';
                    window.location.href='merchandiseManagement.php';
                });
            </script>
            <?php
        }
    }

        // to change the merchandise photo

    $sql = "SELECT * FROM items WHERE category = 'merchandise'";

    $search = '';
    $merchandiseStatus = '';
    $merchandiseCreatorStatus = '';

    // check is the search is used or not
    if (!empty($_GET["searchMerchandise"])) {
        $search = $_GET["searchMerchandise"];
    }

    //assign the filter value first
    if (!empty($_GET["filterAvailableMerchandiseStatus"])) {
        $merchandiseStatus = $_GET["filterAvailableMerchandiseStatus"];
    }
    if (!empty($_GET["filterAvailableMerchandiseCreator"])) {
        $merchandiseCreatorStatus = $_GET["filterAvailableMerchandiseCreator"];
    }

    if (!empty($search)) {
        $sql = "SELECT * FROM items WHERE item_name LIKE '%{$search}%' AND category = 'merchandise'";
    }
    else {
        if ($merchandiseStatus === "" && $merchandiseCreatorStatus === "") {
            $sql = "SELECT * FROM items WHERE category = 'merchandise'";
        }
        else if ($merchandiseStatus === "") {
            $sql = "SELECT * FROM items WHERE user_id = '$userID' AND category = 'merchandise'";
        }
        else if ($merchandiseCreatorStatus === "") {
            $sql = "SELECT * FROM items WHERE item_status = '$merchandiseStatus' AND category = 'merchandise'";
        }
        else {
            $sql = "SELECT * FROM items WHERE item_status = '$merchandiseStatus' AND user_id = '$userID' AND category = 'merchandise'";
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
    <title>Merchandise Management Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include("header.php"); ?>

    <main>
        <div id="fullPage">
            <div id="upperMerchandise">
                <div id="merchandiseManageText">
                    <h1 class="merchandisePageTitle">Merchandise Management <i class="fa-solid fa-bag-shopping"  style="color:#301A4B"></i></h1>
                    <p>Add new, manage available merchandise for user to redeem</p>
                </div>
                <button id="btnAddItem" name="btnAddItem"><span class="showDesktop">Add Merchandise</span><span class="showMobile"><i class="fa-solid fa-plus" style="color: white;"></i></span></button>
            </div>
            <hr>
            <div id="displayMerchandiseCard">
                <div id="upperMerchandiseCard">
                    <form action="" method="GET">
                        <div id="merchandiseSearchBar">
                            <i class="fa-solid fa-magnifying-glass" for="searchMerchandise" id="merchandiseSearchIcon"></i>
                            <input type="text" id="searchMerchandise" name="searchMerchandise" placeholder="Search Merchandise by Name">
                        </div>
                        <div id="filterBar">
                            <div>
                                <label for="filterAvailableMerchandiseStatus">Merchandise Status: </label>
                                <select name="filterAvailableMerchandiseStatus" id="filterAvailableMerchandiseStatus" class="filterMerchandise">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <div>
                                <label for="filterAvailableMerchandiseCreator">Merchandises Created by: </label>
                                <select name="filterAvailableMerchandiseCreator" id="filterAvailableMerchandiseCreator" class="filterMerchandise">
                                    <option value="">All Users</option>
                                    <option value="user">Me</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="showMerchandiseCardsSpace">
                    <div class="showMerchandiseCards">
                        <?php 
                            $merchandises = array();
                            while ($row = mysqli_fetch_assoc($result)) {
                                $merchandises[] = $row;
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
                                    <div class='merchandiseCard'>
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
                                                <img src='../../". $row['item_image'] ."' alt='merchandise image'>
                                            </div>
                                            <div class='itemInventory'>
                                                <div class='merchandisePoint'>
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
                                                <input type='hidden' name='targetUserID' id='merchandiseUserId' value='" . $row['user_id'] . "'>
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
                <div><button id='btnExitPopUp' class='btnExitPopUps'><i class="fa-solid fa-arrow-left"></i></button></div>
                <div id="popUpHeaderText"><b id="editMerchandiseText">Edit Merchandise</b></div>
            </div>
            <?php 

                // to assign integer to point and stock to prevent cannot be parsed or out of range
                $itemPoints = 0;
                $itemStocks = 0;

                $showPopUp = false;
                $showDeletePopUp = false;

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

                if (isset($_GET['deleteBtn'])) {
                    $showDeletePopUp = true;
                    $itemID = $_GET['targetItemID'];
                    $itemName = $_GET['targetItemName'];
                }

            ?>
            <!-- // edit item information -->
            <form action='#' method='POST' class='popUpForm'>
                <div class='popUpShow'>
                    <div class='itemPopUpInput createMerchandiseName'>
                        <label for='itemNameEdit'>Merchandise Name:</label>
                        <input type='text' name='itemNameEdit' id='itemNameEdit' value='<?php echo "$itemName" ?>'>
                    </div>
                    <div class='itemPopUpInput'>
                        <label for='itemDescriptionEdit'>Merchandise Description</label>
                        <div>
                            <textarea name='itemDescriptionEdit' id='itemDescriptionEdit' rows='3' required><?php echo "$itemDescription" ?></textarea>
                        </div>
                    </div>
                    <div class='popUpNumberSelector itemPopUpInput'>
                        <div>
                            <label for='itemPointsEdit'>Points Required:</label>
                            <input type='number' name='itemPointsEdit' id='itemPointsEdit' value='<?php echo "$itemPoints" ?>' min='0' required>
                        </div>
                        <div>
                            <label for='itemStockEdit'>Merchandise Stocks:</label>
                            <input type='number' name='itemStockEdit' id='itemStockEdit' value='<?php echo "$itemStocks" ?>' min='0' required>
                        </div>
                    </div>
                    <input type='hidden' name='itemIdEdit' value='<?php echo "$itemID"?>'>
                    <div class='editConfirmButton'>
                        <button name='btnConfirmEdit' type='submit' value='Confirm' id='btnConfirmEdit'><i class="fa-solid fa-circle-check" style="color: #28a745;"></i>  Confirm</button>
                    </div>
                </div>
            </form>
            <div class='navToEditPhoto'>
                <button name="btnNavToEditPhoto" id="btnNavToEditPhoto">Change Merchandise Photo?</button>
            </div>
        </div>

        <!-- // change item picture -->
        <div id="itemPopUp2">
            <div class="popUpHeader">
                <div><button id='btnBackEditItem' class='btnExitPopUps'><i class="fa-solid fa-arrow-left"></i></button></div>
                <div id="popUpHeaderText"><b id="changeItemPhotoText">Current Merchandise Photo</b></div>
            </div>
            
            <form action="../../backend/committeeUpdatePhoto.php" method="POST" enctype="multipart/form-data" class='popUpForm'>
                <div class='popUpShow merchandisePhotoEditPage'>
                    <img id="oldItemImage" src="../../<?php echo $itemImage ?>" alt="Merchandise Image">
                    

                    <input type="hidden" name="itemId" value="<?php echo $itemID ?>">
                    <div class="fileUploadPart">
                        <span class="attachPhotoText"><b>Please attach photo here</b></span>
                        <span class="uploadFileText">Upload one supported files (e.g. png, jpg, jpeg), Each file up to 5 MB in size.</span>
                        <input type="file" name="updateFile" id="fileChangeMerchandisePhoto">
                    </div>
                    <button type="submit" name="btnChangeMerchandisePhoto" class="btnChangeMerchandisePhoto">Update Merchandise Photo</button>
                    
                </div>
            </form>
        </div>

            <!-- // delete item -->
            <div id="itemPopUp3">
                <div class="popUpHeader">
                    <button id='btnExitDeletePopUp' class='btnExitPopUps'><i class="fa-solid fa-arrow-left"></i></button>
                    <div id="popUpHeaderText"><b id="deleteItemText">Delete Merchandise Page</b></div>
                </div>
            
                <form action="#" method="POST" class='popUpForm'>
                    <div class='popUpShow deleteMerchandisePage'>
                        <div class="allDeleteInfo">
                            <input type="hidden" value="<?php echo $itemID ?>" name="deleteMerchandiseID">
                            <div class="askForDelete">
                                <p>Do you want to delete the merchandise?</p>
                            </div>
                            <div class="deleteMerchandiseInfo">
                                <div>
                                    <p><b>Merchandise's information</b></p>
                                    <p>Merchandise ID: <?php echo $itemID ?></p>
                                    <p>Merchandise Name: <?php echo $itemName ?> </p>
                                </div>
                            </div>
                            <hr>
                            <div class="statusDeleteInfo">
                                <p>The merchandise status will be changed from:</p>
                                <p class="deleteStatusChangeText"><span style="color: green;">Active</span> <i class="fa-solid fa-arrow-right"></i> <span style="color: red;">Inactive</span></p>
                                <p>You are not allowed to reactive the merchandise unless with the help of system admin.</p>
                            </div>
                        </div>
                        <div class="deleteItemBtns">
                            <button type="submit" name="btnDeleteMerchandise" class="btnDeleteMerchandise">Delete Merchandise</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- create new available mercahndise -->
             <div id="itemPopUp4">
                <div class="popUpHeader">
                    <button id='btnExitCreateNewItemPopUp' class='btnExitPopUps'><i class="fa-solid fa-arrow-left"></i></button>
                    <div id="popUpHeaderText"><b id="createItemText">Add New Available Merchandise</b></div>
                </div>
            
                <form action="../../backend/committeeCreateMerchandise.php" method="POST" enctype="multipart/form-data" class='popUpForm'>
                    <div class='popUpShow createItemPage'>
                        <div class="createItem">
                            <div class="createItemNamePart">
                                <label for="createItemName"><b>Merchandise Name</b></label>
                                <input type="text" id="createItemName" name="createItemName" class="createItemName" placeholder="e.g. Eco NoteBook" required>
                            </div>
                            <div class="createItemNumbersPart">
                                <div>
                                    <label for="createItemPoints"><b>Points<br>Required</b></label>
                                    <input type="number" name="createItemPoints" id="createItemPoints" min='0' required>
                                </div>
                                <div>
                                    <label for="createItemStock"><b>Stock</b></label>
                                    <input type="number" name="createItemStock" id="createItemStock" min='0' required>
                                </div>
                            </div>
                            <div class="createItemDescriptionPart">
                                <label for="createItemDescripton"><b>Description</b></label>
                                <textarea name="createItemDescription" id="createItemDescription" placeholder="e.g. Eco notebook made from recycled paper." required rows="5"></textarea>
                            </div>
                            <div class="createItemPhotoPart">
                                <label for="createItemPhoto"><b>Item Photo</b></label>
                                <input type="file" name="createItemPhoto" id="createItemPhoto" required>
                            </div>
                        </div>
                        <div class="createItemButtonPart">
                            <button type="submit" name="btnCreateMerchandise" class="btnCreateMerchandise">Create Merchandise</button>
                        </div>
                    </div>
                </form>
            </div>
    </main>
    <script>
        
        document.addEventListener("DOMContentLoaded", () => {
            const btnEditItem = document.querySelectorAll(".itemEditBtn");
            const itemPopUpOverlay = document.querySelector("#itemOverlay");
            const itemPopUp = document.querySelector("#itemPopUp");
            const merchandiseCards = document.querySelectorAll(".merchandiseCard");
            const btnExitPopUp = document.querySelector("#btnExitPopUp");
            const btnNavToEditPhoto = document.querySelector("#btnNavToEditPhoto");
            const btnExitDelete = document.querySelector("#btnExitDelete");
            const itemDeletePopUp = document.querySelector("#itemPopUp3");
            const btnExitDeleteItem = document.querySelector("#btnExitDeletePopUp");
            const btnAddNewItem = document.querySelector("#btnAddItem");
            const itemCreatePopUp = document.querySelector("#itemPopUp4");
            const btnExitCreateItem = document.querySelector("#btnExitCreateNewItemPopUp");
            

            // to make the button unable to click when the status is inactive
            merchandiseCards.forEach((merchandiseCard) => {
                const itemStatus = merchandiseCard.querySelector('.itemStatus');
                const statusText = itemStatus.innerText;
                const itemEditBtn = merchandiseCard.querySelector(".itemEditBtn");
                const itemDeleteBtn = merchandiseCard.querySelector(".itemDeleteBtn");
                const merchandiseUserId = merchandiseCard.querySelector("#merchandiseUserId").value;

                if ((statusText === "Inactive") || (merchandiseUserId !== <?php echo json_encode($userID) ?>)) {
                    itemEditBtn.classList.add("disableButton");
                    itemDeleteBtn.classList.add("disableButton");
                }
            })

            <?php if ($showPopUp) {?> 
                itemPopUpOverlay.style.display = 'block';
                itemPopUp.style.display = 'flex';
                btnAddNewItem.style.display = "none";
            <?php } ?>

            <?php if ($showDeletePopUp) {?>
                itemPopUpOverlay.style.display = 'block';
                itemDeletePopUp.style.display = 'flex';
                btnAddNewItem.style.display = "none";
            <?php } ?>

            // close pop up page when the user click overlay
            itemPopUpOverlay.addEventListener("click", () => {
            // itemPopUpOverlay.style.display = 'none';
            // itemPopUp.style.display = 'none';
            // window.location.href = 'availableTreePage.php';
            reload();
            })

            const merchandiseStatus = document.getElementById("filterAvailableMerchandiseStatus");

        // check the session has record or not, if don't have record, will become null
        const savedStatusValue = sessionStorage.getItem("selectedMerchandiseStatus");
        // if there have record, will asign it into the the selectbox value
        if (savedStatusValue !== null) { 
            merchandiseStatus.value = savedStatusValue;
        }

        // place the listener to listen if the sleect box has change or not, if change it will assign new data inyo session
        // and the page will refresh due to this is submit type, the set value will become can get one
        merchandiseStatus.addEventListener('change', function() {
            sessionStorage.setItem('selectedMerchandiseStatus', this.value);
        });

        const merchandiseCreator = document.querySelector("#filterAvailableMerchandiseCreator");
        const savedCreatorValue = sessionStorage.getItem("selectedMerchandiseCreator");
        if (savedCreatorValue != null) {
            merchandiseCreator.value = savedCreatorValue;
        }
        
        // only funcyion() have their this, arrow  function don;t have this (this refer to window), but can use function(e) or (e) => , and use the e.target.value
        merchandiseCreator.addEventListener('change', function() {
            sessionStorage.setItem("selectedMerchandiseCreator", this.value);
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
            sessionStorage.setItem('selectedMerchandiseStatus', '');
            sessionStorage.setItem('selectedMerchandiseCreator', '');
            window.location.href = 'merchandiseManagement.php';
        }

        const btnUpdateMerchandisePhoto = document.querySelector(".btnChangeMerchandisePhoto");
        const btnFileChangeMerchandisePhoto = document.querySelector("#fileChangeMerchandisePhoto");

        // font give the button unable at first
        btnUpdateMerchandisePhoto.classList.add("disableButton");
        

        btnFileChangeMerchandisePhoto.addEventListener("change", () => {
            if (btnFileChangeMerchandisePhoto.value !== "") {
                btnUpdateMerchandisePhoto.classList.remove("disableButton");
            }
            else {
                btnUpdateMerchandisePhoto.classList.add("disableButton");
            }
        })
        
        btnExitDeleteItem.addEventListener("click", () => {
            reload();
        });

        // to open create new merchandise page
        btnAddNewItem.addEventListener("click", () => {
            itemCreatePopUp.style.display = "flex";
            itemPopUpOverlay.style.display = "block";
            btnAddNewItem.style.display = "none";
        });

        btnExitCreateItem.addEventListener("click", () => {
            reload();
        });

        });

        
    </script>
    <script src="../../scripts/committee.js"></script>
    <?php include ("hamburgerMenu.php");?>
</body>
</html>