<?php 
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    $sql = "SELECT * FROM tree_adoption_history T ";

    $search = '';
    $treeStatus = '';
    $treeCreatorStatus = '';

    // check is the search is used or not
    if (!empty($_GET["searchTree"])) {
        $search = $_GET["searchTree"];
    }

    $treeTypeStatus ='';

    // use status to detect the popup
    $updateItemPopUp = false;
    
    

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
        $sql = "SELECT *, T.user_id AS adoptionUserId, I.user_id AS itemUserId FROM tree_adoption_history T INNER JOIN items I ON T.item_id = I.item_id  WHERE given_name LIKE '%{$search}%'";
    }
    else {
        if ($treeStatus === "" && $treeTypeStatus === "") {
            $sql = "SELECT *, T.user_id AS adoptionUserId, I.user_id AS itemUserId FROM tree_adoption_history T INNER JOIN items I ON T.item_id = I.item_id WHERE category = 'tree'";
             ?>
                <!-- <script>alert('hihi');</script> -->
            <?php
        }
        else if ($treeStatus === "") {

            ?>
                <!-- <script>alert('hihi');</script> -->
            <?php
            $sql = "SELECT *, T.user_id AS adoptionUserId, I.user_id AS itemUserId FROM tree_adoption_history T INNER JOIN items I ON T.item_id = I.item_id WHERE I.item_name = '$treeTypeStatus' AND category = 'tree'";
        }
        else if ($treeTypeStatus === "") {
            $sql = "SELECT *, T.user_id AS adoptionUserId, I.user_id AS itemUserId FROM tree_adoption_history T INNER JOIN items I ON T.item_id = I.item_id WHERE T.tree_adoption_status = '$treeStatus' AND category = 'tree'";
        }
        else {
            $sql = "SELECT *, T.user_id AS adoptionUserId, I.user_id AS itemUserId FROM tree_adoption_history T INNER JOIN items I ON T.item_id = I.item_id WHERE I.item_name = '$treeTypeStatus' AND T.tree_adoption_status = '$treeStatus' AND category = 'tree'";
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
                            // $trees = array();
                            $counter = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $counter += 1;
                                $rowStatus = $row["tree_adoption_status"];
                                $statusColor = "";
                                if ($rowStatus == "Planted") {
                                    $statusColor = "#A8E6A3";
                                }
                                    else if ($rowStatus == "Germinating") {
                                    $statusColor = "#4DB6AC";
                                }
                                else if ($rowStatus == "Growing") {
                                    $statusColor = "#43A047";
                                }
                                else if ($rowStatus == "Mature") {
                                    $statusColor = "#1B5E20";
                                }
                                else if ($rowStatus == "Diseased") {
                                    $statusColor = "#FB8C00";
                                }
                                else {
                                    $statusColor = "red";
                                }

                                // $targetID = $row
                                $findUser = "SELECT * FROM users WHERE user_id = '{$row['adoptionUserId']}'";
                                $userResult = mysqli_query($conn, $findUser);
                                $userName = mysqli_fetch_assoc($userResult)['name'];
                                $treeType = $row["itemUserId"];

                                $adoptDate = date("d M Y", strtotime($row['tree_adoption_date']));

                                $fertilizeInDB = $row['fertilization_datetime'];
                                $showFertilizeText = "";

                                $todayTimeStamp = time();
                                if (!empty($fertilizeInDT) && $fertilizeInDB !== '0000-00-00 00:00:00') {
                                    $fertilizeDT = strtotime($fertilizeInDB); 
                                    if (date('Y-m-d', $fertilizeInDT) === date('Y-m-d', $nowDT)) {
                                        // if today fertilized
                                        $showFertilizeText = "Today, " . date('H:i', $fertilizeDT);
                                    } 
                                    else {
                                        // if in different day
                                        $showFertilizeText = date('d M Y, H:i', $fertilizeDT);
                                    }
                                } else {
                                    $showFertilizeText = '-'; // No fertilization date
                                }

                                $adoptionTimeStamp = strtotime($row["tree_adoption_date"]);

                                $adoptionYear = date("Y", $adoptionTimeStamp);
                                $currentYear = date("Y", $todayTimeStamp);

                                $age = $currentYear - $adoptionYear;
                                $treeAgeDisplayText = "";
                                if ($age > 1) {
                                    $treeAgeDisplay = $age . " Years old";
                                }
                                else if ($age == 1) {
                                    $treeAgeDisplay = $age . " Year old";
                                }
                                else {
                                    $treeAgeDisplay = "Less than 1 year old.";
                                }



                                echo "
                                    <div class='treeCard' id='treeCardAdoptedTree'>
                                        <div class='upItemCard'>
                                            <div>
                                                <div>
                                                    <b class='itemId'>" . $row["tree_adoption_id"] . "</b>
                                                </div>
                                                <div>
                                                    <p class='itemName'>" . $row["item_name"] ."</p>
                                                </div>
                                            </div>
                                            <div class='itemStatusContainer'>
                                                <p class='itemStatus' style='background-color: ". $statusColor ."'>". $row["tree_adoption_status"] ."</p>
                                            </div>
                                        </div>
                                        <div class='middleItemCard' id='middleItemCardAdoptedTree'>
                                            <div class='itemImage'>
                                                <img src='../../". $row['item_image'] ."' alt='tree image'>
                                            </div>
                                            <div class='itemRelatedInfo'>
                                                <div class='givenName'>
                                                    <b>Given Name:</b>
                                                    <p>" . $row['given_name'] . "</p>
                                                </div>
                                                <div class='age'>
                                                    <b>Tree Age:</b>
                                                    <p>" . $treeAgeDisplay . "</p>
                                                </div>
                                                <div class='userName'>
                                                    <b>Last Fertilized:</b>
                                                    <p>" . $showFertilizeText . "</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='itemInfo'>
                                            <div class='owner'>
                                                <b>Adopted by:</b>
                                                <p>" . $userName . "</p>
                                            </div>
                                            <div class='itemUploadInfo'>
                                                <p><i>Adopted At " . $adoptDate . "</i></p>
                                            </div>
                                        </div>
                                        <div class='itemButton'>
                                            <form action='#' method='GET'>
                                                <input type='hidden' name='targetItemID' value='" . $row['item_id'] . "'>
                                                <input type='hidden' name='targetTreeAdoptionStatus' value='" . $row['tree_adoption_status'] . "'>
                                                <button type='submit' name='btnUpdateStatus' class='adoptedUpdateStatusBtn'>Update Status</button>
                                                <button type='submit' name='btnMarkAsFertilized' class='markAsFertilizedBtn'>Mark as Fertilized</button>
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

        <?php
            if (isset($_GET["btnUpdateStatus"])) {
                $treeStatus = $_GET["targetTreeAdoptionStatus"];
                $adoptedTreeId = $_GET["targetItemID"];
                ?>
                    <script>
                        // const 
                    </script>
                <?php
            }
        ?>

        <div id="itemPopUp">
            <div class="popUpHeader">
                <div><button id='btnExitPopUp' class='btnExitPopUps'><i class="fa-solid fa-arrow-left"></i></button></div>
                <div id="popUpHeaderText"><b id="editTreeText"></b></div>

                
            </div>
            <?php 

                

            ?>
            <!-- // edit item information -->
            <form action='#' method='POST' class='popUpForm'>
                <div class='popUpShow'>
                    <div class='itemPopUpInput'>
                        <label for='itemNameEdit'>Tree Name:</label>
                        <select name="adoptedUpdateStatusSelector" id="adoptedUpdateStatusSelector">
                            <option value="">All Status</option>
                            <option value="Planted">Planted</option>
                            <option value="Germinating">Germinating</option>
                            <option value="Growing">Growing</option>
                            <option value="Mature">Mature</option>
                            <option value="Diseased">Diseased</option>
                            <option value="Dead">Dead</option>
                        </select>
                    </div>
                    <?php   if (isset($_GET["btnUpdateStatus"])) { ?>
                    <script>
                        const statusSelector = document.querySelector("#adoptedUpdateStatusSelector");
                        statusSelector.value = "<?php echo $treeStatus; ?>";
                    </script>
                    <?php  } ?>
                    <input type='hidden' name='itemIdEdit' value='<?php echo "$adoptedTreeID"?>'>
                    <div class='editConfirmButton'>
                        <button name='btnConfirmEdit' type='submit' value='Confirm' id='btnConfirmEdit'><i class="fa-solid fa-circle-check" style="color: #28a745;"></i>  Confirm</button>
                    </div>
                </div>
            </form>
            <div class='navToEditPhoto'>
                <button name="btnNavToEditPhoto" id="btnNavToEditPhoto">Change Tree Photo?</button>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const treeStatus = document.getElementById("filterAvailableTreeStatus");
                const popUpOverlay = document.querySelector("#itemOverlay");
                const itemPopUp1 = document.querySelector("#itemPopUp");

                // check the session has record or not, if don't have record, will become null
                const savedStatusOfTree = sessionStorage.getItem("selectedTreeStatus");
                // if there have record, will asign it into the the selectbox value
                if (savedStatusOfTree !== null) { 
                    treeStatus.value = savedStatusOfTree;
                }

                treeStatus.addEventListener('change', function() {
                    sessionStorage.setItem('selectedTreeStatus', this.value);
                });

                const treeType = document.getElementById("filterAvailableTreeType");

                const savedTreeType = sessionStorage.getItem("selectedTreeType");

                if (savedTreeType != null) {
                    treeType.value = savedTreeType;
                }

                treeType.addEventListener("change", function() {
                    sessionStorage.setItem('selectedTreeType', this.value);
                })

                const treeCards = document.querySelectorAll(".treeCard");

                treeCards.forEach((treeCard) => {
                const itemStatus = treeCard.querySelector('.itemStatus');
                const statusText = itemStatus.innerText;
                const updateStatusBtn = treeCard.querySelector(".adoptedUpdateStatusBtn");
                const markAsFertilizeBtn = treeCard.querySelector(".markAsFertilizedBtn");

                if (statusText === "Dead") {
                    updateStatusBtn.classList.add("disableButton");
                    markAsFertilizeBtn.classList.add("disableButton");
                }

                updateStatusBtn.addEventListener("click", () => {
                    popUpOverlay.style.display = "block";
                    itemPopUp1.style.display = "flex";
                })
            })

            popUpOverlay.addEventListener("click", () => {
                reload();
            })

            const reload = () => {
                sessionStorage.setItem('selectedTreeStatus', '');
                sessionStorage.setItem('selectedTreeType', '');
                window.location.href = 'adoptedTreePage.php';
            }
        });
        </script>
        <script src="../../scripts/committee.js"></script>
</body>
</html>