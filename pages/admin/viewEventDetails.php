<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    if (isset($_GET["btnBack"])) {
        header("Location: manageEvents.php");
        exit;
    }

    $data = array();

    $author = "";
    $formatted_dateTime = "";
    $statusColor = "";
    $remaining = "";
    $totalParticipants = "";
    $availableSpot = "";
    $totalAttendees = "";
    $totalAbsentees = "";

    if(isset($_GET["id"])) {
        $id = $_GET["id"];
        
        $sql = "SELECT * FROM events WHERE event_id = '$id'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);

        // find author
        $user_id = $data["user_id"];
        
        $sql_author = "SELECT name from users WHERE user_id = '$user_id'";
        $result_author = mysqli_query($conn, $sql_author);
        $data_author = mysqli_fetch_assoc($result_author);
        $author = $data_author["name"];

        // format event datetime
        $formatted_dateTime = reformat_dateTime($data["event_datetime"]);

        // status color
        $statusColor = statusColor($data["event_status"]);


        // find the remaining value
        $remaining = timeRemaining($conn, $id);
        
        // find the total participants
        $sql_participants = "SELECT COUNT(*) AS totalParticipants,
                             SUM(attendance_status = 'Present') AS totalPresent,
                             SUM(attendance_status = 'Absent') AS totalAbsent
                             FROM attendance WHERE event_id = '$id'";

        $result_participants = mysqli_query($conn, $sql_participants);
        $data_participants = mysqli_fetch_assoc($result_participants);
        $totalParticipants = $data_participants["totalParticipants"];
        $totalAttendees = $data_participants["totalPresent"];
        $totalAbsentees = $data_participants["totalAbsent"];

        // if event havent start, then make total attendees & absentees as N/A first
        if ($remaining != "End" && $remaining != "In progress") {
            $totalAttendees = "N/A";
            $totalAbsentees = "N/A";
        }

        $availableSpot = (int)$data["capacity"] - (int)$totalParticipants;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Event Details</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php") ?>        
    </head>
    <body>
        <?php include("header.php") ?>

        <main class="search-area">
            <h1>View Event Details</h1>
            <h2 class="page-subTitle">Detailed information about this event</h2>

            <div class="flex-container viewDetails">
                <form action="" action="GET">
                    <button name="btnBack" class="back-btn" type="submit" value="Back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p>Back</p>
                    </button>
                </form>

                <div class="viewDetails-header event-header">
                    <img src="../../<?php echo $data['event_poster'] ?>" alt="event poster" width="250px" height="150px">

                    <div class="viewDetails-title">
                        <h2><?php echo $data["event_title"] ?></h2>

                        <div class="row">
                            <p><?php echo $data["event_id"] ?></p>
                            <p><?php echo $author ?></p>
                        </div>

                        <div class="row status" style="background-color: <?php echo $statusColor; ?>">
                            <?php echo $data["event_status"] ?>
                        </div>
                    </div>
                </div>

                <div class="viewDetails-content viewDetails-container">
                    <div class="viewDetails-contentss">
                        <div class="info-box1">
                            <div class="info-title">
                                <p>Event Information</p>
                                <div class="line"></div>
                            </div>

                            <div class="info-content">
                                <table>
                                    <tr>
                                        <td>Event Title</td>
                                        <td>:</td>
                                        <td><?php echo $data["event_title"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Description</td>
                                        <td>:</td>
                                        <td><?php echo $data["event_description"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Author</td>
                                        <td>:</td>
                                        <td><?php echo $author ?></td>
                                    </tr>

                                    <tr>
                                        <td>Event Date & Time</td>
                                        <td>:</td>
                                        <td><?php echo $formatted_dateTime ?></td>
                                    </tr>

                                    <tr>
                                        <td>Duration</td>
                                        <td>:</td>
                                        <td><?php echo $data["duration"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Location</td>
                                        <td>:</td>
                                        <td><?php echo $data["location"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Capacity</td>
                                        <td>:</td>
                                        <td><?php echo $data["capacity"] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="info-box2 event-info-box2">
                            <div class="tracking-box1">
                                <div class="info-title">
                                    <p>Event Performance Monitoring</p>
                                    <div class="line"></div>
                                </div>

                                <div class="info-content">
                                    <div class="icon-text">
                                        <i class="fa-solid fa-hourglass-half"></i>
                                        <p>Time Remaining: <?php echo $remaining ?></p>
                                    </div>

                                    <div class="icon-text">
                                        <i class="fa-solid fa-calendar-check"></i>
                                        <p>Total Participants: <?php echo $totalParticipants ?></p>
                                    </div>

                                    <div class="icon-text">
                                        <i class="fa-solid fa-door-open"></i>
                                        <p>Available Spot: <?php echo $availableSpot ?></p>
                                    </div>

                                    <div class="icon-text">
                                        <i class="fa-solid fa-user-check"></i>
                                        <p>Number of Attendees: <?php echo $totalAttendees ?></p>
                                    </div>

                                    <div class="icon-text">
                                        <i class="fa-solid fa-user-xmark"></i>
                                        <p>Number of Absentees: <?php echo $totalAbsentees ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <table>
                            <tr>
                                <th>User ID</th>
                                <th>Full Name</th>
                                <th>Register Date & Time</th>
                                <th>Status</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </main>
            
        <?php include("footer.php") ?>
    </body>
</html>