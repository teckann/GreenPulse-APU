<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    $sql = "SELECT * FROM log GROUP BY log_datetime ASC";
    $target = "";

    if (isset($_GET["btnSearch"])) {
        $target = $_GET["target"];

        $sql = "SELECT * FROM log WHERE log_event LIKE '%{$target}%'";
    }

    $currentSort = "";
    $currentStatus = "";

    if (isset($_GET["txtSort"]) || isset($_GET["txtStatus"])) {
        $sort = $_GET["txtSort"];
        $logStatus = $_GET["txtStatus"];

        $currentSort = $sort;
        $currentStatus = $logStatus;

        if (!empty($sort) && empty($logStatus)) {
            $sql = "SELECT * FROM log ORDER BY log_datetime $sort";
        }
        elseif (!empty($sort) || !empty($logStatus)) {
            if ($logStatus === "today") {
                $sql = "SELECT * FROM log
                        WHERE log_datetime >= CURDATE()
                        AND log_datetime < CURDATE() + INTERVAL 1 DAY
                        ORDER BY log_datetime $sort";
            }
            else if ($logStatus === "this_week") {
                $sql = "SELECT * FROM log
                        WHERE log_datetime >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)
                        AND log_datetime < DATE_ADD(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL 7 DAY)
                        ORDER BY log_datetime $sort";
            }
            else if ($logStatus === "this_month") {
                $sql = "SELECT * FROM log
                        WHERE log_datetime >= DATE_FORMAT(NOW(), '%Y-%m-01')
                        AND log_datetime <  DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 1 MONTH)
                        ORDER BY log_datetime $sort";
            }
            else if ($logStatus === "this_year") {
                $sql = "SELECT * FROM log
                        WHERE log_datetime >= MAKEDATE(YEAR(CURDATE()), 1)
                        AND log_datetime <  MAKEDATE(YEAR(CURDATE()) + 1, 1)
                        ORDER BY log_datetime $sort";
            }
        }
    }

    $result = mysqli_query($conn, $sql);

    $logs = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $logs[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log Activity</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Activity Log</h1>
            <h2 class="page-subTitle">Monitor system-wide user activity and access logs</h2>

            <div class="action-bar" style="margin: 1em 0;">
                <form action="" method="GET">
                    <div class="table-search-box">
                        <input type="text" name="target" placeholder="Search log event here">
                        <i class="fa-solid fa-magnifying-glass"></i>

                        <button name="btnSearch" type="submit" value="Search" class="table-btnSearch" title="Search"></button>
                    </div>
                </form>

                <form action="" method="GET" class="select-container" id="log-form">
                    <div class="select-boxs">
                        <div>
                            <label for="logSort">Sort: </label>
                            <select name="txtSort" id="logSort">
                                <option value="ASC" <?php if($currentSort === "ASC") echo "selected" ?>>Ascending</option>
                                <option value="DESC" <?php if($currentSort === "DESC") echo "selected" ?>>Descending</option>
                            </select>
                        </div>

                        <div>
                            <label for="losStatus">Status: </label>
                            <select name="txtStatus" id="logStatus">
                                <option value="" <?php if($currentStatus === "") echo "selected" ?>>All</option>
                                <option value="today" <?php if($currentStatus === "today") echo "selected" ?>>Today</option>
                                <option value="this_week" <?php if($currentStatus === "this_week") echo "selected" ?>>This Week</option>
                                <option value="this_month" <?php if($currentStatus === "this_month") echo "selected" ?>>This Month</option>
                                <option value="this_year" <?php if($currentStatus === "this_year") echo "selected" ?>>This Year</option>
                            </select>
                        </div>

                        <button class="print" onclick="window.print()">
                            <i class="fa-solid fa-print"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex-container" style="margin: 1em 0;">
                <table>
                    <thead>
                        <tr>
                            <th>Log ID</th>
                            <th>User</th>
                            <th>Event</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            foreach ($logs as $row) {
                                $user_name = getUserName($conn, $row["user_id"]);

                                echo '<tr>
                                        <td>' . $row['log_id'] . '</td>
                                        <td>
                                            <a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="redirect-link" title="View User Profile">
                                                ' . $user_name . '
                                                <i class="fa-solid fa-angle-double-right table-linkIcon"></i>
                                            </a>
                                        </td>
                                        <td>' . $row['log_event'] . ' </td>
                                        <td>' . $row['log_datetime'] . '</td>
                                    </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- <div class="flex-container mobile-card" style="margin: 1em 0;">
                <?php
                    foreach ($logs as $row) {
                        $user_name = getUserName($conn, $row["user_id"]);

                        echo '<div class="cards">
                                <div class="card-header">
                                    <div class="card-id">
                                        <p>Log ID</p>
                                        <h3>' . $row['log_id'] . '</h3>
                                    </div>
                                </div>

                                <div class="card-content">
                                    <div class="card-data">
                                        <p>Title</p>
                                        <p>' . $row['log_event'] . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>User</p>
                                        <p><a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="redirect-link" title="View User Profile">' . $user_name . '</a></p>
                                    </div>

                                    <div class="card-data">
                                        <p>Date & Time</p>
                                        <p>' . $row['log_datetime'] . '</p>
                                    </div>
                                </div>
                              </div>';
                    }
                ?>
            </div> -->
        </main>
        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>