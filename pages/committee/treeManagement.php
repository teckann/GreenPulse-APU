<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include("header.php"); ?>

    <main>
        <div id="upperTree">
            <div id="treeManageText">
                <h1>Tree Management <i class="fa-solid fa-tree" style="color: #228B22;"></i></h1>
                <p>Add new, manage available tree adoption for volunteers to redeem</p>
            </div>
            <button><span class="showDesktop" name="addTreeButton">Add Tree</span><span class="showMobile"><i class="fa-solid fa-plus" style="color: white;"></i></span></button>
        </div>
        <div id="showTreeClass">
            <button id="availableTree" class="treeClass">
                <i class="fa-solid fa-circle-check" style="color: #28a745;"></i>
                <p><b>Available Tree</b></p>
            </button>
            <button id="adoptedTree" class="treeClass">
                <i class="fa-solid fa-house" style="color: #2e8b57;"></i>
                <p><b>Adopted Tree</b></p>
            </button>
        </div>
        <div id="displayTreeCard">
            <div id="upperTreeCard">
                <div id="treeSearchBar">
                    <i class="fa-solid fa-magnifying-glass" for="searchTree" id="treeSearchIcon"></i>
                    <input type="text" id="searchTree" name="searchTree" placeholder="Search Tree by Name">
                </div>
                <div id="filterBar">
                    <div>
                        <label for="filterAvailableTreeStatus">Tree Status: </label>
                        <select name="filterAvailableTreeStatus" id="filterAvailableTreeStatus">
                            <option value="All Status">All Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div>
                        <label for="filterAvailableTreeCreator">Trees Created by: </label>
                        <select name="filterAvailableTreeCreator" id="filterAvailableTreeCreator">
                            <option value="all">All Users</option>
                            <option value="user">Me</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="showTreeCards"></div>
        </div>
    </main>
    <script src="../../scripts/committee.js"></script>
</body>
</html>

<?php 

?>