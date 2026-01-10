<?php 
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

    $sql = "SELECT * from items";

    if (!empty($_GET["filterAvailableTreeStatus"])) {
        $status = $_GET["filterAvailableTreeStatus"];
    }
    
    $isStatus = empty($_GET['searchTree']);
    $isCreater = empty($_GET["filterAvailableTreeCreator"]);

    $search = "";
    if (!$isStatus) {
        $search = $_GET['searchTree'];
        $sql = "SELECT * from items where item_name like '%{$search}%'";
    }
    elseif (!$isStatus && !$isCreater) {
        $sql = "SELECT * from items where item_status = '$status' and user_id = '$userID'";
    }
    elseif ($isStatus && !$isCreater) {
        $sql = "SELECT * from items where user_id = '$userID'";
    }
    else if (!$isStatus && $isCreator) {
        $sql = "SELECT * from items where item_status = '$status";
    }

    $sql = "SELECT * from items where item_name like '%{$search}%'";
    $result = mysqli_query($conn, $sql);

    $trees = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $trees[] = $row;
    }
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
            <!-- <form action="" method="GET"> -->
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
            <!-- </form> -->
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

                ?>
            </div>
        </div>
    </main>
    <script src="../../scripts/committee.js"></script>
</body>
</html>

<?php 

?>