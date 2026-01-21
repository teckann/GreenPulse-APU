<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    $sql = "SELECT * FROM items";

    if (isset($_GET["btnSearch"])) {
        $target = $_GET["target"];

        $sql = "SELECT * FROM items WHERE item_name LIKE '%{$target}%'";
    }

    if (isset($_GET["btnChangeStatus"])) {
        $targetItemID = $_GET["target_itemID"];
        $nextStatus = $_GET["next_status"];

        $sql_updateStatus = "UPDATE items SET item_status = '$nextStatus' 
                             WHERE item_id = '$targetItemID'";
    
        if(mysqli_query($conn, $sql_updateStatus)) {
            echo "<script>
                    alert('--- Successfully Updated Item Status ---\\nItem ID: $targetItemID\\nNew Status: $nextStatus');
                    window.location.href = 'manageItems.php';
                    </script>";
        }
    }

    $currentCategory = "";
    $currentStatus = "";

    if (isset($_GET["txtCategory"]) || isset($_GET["txtStatus"])) {
        $category = $_GET["txtCategory"];
        $status = $_GET["txtStatus"];

        $currentCategory = $category;
        $currentStatus = $status;

        if (!empty($category) && !empty($status)) {
            $sql = "SELECT * FROM items
                    WHERE category = '$category' AND item_status = '$status'";
        }
        elseif (!empty($category)) {
            $sql = "SELECT * FROM items
                    WHERE category = '$category'";
        }
        elseif (!empty($status)) {
            $sql = "SELECT * FROM items
                    WHERE item_status = '$status'";
        }
    }

    $result = mysqli_query($conn, $sql);

    $items = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Items</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Manage Items</h1>
            <h2 class="page-subTitle">Overview of all posted items</h2>

            <div class="action-bar" style="margin: 1em 0;">
                <form action="" method="GET">
                    <div class="table-search-box">
                        <input type="text" name="target" placeholder="Search user here">
                        <i class="fa-solid fa-magnifying-glass"></i>

                        <button name="btnSearch" type="submit" value="Search" class="table-btnSearch" title="Search"></button>
                    </div>
                </form>

                <form action="" method="GET" class="select-container" id="item-form">
                    <div class="select-boxs">
                        <div>
                            <label for="itemCategory">Category: </label>
                            <select name="txtCategory" id="itemCategory">
                                <option value="" <?php if($currentCategory === "") echo "selected" ?>>All</option>
                                <option value="merchandise" <?php if($currentCategory === "merchandise") echo "selected" ?>>Merchandise</option>
                                <option value="tree" <?php if($currentCategory === "tree") echo "selected" ?>>Tree</option>
                            </select>
                        </div>

                        <div>
                            <label for="itemStatus">Status: </label>
                            <select name="txtStatus" id="itemStatus">
                                <option value="" <?php if($currentStatus === "") echo "selected" ?>>All</option>
                                <option value="Active" <?php if($currentStatus === "Active") echo "selected" ?>>Active</option>
                                <option value="Inactive" <?php if($currentStatus === "Inactive") echo "selected" ?>>Inactive</option>
                            </select>
                        </div>

                        <button class="print" onclick="window.print()">
                            <i class="fa-solid fa-print"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex-container desktop-table" style="margin: 1em 0;">
                <table>
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Posted By</th>
                            <th>Stock</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            foreach ($items as $row) {
                                $config = tableConfig($row["item_status"]);

                                $textColor = $config[0];
                                $icon = $config[1];
                                $title = $config[2];
                                $nextStatus = $config[3];

                                $author = getUserName($conn, $row["user_id"]);

                                echo '<tr>
                                        <td>' . $row['item_id'] . '</td>
                                        <td>' . $row['item_name'] . '</td>
                                        <td>' . $author. '</td>
                                        <td>' . $row['item_stock'] . '</td>
                                        <td>' . ucwords($row['category']) . '</td>
                                        <td style="color:' . $textColor . '">' . $row['item_status'] . '</td>
                                        
                                        <td>
                                            <div class="action-container">
                                                <form action="" method="GET">
                                                    <input type="hidden" name="target_itemID" value="' . $row['item_id'] . '">
                                                    <input type="hidden" name="next_status" value="' . $nextStatus . '">

                                                    <button name="btnChangeStatus" type="submit" class="action-btn" title="'. $title .'">
                                                        ' . $icon . '
                                                    </button>
                                                </form>

                                                <a href="viewItem.php?id=' . $row['item_id'] . '" class="action-btn" title="View">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="flex-container mobile-card" style="margin: 1em 0;">
                <?php
                    foreach ($items as $row) {
                        $config = tableConfig($row["item_status"]);

                        $bgColor = $config[0];
                        $icon = $config[1];
                        $title = $config[2];
                        $nextStatus = $config[3];

                        $text = $nextStatus;
                        $author = getUserName($conn, $row["user_id"]);

                        echo '<div class="cards">
                                <div class="card-header">
                                    <div class="card-id">
                                        <p>Item ID</p>
                                        <h3>' . $row['item_id'] . '</h3>
                                    </div>

                                    <div class="card-status" style="background-color:' . $bgColor . '">
                                        <p>' . $row['item_status'] . '</p>
                                    </div>
                                </div>

                                <div class="card-content">
                                    <div class="card-data">
                                        <p>Item Name</p>
                                        <p>' . $row['item_name'] . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>Posted By</p>
                                        <p>' . $author . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>Stock</p>
                                        <p>' . $row['item_stock'] . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>Category</p>
                                        <p>' . ucwords($row['category']) . '</p>
                                    </div>
                                </div>

                                <div class="card-btns">
                                    <form action="" method="GET">
                                        <input type="hidden" name="target_itemID" value="' . $row['item_id'] . '">
                                        <input type="hidden" name="next_status" value="' . $nextStatus . '">

                                        <button name="btnChangeStatus" type="submit" class="card-action-btn card-status-btn" title="'. $title .'">
                                            ' . $icon . '
                                            <p>' . $text . '</p>
                                        </button>
                                    </form>

                                    <a href="viewItem.php?id=' . $row['item_id'] . '" title="View">
                                        <button class="card-action-btn card-view-btn">
                                            View User Details
                                        </button>
                                    </a>
                                </div>
                            </div>';
                    }
                ?>
            </div>
        </main>
        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>