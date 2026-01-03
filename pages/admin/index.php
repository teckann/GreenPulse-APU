<?php
    include("../../conn.php");
    include("../../sessionData.php");

    // dashboard 3 cards data for analysis (total users, items, events)
    function cardData($conn, $table, $column) {
        $sql = "SELECT 
                -- total records
                COUNT(*) as total,

                -- this month records
                (SELECT COUNT(*) FROM $table 
                WHERE $column >= DATE_FORMAT(NOW(), '%Y-%m-01')) as this_month,

                -- last month records
                (SELECT COUNT(*) FROM $table 
                WHERE $column >= DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01') 
                AND $column < DATE_FORMAT(NOW(), '%Y-%m-01')) as last_month             
                FROM $table";
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        return array($row["total"], $row["this_month"], $row["last_month"]);
    }

    $users = cardData($conn, "users", "registration_date");
    $items = cardData($conn, "items", "posted_date");
    $events = cardData($conn, "events", "posted_date");

    // * testing data here
    // $users = array(220, 0, 100);
    // $items = array(270, 150, 120);
    // $events = array(12, 1, 10);
?>


<?php
    // item line graph data
    // latest date of both merchandise and tree table
    $date_target_table = array("merchandise_purchase_history", "tree_adoption_history");
    $date_target_column = array("merchandise_purchase_date", "tree_adoption_date");
    $latest_date_result = array(null, null);

    for ($i = 0; $i < 2; $i++) {
        $sql= "SELECT MAX($date_target_column[$i]) as latest_date
               FROM $date_target_table[$i]";

        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $latest_date_result[$i] = $data["latest_date"];
    }

    // compare which date is the latest one, if both are null then default is curren month
    $latestDateTime = time();

    $merchDate = $latest_date_result[0];
    $treeDate = $latest_date_result[1];
    
    if ($merchDate || $treeDate) {
        if ($merchDate > $treeDate) {
            $latestDateTime = strtotime($merchDate);
        }
        else {
            $latestDateTime = strtotime($treeDate);
        }
    }

    // store the previous 4 months from the latest date (total: 5 months) 
    // use to query the quantity for each month and display it in the graph (x-axis)
    $monthsQueryKeys = [];   // for query purpose ("Dec", "Jan", ...)
    $monthsLabels = []; // for graph to display ("2025-12", "2026-01", ...)

    for ($i = 4; $i >= 0; $i--) {
        $monthsQueryKeys[]   = date('Y-m', strtotime("-$i months", $latestDateTime));
        $monthsLabels[] = date('M', strtotime("-$i months", $latestDateTime));
    }

    // function for query the total record for each month
    function countTotal($conn, $table, $column, $monthsQueryKeys) {
        // make the $data as key-value type, then assign key for the $data
        $data = array_fill_keys($monthsQueryKeys, 0);

        $firstMonth = $monthsQueryKeys[0];
        $lastMonth = $monthsQueryKeys[count($monthsQueryKeys) - 1];

        $sql = "SELECT DATE_FORMAT($column, '%Y-%m') as monthsKey,
                COUNT(*) as total
                FROM $table
                WHERE DATE_FORMAT($column, '%Y-%m') BETWEEN '$firstMonth' AND '$lastMonth'
                GROUP BY monthsKey";
        
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // insert data based on key, then make the data as integer type
                $data[$row["monthsKey"]] = (int)$row["total"];
            }
        }

        // only return the values
        return array_values($data);
    }

    // now call the countTotal function and find out the data for merchandise, tree and all
    $merchandiseData = countTotal($conn, "merchandise_purchase_history", "merchandise_purchase_date", $monthsQueryKeys);
    $treeData = countTotal($conn, "tree_adoption_history", "tree_adoption_date", $monthsQueryKeys);

    $allData = array();
    for ($i = 0; $i < 5; $i++) {
        $allData[$i] = $merchandiseData[$i] + $treeData[$i];
    }
?>

<?php
    // top 5 latest announcement list
    $sql_announcement = "SELECT * FROM announcement ORDER BY announcement_datetime DESC LIMIT 5";
    $result_announcement = mysqli_query($conn, $sql_announcement);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Page</title>
        <link rel="stylesheet" href="../../styles/admin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Welcome back! 👋</h1>
            <h2 class="page-subTitle">Monitor users, events, and system performance</h2>

            <div class="flex-container">
                <div class="data-container">
                    <?php
                        $title = array("Total Users", "Total Items", "Total Events");
                        $all_data = array($users, $items, $events);
                        $percentage = 0;
                        $status; $icon; $total; $this_month; $color;

                        for($i = 0; $i < 3; $i++) {
                            $status = "none"; 
                            $icon = "";       
                            $percentage = 0;
                            
                            $target_data = $all_data[$i];
                            $total = $target_data[0];
                            $this_month = $target_data[1];

                            // index2 = last_month data
                            if ($target_data[1] == 0) {
                                $percentage = 0;
                            }
                            elseif ($target_data[2] > 0) {
                                // ((this_month - last_month) / last_month) * 100
                                $percentage = (($target_data[1] - $target_data[2]) / $target_data[2]) * 100;
                                $status = "up";

                                // dont want negative number, alr use icon to represent, so make it absolute
                                if ($percentage < 0) {
                                    $status = "down";
                                    $percentage = abs($percentage);
                                }
                            }
                            // make sure this_month must have number, else just take default number, which is "0"
                            elseif ($target_data[1] > 0) {
                                $percentage = 100;
                                $status = "up";
                            }
                            else {
                                $percentage = 0;
                            }

                            // fix the deccimal number of percentage
                            $percentage = number_format($percentage, 1);

                            if ($status === "up") {
                                $icon = "fa-solid fa-arrow-trend-up trend-up";
                                $color = "#28a745";
                            }
                            elseif ($status === "down") {
                                $icon = "fa-solid fa-arrow-trend-down trend-down";
                                $color = "#dc3545";
                            }
                            else {
                                $icon = "fa-solid fa-minus trend-flat";
                                $color = "#6c757d";
                            }

                            echo "<div class='data-box'>
                                    <div class='data-box-title'>
                                        <h3>$title[$i]</h3>

                                        <div class='percentage-box'>
                                            <i class='$icon'></i> 
                                            <p>$percentage %</p>
                                        </div>
                                    </div>
                                    <p class='increase-number' style='color: $color'>+$this_month in this month</p>
                                    <h1>$total</h1>
                                </div>";
                        }
                    ?>
                </div>

                <div class="item-chart">
                    <div class="item-chart-title">
                        <h3>Redemption Analysis</h3>
                        <select id="itemList" name="txtItem" required>
                            <option value="all">All</option>
                            <option value="merchandise">Merchandises</option>
                            <option value="tree">Tree</option>
                        </select>
                    </div>

                    <div class="item-chart-box">
                        <canvas id="item-lineChart"></canvas>
                    </div>
                </div>

                <div class="module-announcement-container">
                    <div class="module-chart">
                        <div class="module-chart-title">
                            <h3>Total Module Enrollment</h3>
                        </div>

                        <div class="module-chart-box">
                            <canvas id="item-lineChart"></canvas>
                        </div>
                    </div>

                    <div class="dashboard-announcement">
                        <div class="dashboard-announcement-title">
                            <h3>Recent System Announcement</h3>
                        </div>

                        <div class="dashboard-announcement-list">
                            <table class="dashboard-announcement-table">
                                <thead>
                                    <tr>
                                        <th>Announcement</th>
                                        <th>Date & Time</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        if (mysqli_num_rows($result_announcement) > 0) {
                                            while ($row = mysqli_fetch_assoc($result_announcement)) {
                                                echo "<tr>
                                                        <td>" . $row['announcement_details'] . "</td>
                                                        <td>" . $row['announcement_datetime'] . "</td>
                                                      </tr>";
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include("footer.php"); ?>

        <!-- pass data to JS file -->
        <script>
            // parse PHP array to JS array
            const lineGraph_labels = <?php echo json_encode($monthsLabels); ?>;
            const lineGraph_merchandiseData = <?php echo json_encode($merchandiseData); ?>;
            const lineGraph_treeData = <?php echo json_encode($treeData); ?>;
            const lineGraph_allData = <?php echo json_encode($allData); ?>;
            
            console.info("Line Graph Data Successful Passed to JS")
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="../../scripts/admin.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>