<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");

    $sql = "SELECT * FROM events";
    $target = "";

    if (isset($_GET["btnSearch"])) {
        $target = $_GET["target"];

        $sql = "SELECT * FROM users WHERE name LIKE '%{$target}%'";
    }
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Events</title>
        <link rel="stylesheet" href="../../styles/admin.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Manage Events</h1>
            <h2 class="page-subTitle">Overview of all posted events</h2>

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

                        <button class="print" onclick="window.print()">
                            <i class="fa-solid fa-print"></i>
                        </button>
                    </div>
                </form>
            </div>

            <?php
                $events = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $events[] = $row;
                }
            ?>

            <div class="flex-container desktop-table" style="margin: 1em 0;">
                <table>
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>Event Title</th>
                            <th>Posted By</th>
                            <th>Points Given</th>
                            <th>Posted Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            foreach ($events as $row):
                                $textColor = "";
                                $icon = "";
                                $title = "";
                                $nextStatus = "";

                                if ($row["event_status"] === "Active") {
                                    $icon = "<i class='fa-solid fa-ban'></i>";
                                    $textColor = "#28a745";
                                    $nextStatus = "Inactive";
                                }
                                elseif ($row["event_status"] === "Inactive") {
                                    $icon = "<i class='fa-solid fa-undo'></i>";
                                    $textColor = "#dc3545";
                                    $nextStatus = "Active";
                                }
                                $title = $nextStatus;

                                $user_id = $row['user_id'];
                                $sql_user = "SELECT name FROM users WHERE user_id = '$user_id'";
                                $result_user = mysqli_query($conn, $sql_user);
                                $row_user = mysqli_fetch_assoc($result_user);
                                $postedBy = $row_user["name"];

                                echo '<tr>
                                        <td>' . $row['event_id'] . '</td>
                                        <td>' . $row['event_title'] . '</td>
                                        <td><a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="redirect-link" title="View User Profile">' . $postedBy . '</a></td>
                                        <td>' . $row['points_given'] . ' GP</td>
                                        <td>' . ucwords($row['posted_date']) . '</td>
                                        <td style="color:' . $textColor . '">' . $row['event_status'] . '</td>
                                        
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