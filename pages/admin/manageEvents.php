<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    $sql = "SELECT * FROM events";
    $target = "";

    if (isset($_GET["btnSearch"])) {
        $target = $_GET["target"];

        $sql = "SELECT * FROM events WHERE event_title LIKE '%{$target}%'";
    }

    $currentStatus = "";

    if (isset($_GET["txtStatus"])) {
        $eventStatus = $_GET["txtStatus"];
        $currentStatus = $eventStatus;

        if (!empty($eventStatus)) {
            $sql = "SELECT * FROM events WHERE event_status = '$eventStatus'";
        }
    }

    if (isset($_GET["btnChangeStatus"])) {
        $targetEventID = $_GET["target_eventID"];
        $nextStatus = $_GET["next_status"];

        
        $sql_updateStatus = "UPDATE events SET event_status = '$nextStatus'
                             WHERE event_id = '$targetEventID'";
        
        if(mysqli_query($conn, $sql_updateStatus)) {
            // record action into log
            // addLog($conn, $userID, "Change Event Status ($targetEventID)");

            echo "<script>
                    alert('--- Successfully Updated Event Status ---\\nUser ID: $targetEventID\\nNew Status: $nextStatus');
                    window.location.href = 'manageEvents.php';
                    </script>";
        }
    }

    $result = mysqli_query($conn, $sql);

    $events = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Events</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php") ?>
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

                <form action="" method="GET" class="select-container" id="event-form">
                    <div class="select-boxs">
                        <div>
                            <label for="eventStatus">Status: </label>
                            <select name="txtStatus" id="eventStatus">
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
                            <th>Event ID</th>
                            <th>Event Title</th>
                            <th>Author</th>
                            <th>Event Date & Time</th>
                            <th>Posted Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            foreach ($events as $row) {
                                $config = tableConfig($row["event_status"]);

                                $textColor = $config[0];
                                $icon = $config[1];
                                $title = $config[2];
                                $nextStatus = $config[3];

                                $author = getUserName($conn, $row["user_id"]);

                                $eventDateTime = $row["event_datetime"];
                                $formatted_dateTime = date("d M Y (g:i A)", strtotime($eventDateTime));

                                echo '<tr>
                                        <td>' . $row['event_id'] . '</td>
                                        <td>' . $row['event_title'] . '</td>
                                        <td>
                                            <a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="redirect-link" title="View User Profile">
                                                ' . $author . '
                                                <i class="fa-solid fa-angle-double-right table-linkIcon"></i>
                                            </a>
                                        </td>
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
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="flex-container mobile-card" style="margin: 1em 0;">
                <?php
                    foreach ($events as $row) {
                        $config = tableConfig($row["event_status"]);

                        $bgColor = $config[0];
                        $icon = $config[1];
                        $title = $config[2];
                        $nextStatus = $config[3];
                        $text = $nextStatus;

                        $author = getUserName($conn, $row["user_id"]);

                        $eventDateTime = $row["event_datetime"];
                        $formatted_dateTime = date("d M Y (g:i A)", strtotime($eventDateTime));

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
                                        <p>Author</p>
                                        <p>
                                            <a href="viewUserProfile.php?id=' . $row['user_id'] . '&event=Event" class="redirect-link" title="View User Profile">
                                                ' . $author . '
                                                <i class="fa-solid fa-angle-double-right table-linkIcon"></i>
                                            </a>
                                        </p>
                                    </div>

                                    <div class="card-data">
                                        <p>Event Date & Time</p>
                                        <p>' . $formatted_dateTime . '</p>
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

                                    <a href="viewEventDetails.php?id=' . $row['event_id'] . '" title="View">
                                        <button class="card-action-btn card-view-btn">
                                            View Event Details
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