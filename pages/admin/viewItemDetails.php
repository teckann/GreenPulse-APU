<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    if (isset($_GET["btnBack"])) {
        header("Location: manageItems.php");
        exit;
    }

    $data = array();
    $purchaseHistory = array();
    $statusColor = "";
    $author = "";
    $totalPurchase = "";
    $totalGPSpend = "";

    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql = "SELECT * FROM items WHERE item_id = '$id'";
        
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);

        // set status color & find the author name
        $statusColor = statusColor($data["item_status"]);
        $author = getUserName($conn, $data["user_id"]);

        $sql_totalPurchase = "";
        $sql_purchaseRecords = "";

        if ($data["category"] === "merchandise") {
            $sql_totalPurchase = "SELECT COUNT(*) AS total FROM merchandise_purchase_history
                                  WHERE item_id = '$id'";

            $sql_purchaseHistory = "SELECT * FROM merchandise_purchase_history 
                                    WHERE item_id = '$id'";
        }
        elseif ($data["category"] === "tree") {
            $sql_totalPurchase = "SELECT COUNT(*) AS total FROM tree_adoption_history
                                  WHERE item_id = '$id'";
            $sql_purchaseHistory = "SELECT * FROM tree_adoption_history
                                    WHERE item_id = '$id'";
        }

        // calculate totalPurchase
        $result_totalPurchase = mysqli_query($conn, $sql_totalPurchase);
        $row_totalPurchase = mysqli_fetch_assoc($result_totalPurchase);
        $totalPurchase = $row_totalPurchase["total"];

        // calculate totalGPSpend
        $totalGPSpend = (int)$data["item_redeem_points"] * (int)$totalPurchase;
        $totalGPSpend = $totalGPSpend . " GP";

        // retrieve the purchase history
        $result_purchaseHistory = mysqli_query($conn, $sql_purchaseHistory);

        if (mysqli_num_rows($result_purchaseHistory) > 0) {
            while ($row = mysqli_fetch_assoc($result_purchaseHistory)) {
                $purchaseHistory[] = $row;
            }
        }
    }
    else {
        echo "<script>
                alert('Invalid Access');
                window.location.href = 'manageItems.php';
              </script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Item Details</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>View Item Details</h1>
            <h2 class="page-subTitle">Detailed information about this item</h2>

            <div class="flex-container viewDetails">
                <form action="" action="GET">
                    <button name="btnBack" class="back-btn" type="submit" value="Back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p>Back</p>
                    </button>
                </form>

                <div class="viewDetails-header event-header">
                    <img src="../../<?php echo $data['item_image'] ?>" alt="item poster" width="150px" height="150px">

                    <div class="viewDetails-title mobile-viewDetails-title">
                        <h2><?php echo $data["item_name"] ?></h2>

                        <div class="row mobile-row">
                            <p><?php echo $data["item_id"] ?></p>

                            <div class="status status-width" style="background-color: <?php echo $statusColor; ?>">
                                <?php echo $data["item_status"] ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="viewDetails-content viewDetails-container">
                    <div class="viewDetails-contentss">
                        <div class="info-box1">
                            <div class="info-title">
                                <p>Item Information</p>
                                <div class="line"></div>
                            </div>

                            <div class="info-content">
                                <table>
                                    <tr>
                                        <td>Item Name</td>
                                        <td>:</td>
                                        <td><?php echo $data["item_name"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Description</td>
                                        <td>:</td>
                                        <td><?php echo $data["item_description"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Posted By</td>
                                        <td>:</td>
                                        <td><?php echo $author ?></td>
                                    </tr>

                                    <tr>
                                        <td>Required Points</td>
                                        <td>:</td>
                                        <td><?php echo $data["item_redeem_points"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Stock</td>
                                        <td>:</td>
                                        <td><?php echo $data["item_stock"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Category</td>
                                        <td>:</td>
                                        <td><?php echo ucwords($data["category"]) ?></td>
                                    </tr>

                                    <tr>
                                        <td>Posted Date</td>
                                        <td>:</td>
                                        <td><?php echo $data["posted_date"] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="info-box2 event-info-box2">
                            <div class="tracking-box1 event-tracking">
                                <div class="info-title">
                                    <p>Item Performance Monitoring</p>
                                    <div class="line"></div>
                                </div>

                                <div class="info-content">
                                    <div class="icon-text">
                                        <i class="fa-solid fa-gifts"></i>
                                        <p>Total Redeem: <?php echo $totalPurchase ?></p>
                                    </div>

                                    <div class="icon-text">
                                        <i class="fa-solid fa-leaf"></i>
                                        <p>Total Points Spend: <?php echo $totalGPSpend ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="viewDetails-table">
                        <div class="info-title">
                            <p>Item Purchase Tracking</p>
                            <div class="line"></div>
                        </div>

                        <table class="viewDetails-tableContent">
                            <thead>
                                <tr>
                                    <th>Purchase ID</th>
                                    <th>User ID</th>
                                    <th>Full Name</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    foreach ($purchaseHistory as $row) {
                                        $user_name = getUserName($conn, $row["user_id"]);

                                        if ($data["category"] === "merchandise") {
                                            echo '<tr>
                                                    <td>' . $row['merchandise_purchase_id'] . '</td>
                                                    <td>' . $row['user_id'] . '</td>
                                                    <td>' . $user_name . '</td>
                                                    <td>' . $row['merchandise_purchase_datetime'] . '</td>
                                                  </tr>';
                                        }
                                        elseif ($data["category"] === "tree") {
                                            echo '<tr>
                                                    <td>' . $row['tree_adoption_id'] . '</td>
                                                    <td>' . $row['user_id'] . '</td>
                                                    <td>' . $user_name . '</td>
                                                    <td>' . $row['tree_adoption_datetime'] . '</td>
                                                  </tr>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>