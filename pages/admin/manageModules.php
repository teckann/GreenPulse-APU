<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    $sql = "SELECT * FROM modules";

    if (isset($_GET["btnSearch"])) {
        $target = $_GET["target"];

        $sql = "SELECT * FROM modules WHERE module_name LIKE '%{$target}%'";
    }

    if (isset($_GET["btnChangeStatus"])) {
        $targetModuleID = $_GET["target_moduleID"];
        $nextStatus = $_GET["next_status"];

        $sql_updateStatus = "UPDATE modules SET module_status = '$nextStatus'
                             WHERE module_id = '$targetModuleID'";
        
        if(mysqli_query($conn, $sql_updateStatus)) {
            // record action into log
            addLog($conn, $userID, "Change Module Status ($targetModuleID)");

            echo "<script>
                    alert('--- Successfully Updated Module Status ---\\nModule ID: $targetModuleID\\nNew Status: $nextStatus');
                    window.location.href = 'manageModules.php';
                    </script>";
        }
    }

    $currentStatus = "";

    if (isset($_GET["txtStatus"])) {
        $status = $_GET["txtStatus"];

        $currentStatus = $status;

        if (!empty($status)) {
            $sql = "SELECT * FROM modules
                    WHERE module_status = '$status'";
        }
    }

    $result = mysqli_query($conn, $sql);

    $modules = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $modules[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Modules</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Manage Modules</h1>
            <h2 class="page-subTitle">Overview of all modules across the system</h2>

            <div class="action-bar" style="margin: 1em 0;">
                <form action="" method="GET">
                    <div class="table-search-box">
                        <input type="text" name="target" placeholder="Search module here">
                        <i class="fa-solid fa-magnifying-glass"></i>

                        <button name="btnSearch" type="submit" value="Search" class="table-btnSearch" title="Search"></button>
                    </div>
                </form>

                <form action="" method="GET" class="select-container" id="module-form">
                    <div class="select-boxs">
                        <div>
                            <label for="moduleStatus">Status: </label>
                            <select name="txtStatus" id="moduleStatus">
                                <option value="" <?php if ($currentStatus === "") echo "selected" ?>>All</option>
                                <option value="Active" <?php if ($currentStatus === "Active") echo "selected" ?>>Active</option>
                                <option value="Inactive" <?php if ($currentStatus === "Inactive") echo "selected" ?>>Inactive</option>
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
                            <th>Module ID</th>
                            <th>Module Name</th>
                            <th>Added By</th>
                            <th>Total Enrolled</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            foreach ($modules as $row) {
                                $config = tableConfig($row["module_status"]);

                                $textColor = $config[0];
                                $icon = $config[1];
                                $title = $config[2];
                                $nextStatus = $config[3];

                                $author = getUserName($conn, $row["user_id"]);
                                $totalEnrolled = totalEnrolled($conn, $row["module_id"]);

                                echo '<tr>
                                        <td>' . $row['module_id'] . '</td>
                                        <td>' . $row['module_name'] . '</td>
                                        <td>
                                            <a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="redirect-link" title="View User Profile">
                                                ' . $author . '
                                                <i class="fa-solid fa-angle-double-right table-linkIcon"></i>
                                            </a>
                                        </td>
                                        <td>' . $totalEnrolled . '</td>
                                        <td style="color:' . $textColor . '">' . $row['module_status'] . '</td>
                                        
                                        <td>
                                            <div class="action-container">
                                                <form action="" method="GET">
                                                    <input type="hidden" name="target_moduleID" value="' . $row['module_id'] . '">
                                                    <input type="hidden" name="next_status" value="' . $nextStatus . '">

                                                    <button name="btnChangeStatus" type="submit" class="action-btn" title="'. $title .'">
                                                        ' . $icon . '
                                                    </button>
                                                </form>

                                                <a href="viewModuleDetails.php?id=' . $row['module_id'] . '" class="action-btn" title="View">
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
                    foreach ($modules as $row) {
                        $config = tableConfig($row["module_status"]);

                        $bgColor = $config[0];
                        $icon = $config[1];
                        $title = $config[2];
                        $nextStatus = $config[3];

                        $text = $nextStatus;

                        $author = getUserName($conn, $row["user_id"]);
                        $totalEnrolled = totalEnrolled($conn, $row["module_id"]);

                        echo '<div class="cards">
                                <div class="card-header">
                                    <div class="card-id">
                                        <p>Module ID</p>
                                        <h3>' . $row['module_id'] . '</h3>
                                    </div>

                                    <div class="card-status" style="background-color:' . $bgColor . '">
                                        <p>' . $row['module_status'] . '</p>
                                    </div>
                                </div>

                                <div class="card-content">
                                    <div class="card-data">
                                        <p>Module Name</p>
                                        <p>' . $row['module_name'] . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>Added By</p>
                                        <p>
                                            <a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="redirect-link" title="View User Profile">
                                                ' . $author . '
                                                <i class="fa-solid fa-angle-double-right table-linkIcon"></i>
                                            </a>
                                        </p>
                                    </div>

                                    <div class="card-data">
                                        <p>Total Enrolled</p>
                                        <p>' . $totalEnrolled . '</p>
                                    </div>
                                </div>

                                <div class="card-btns">
                                    <form action="" method="GET">
                                        <input type="hidden" name="target_moduleID" value="' . $row['module_id'] . '">
                                        <input type="hidden" name="next_status" value="' . $nextStatus . '">

                                        <button name="btnChangeStatus" type="submit" class="card-action-btn card-status-btn" title="'. $title .'">
                                            ' . $icon . '
                                            <p>' . $text . '</p>
                                        </button>
                                    </form>

                                    <a href="viewModuleDetails.php?id=' . $row['module_id'] . '" title="View">
                                        <button class="card-action-btn card-view-btn">
                                            View Module Details
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