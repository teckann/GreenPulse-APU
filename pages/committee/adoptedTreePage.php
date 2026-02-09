<?php 
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    $sql = "SELECT * FROM tree_adoption_history T";

    $search = '';
    $treeStatus = '';
    $treeCreatorStatus = '';

    // check is the search is used or not
    if (!empty($_GET["searchTree"])) {
        $search = $_GET["searchTree"];
    }

    if (isset($_POST["btnConfirmUpdate"])) {
        $updateTreeId = $_POST["targetItemIdUpdate"];
        $newStatus = $_POST["adoptedUpdateStatusSelector"];
        $updateTreeName = $_POST["targetUpdateItemName"];

        $sqlUpdateStatus = "UPDATE tree_adoption_history SET tree_adoption_status = '$newStatus' WHERE tree_adoption_id = '$updateTreeId'";

        if (mysqli_query($conn, $sqlUpdateStatus)) {
            addLog($conn, $userID, "Change Tree Status ($updateTreeId)");
            echo "<script>
            alert('{$updateTreeName}s status is changed to $newStatus');
            window.location.href='adoptedTreePage.php';
            </script>";
        }
        else {
            echo "<script>alert('{$updateTreeName}s status cannot be changed, please try again');</script>";
        }
    }

    if (isset($_GET["btnMarkAsFertilized"])) {
        $fertilizeItemId = $_GET['targetItemID'];
        $sqlFertilize = "UPDATE tree_adoption_history SET fertilization_datetime = NOW() WHERE tree_adoption_id = '$fertilizeItemId'";

        if (mysqli_query($conn, $sqlFertilize)) {
            addLog($conn, $userID, "Fertilize Tree ($fertilizeItemId)");
        }
    }

    if (isset($_POST["btnMarkAllFertilizedItem"])) {

        $sqlUpdateRestOfTree = "UPDATE tree_adoption_history SET fertilization_datetime = NOW() WHERE ( fertilization_datetime IS NULL OR fertilization_datetime < CURRENT_DATE()) AND tree_adoption_status != 'DEAD'";

        if (mysqli_query($conn, $sqlUpdateRestOfTree)) {
            ?>
                <script>
                    alert('Successfully marked all as fertilized.');
                    window.location.href = "adoptedTreePage.php";
                </script>
            <?php
            addLog($conn, $userID, "Fertilize All Trees");
        }
    }

    // use status to detect the popup
    $updateItemPopUp = false;
    
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
                <form action="#" method="POST">
                    <button id="btnMarkAllFertilized" name="btnMarkAllFertilizedItem"><span class="showDesktop">Mark All As Fertilized</span><span class="showMobile">Fertilize<br>All  <i class="fa-solid fa-flask"></i></span></button>
                </form>
            </div>
            <div id="showTreeClass">
                <button id="btnAvailableTree" class="treeClass">
                    <a href="availableTreePage.php" style="text-decoration: none;">
                        <i class="fa-solid fa-circle-check" style="color: #28a745;"></i>
                        <p><b>Available Tree</b></p>
                    </a>
                </button>
                <button id="btnAdoptedTree" class="treeClass selectedButton">
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
                                    $statusColor = "#B02E0C";
                                }

                                // $targetID = $row
                                $findUser = "SELECT * FROM users WHERE user_id = '{$row['adoptionUserId']}'";
                                $userResult = mysqli_query($conn, $findUser);
                                $userName = mysqli_fetch_assoc($userResult)['name'];
                                $treeType = $row["itemUserId"];

                                $adoptDate = date("d M Y", strtotime($row['tree_adoption_datetime']));

                                $fertilizeInDT = $row['fertilization_datetime'];
                                $showFertilizeText = "";

                                $todayTimeStamp = time();

                                // $fertilizeButtonUsed = false;
                                if (!empty($fertilizeInDT) && $fertilizeInDT !== '0000-00-00 00:00:00') {
                                    $fertilizeDT = strtotime($fertilizeInDT); 
                                    if (date('Y-m-d', strtotime($fertilizeInDT)) === date('Y-m-d', $todayTimeStamp)) {
                                        // if today fertilized
                                        $showFertilizeText = "Today, " . date('H:i', $fertilizeDT);
                                        // change the color of button status
                                        // $fertilizeButtonUsed = true;
                                    } 
                                    else {
                                        // if in different day
                                        $showFertilizeText = date('d M Y, H:i', $fertilizeDT);
                                    }
                                } else {
                                    $showFertilizeText = '-'; // No fertilization date
                                }

                                $adoptionTimeStamp = strtotime($row["tree_adoption_datetime"]);

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
                                                    <p class='fertilizeText'>" . $showFertilizeText . "</p>
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
                                                <input type='hidden' name='targetItemID' value='" . $row['tree_adoption_id'] . "'>
                                                <input type='hidden' name='targetTreeAdoptionStatus' value='" . $row['tree_adoption_status'] . "'>
                                                <input type='hidden' name='targetTreeAdoptionName' value='" . $row['given_name'] . "'>
                                                <button type='submit' name='btnUpdateStatus' class='adoptedUpdateStatusBtn'>Update Status</button>
                                                <button type='submit' name='btnMarkAsFertilized' class='markAsFertilizedBtn'>Mark as Fertilized</button>
                                            </form>
                                        </div>
                                    </div>";
                                    // change the fertilized button color
                                //     if ($fertilizeButtonUsed) {
                                
                                    // <script>
                                    //     const treeCards = querySelectorAll(".treeCard");
                                    //     forEach((each) => {
                                    //         const markAsFertilizedButton = each.querySelector(".markAsFertilizedBtn");
                                    //         const buttonText = markAsFertilizedButton.innerText;
                                    //         if (buttonText.startsWith("Today")) {
                                    //             markAsFertilizedButton.style.backgroundColor = "Gray";
                                    //             markAsFertilizedButton.classList.add("disableButton");
                                    //         }
                                    //     })
                                    // </script>
                                
                            // }
                            }
                        ?>                
                    </div>
                </div>
            </div>
        </div>

        <script>
            const treeCards = document.querySelectorAll(".treeCard");
            treeCards.forEach((each) => {
                const markAsFertilizedButton = each.querySelector(".markAsFertilizedBtn");
                const fertilize = each.querySelector(".fertilizeText");
                const fertilizeText = fertilize.innerText;
                if (fertilizeText.startsWith("Today")) {
                    markAsFertilizedButton.style.backgroundColor = "Gray";
                    markAsFertilizedButton.classList.add("disableButton");
                }                
            })

            let canUse = false;
            const markAllAsFertilizedButton = document.querySelector("#btnMarkAllFertilized");
            counter = 0;
            treeCards.forEach((each) => {
                counter ++;
                const fertilize = each.querySelector(".fertilizeText");
                const fertilizeText = fertilize.innerText;
                const status = each.querySelector(".itemStatus");
                const statusText = status.innerText;
                if (!fertilizeText.startsWith("Today") && !(statusText == "Dead")) {
                    canUse = true;
                }
            });

            if (!canUse) {
                markAllAsFertilizedButton.style.backgroundColor = "gray";
                markAllAsFertilizedButton.classList.add("disableButton");
            }
        </script>

        <div id="itemOverlay"></div>

        <?php
            if (isset($_GET["btnUpdateStatus"])) {
                
                $treeStatus = $_GET["targetTreeAdoptionStatus"];
                $adoptedTreeId = $_GET["targetItemID"];
                $targetTreeName = $_GET["targetTreeAdoptionName"];
            }
        ?>

        <div id="itemPopUp">
            <div class="popUpHeader">
                <div><button id='btnExitPopUp' class='btnExitPopUps'><i class="fa-solid fa-arrow-left"></i></button></div>
                <div id="popUpHeaderText"><b id="changeAdoptionTreeStatus">Update Adopted status</b></div>

                
            </div>
            <!-- // edit item information -->
            <form action='#' method='POST' class='popUpForm popUpFormStatus'>
                <div class='popUpShow'>
                    <div class ='showCurrentStatus'>
                        <b><?php echo $targetTreeName ?>'s Current Status:</b><br>
                        <p><?php echo $treeStatus ?></p>
                        <hr>
                    </div>
                    <div class='itemPopUpInput updateAdoptedTreeStatusPart'>
                        <label for='adoptedUpdateStatusSelector'>New Status</label>
                        <select name="adoptedUpdateStatusSelector" id="adoptedUpdateStatusSelector">
                            <option value="Planted">Planted</option>
                            <option value="Germinating">Germinating</option>
                            <option value="Growing">Growing</option>
                            <option value="Mature">Mature</option>
                            <option value="Diseased">Diseased</option>
                            <option value="Dead">Dead</option>
                        </select>
                    </div>
                    <?php   if (isset($_GET["btnUpdateStatus"])) {
                        $updateItemPopUp = true;
                    ?>
                    <script>
                        const statusSelector = document.querySelector("#adoptedUpdateStatusSelector");
                        statusSelector.value = "<?php echo $treeStatus; ?>";
                    </script>
                    <?php  } ?>
                    <input type="hidden" name="targetUpdateItemName" value=' <?php echo $targetTreeName ?>"'>
                    <input type='hidden' name='targetItemIdUpdate' value='<?php echo "$adoptedTreeId"?>'>
                    <div class='updateConfirmButton'>
                        <button name='btnConfirmUpdate' type='submit' value='Confirm' id='btnConfirmUpdate'><i class="fa-solid fa-circle-check" style="color: #28a745;"></i>  Confirm</button>
                    </div>
                </div>
            </form>
        </div>



        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const treeStatus = document.getElementById("filterAvailableTreeStatus");
                const popUpOverlay = document.querySelector("#itemOverlay");
                const itemPopUp1 = document.querySelector("#itemPopUp");
                const btnExitPopUp = document.querySelector("#btnExitPopUp");
                const btnMarkAllFertilized = document.querySelector("#btnMarkAllFertilized");

                // check the session has record or not, if don't have record, will become null
                const savedStatusOfTree = sessionStorage.getItem("selectedAdoptTreeStatus");
                // if there have record, will asign it into the the selectbox value
                if (savedStatusOfTree !== null) { 
                    treeStatus.value = savedStatusOfTree;
                }

                treeStatus.addEventListener('change', function() {
                    sessionStorage.setItem('selectedAdoptTreeStatus', this.value);
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
                    updateStatusBtn.classList.add("notUseButton");
                    markAsFertilizeBtn.classList.add("notUseButton");
                }
            })

            popUpOverlay.addEventListener("click", () => {
                reload();
            })

            btnExitPopUp.addEventListener("click", () => {
                reload();
            })

            <?php if ($updateItemPopUp) { ?>
                popUpOverlay.style.display = "block";
                itemPopUp1.style.display = "flex";
                btnMarkAllFertilized.style.display = "none";
            <?php } ?>
        });

        const reload = () => {
            sessionStorage.setItem('selectedAdoptTreeStatus', '');
            sessionStorage.setItem('selectedTreeType', '');
            window.location.href = 'adoptedTreePage.php';
        }
        </script>
        <script src="../../scripts/committee.js"></script>

        <?php include ("hamburgerMenu.php");?>
</body>
</html>