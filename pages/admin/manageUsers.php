<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");

    $sql = "SELECT * FROM users";
    $target = "";

    if (isset($_GET["btnSearch"])) {
        $target = $_GET["target"];

        $sql = "SELECT * FROM users WHERE name LIKE '%{$target}%'";
    }

    if (isset($_GET["btnChangeStatus"])) {
        $targetUserID = $_GET["target_userID"];
        $nextStatus = $_GET["next_status"];

        $sql_updateStatus = "UPDATE users SET account_status = '$nextStatus' WHERE user_id = '$targetUserID'";
        
        if(mysqli_query($conn, $sql_updateStatus)) {
            header("location: manageUsers.php");
        }
    }

    if (isset($_GET["btnFilter"])) {
        $role = $_GET["txtRole"];
        $accountStatus = $_GET["txtStatus"];

        if (!empty($role) && !empty($accountStatus)) {
            $sql = "SELECT * FROM users 
                    WHERE role = '$role' AND account_status = '$accountStatus'";
        }
        elseif (!empty($role)) {
            $sql = "SELECT * FROM users 
                    WHERE role = '$role'";
        }
        elseif (!empty($accountStatus)) {
            $sql = "SELECT * FROM users 
                    WHERE account_status = '$accountStatus'";
        }
    }

    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Users</title>
        <link rel="stylesheet" href="../../styles/admin.css">

        <?php include("library.php") ?>
    </head>
    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Manage Users</h1>
            <h2 class="page-subTitle">Overview of all registered accounts</h2>

            <div class="action-bar" style="margin: 1em 0;">
                <form action="" method="GET">
                    <div class="table-search-box">
                        <input type="text" name="target" placeholder="Search user here">
                        <i class="fa-solid fa-magnifying-glass"></i>

                        <button name="btnSearch" type="submit" value="Search" class="table-btnSearch" title="Search"></button>
                    </div>
                </form>

                <form action="" method="GET" class="select-container">
                    <div class="select-boxs">
                        <div>
                            <label for="role">Role: </label>
                            <select name="txtRole" id="role">
                                <option value="">All</option>
                                <option value="admin">Admin</option>
                                <option value="committee">Committee</option>
                                <option value="volunteer">Volunteer</option>
                            </select>
                        </div>

                        <div>
                            <label for="status">Status: </label>
                            <select name="txtStatus" id="status">
                                <option value="">All</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="action-btns">
                        <button name="btnFilter" type="submit" value="Filter" class="filter-btn">
                            <i class="fa-solid fa-filter"></i>
                            <p>Filter</p>
                        </button>

                        <button type="button" class="addNewUser-btn">
                            <a href="addNewUser.php">
                                <i class="fa-solid fa-user-plus"></i>
                                <p>Add New User</p>
                            </a>
                        </button>
                    </div>
                </form>
            </div>

            <?php
                $users = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $users[] = $row;
                }
            ?>

            <div class="flex-container desktop-table" style="margin: 1em 0;">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Full Name</th>
                            <th>Education Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            foreach ($users as $row):
                                $textColor = "";
                                $icon = "";
                                $title = "";
                                $nextStatus = "";

                                if ($row["account_status"] === "Active") {
                                    $icon = "<i class='fa-solid fa-ban'></i>";
                                    $textColor = "#28a745";
                                    $nextStatus = "Inactive";
                                }
                                elseif ($row["account_status"] === "Inactive") {
                                    $icon = "<i class='fa-solid fa-undo'></i>";
                                    $textColor = "#dc3545";
                                    $nextStatus = "Active";
                                }
                                $title = $nextStatus;

                                echo '<tr>
                                        <td>' . $row['user_id'] . '</td>
                                        <td>' . $row['name'] . '</td>
                                        <td>' . $row['education_email'] . '</td>
                                        <td>' . ucwords($row['role']) . '</td>
                                        <td style="color:' . $textColor . '">' . $row['account_status'] . '</td>
                                        
                                        <td>
                                            <div class="action-container">
                                                <form action="" method="GET">
                                                    <input type="hidden" name="target_userID" value="' . $row['user_id'] . '">
                                                    <input type="hidden" name="next_status" value="' . $nextStatus . '">

                                                    <button name="btnChangeStatus" type="submit" class="action-btn" title="'. $title .'">
                                                        ' . $icon . '
                                                    </button>
                                                </form>

                                                <a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="action-btn" title="View">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>';
                            endforeach;
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="flex-container mobile-card" style="margin: 1em 0;">
                <?php
                    foreach ($users as $row):
                        $bgColor = "";
                        $icon = "";
                        $title = "";
                        $text = "";
                        $nextStatus = "";

                        if ($row["account_status"] === "Active") {
                            $icon = "<i class='fa-solid fa-ban'></i>";
                            $bgColor = "#28a745";
                            $nextStatus = "Inactive";
                        }
                        elseif ($row["account_status"] === "Inactive") {
                            $icon = "<i class='fa-solid fa-undo'></i>";
                            $bgColor = "#dc3545";
                            $nextStatus = "Active";
                        }
                        $title = $nextStatus;
                        $text = $nextStatus;

                        echo '<div class="cards">
                                <div class="card-header">
                                    <div class="card-id">
                                        <p>User ID</p>
                                        <h3>' . $row['user_id'] . '</h3>
                                    </div>

                                    <div class="card-status" style="background-color:' . $bgColor . '">
                                        <p>' . $row['account_status'] . '</p>
                                    </div>
                                </div>

                                <div class="card-content">
                                    <div class="card-data">
                                        <p>Name</p>
                                        <p>' . $row['name'] . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>Education Email</p>
                                        <p>' . $row['education_email'] . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>Role</p>
                                        <p>' . ucwords($row['role']) . '</p>
                                    </div>
                                </div>

                                <div class="card-btns">
                                    <form action="" method="GET">
                                        <input type="hidden" name="target_userID" value="' . $row['user_id'] . '">
                                        <input type="hidden" name="next_status" value="' . $nextStatus . '">

                                        <button name="btnChangeStatus" type="submit" class="card-action-btn card-status-btn" title="'. $title .'">
                                            ' . $icon . '
                                            <p>' . $text . '</p>
                                        </button>
                                    </form>

                                    <a href="viewUserProfile.php?id=' . $row['user_id'] . '" title="View">
                                        <button class="card-action-btn card-view-btn">
                                            View User Details
                                        </button>
                                    </a>
                                </div>
                              </div>';
                    endforeach;
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