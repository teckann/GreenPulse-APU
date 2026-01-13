<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");

    $sql = "SELECT * FROM events";
    $target = "";

    if (isset($_GET["btnSearch"])) {
        $target = $_GET["target"];

        $sql = "SELECT * FROM events WHERE event_title LIKE '%{$target}%'";
    }

    if (isset($_GET["btnFilter"])) {
        $eventStatus = $_GET["txtStatus"];

        if (!empty($eventStatus)) {
            $sql = "SELECT * FROM events WHERE event_status = '$eventStatus'";
        }
    }

    if (isset($_GET["btnChangeStatus"])) {
        $targetEventID = $_GET["target_eventID"];
        $nextStatus = $_GET["next_status"];

        
        $sql_updateStatus = "UPDATE events SET event_status = '$nextStatus' WHERE event_id = '$targetEventID'";
        
        if(mysqli_query($conn, $sql_updateStatus)) {
            echo "<script>
                    alert('--- Successfully Updated Event Status ---\\nUser ID: $targetEventID\\nNew Status: $nextStatus');
                    window.location.href = 'manageEvents.php';
                    </script>";
        }
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
                        <input type="text" name="target" placeholder="Search event here">
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
                                <option value="Active">Close</option>
                                <option value="Inactive">Today</option>
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
                            <th>Author</th>
                            <th>Date & Time</th>
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

                                $user_id = $row["user_id"];
                                $sql_user = "SELECT name FROM users WHERE user_id = '$user_id'";
                                $result_user = mysqli_query($conn, $sql_user);
                                $row_user = mysqli_fetch_assoc($result_user);
                                $author = $row_user["name"];

                                $eventDateTime = $row["event_datetime"];
                                $formatted_dateTime = date("d M Y (g:i A)", strtotime($eventDateTime));

                                echo '<tr>
                                        <td>' . $row['event_id'] . '</td>
                                        <td>' . $row['event_title'] . '</td>
                                        <td><a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="redirect-link" title="View User Profile">' . $author . '</a></td>
                                        <td>' . $formatted_dateTime . ' </td>
                                        <td>' . ucwords($row['posted_date']) . '</td>
                                        <td style="color:' . $textColor . '">' . $row['event_status'] . '</td>
                                        
                                        <td>
                                            <div class="action-container">
                                                <form action="" method="GET">
                                                    <input type="hidden" name="target_eventID" value="' . $row['event_id'] . '">
                                                    <input type="hidden" name="next_status" value="' . $nextStatus . '">

                                                    <button name="btnChangeStatus" type="submit" class="action-btn" title="'. $title .'">
                                                        ' . $icon . '
                                                    </button>
                                                </form>

                                                <a href="viewEventDetails.php?id=' . $row['event_id'] . '" class="action-btn" title="View">
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
                    foreach ($events as $row):
                        $bgColor = "";
                        $icon = "";
                        $title = "";
                        $text = "";
                        $nextStatus = "";

                        if ($row["event_status"] === "Active") {
                            $icon = "<i class='fa-solid fa-ban'></i>";
                            $bgColor = "#28a745";
                            $nextStatus = "Inactive";
                        }
                        elseif ($row["event_status"] === "Inactive") {
                            $icon = "<i class='fa-solid fa-undo'></i>";
                            $bgColor = "#dc3545";
                            $nextStatus = "Active";
                        }
                        $title = $nextStatus;
                        $text = $nextStatus;

                        $user_id = $row["user_id"];
                        $sql_user = "SELECT name FROM users WHERE user_id = '$user_id'";
                        $result_user = mysqli_query($conn, $sql_user);
                        $row_user = mysqli_fetch_assoc($result_user);
                        $postedBy = $row_user["name"];

                        echo '<div class="cards">
                                <div class="card-header">
                                    <div class="card-id">
                                        <p>User ID</p>
                                        <h3>' . $row['event_id'] . '</h3>
                                    </div>

                                    <div class="card-status" style="background-color:' . $bgColor . '">
                                        <p>' . $row['event_status'] . '</p>
                                    </div>
                                </div>

                                <div class="card-content">
                                    <div class="card-data">
                                        <p>Title</p>
                                        <p>' . $row['event_title'] . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>Posted By</p>
                                        <p><a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="redirect-link" title="View User Profile">' . $postedBy . '</a></p>
                                    </div>

                                    <div class="card-data">
                                        <p>Posted Date</p>
                                        <p>' . ucwords($row['posted_date']) . '</p>
                                    </div>
                                </div>

                                <div class="card-btns">
                                    <form action="" method="GET">
                                        <input type="hidden" name="target_eventID" value="' . $row['event_id'] . '">
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