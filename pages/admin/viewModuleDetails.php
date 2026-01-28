<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/utility.php");

    if (isset($_GET["btnBack"])) {
        header("Location: manageModules.php");
        exit;
    }

    $data = array();
    $moduleResult = array();
    $statusColor = "";
    $author = "";
    $totalEnrolled  = "";
    $totalQuizzes = "";

    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql = "SELECT * FROM modules WHERE module_id = '$id'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);

        // set status color & find the author name & totalEnrolled
        $statusColor = statusColor($data["module_status"]);
        $author = getUserName($conn, $data["user_id"]);
        $totalEnrolled = totalEnrolled($conn, $id);

        $totalEnrolled = $totalEnrolled . " Persons";

        // find total quizzes
        $sql_totalQuizzes = "SELECT COUNT(*) AS total FROM quiz
                             WHERE module_id = '$id'";

        $result_totalQuizzes = mysqli_query($conn, $sql_totalQuizzes);
        $row_totalQuizzes = mysqli_fetch_assoc($result_totalQuizzes);
        $totalQuizzes = $row_totalQuizzes["total"];


        // find the result
        $sql_moduleResult = "SELECT * FROM module_history
                             WHERE module_id = '$id'";
        
        $result_moduleResult = mysqli_query($conn, $sql_moduleResult);

        if (mysqli_num_rows($result_moduleResult) > 0) {
            while ($row = mysqli_fetch_assoc($result_moduleResult)) {
                $moduleResult[] = $row;
            }
        }
    }
    else {
        echo "<script>
                alert('Invalid Access');
                window.location.href = 'manageModules.php';
              </script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Module Details</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>View Module Details</h1>
            <h2 class="page-subTitle">Detailed information about this module</h2>

            <div class="flex-container viewDetails">
                <form action="" action="GET">
                    <button name="btnBack" class="back-btn" type="submit" value="Back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p>Back</p>
                    </button>
                </form>

                <div class="viewDetails-header event-header">
                    <img src="../../<?php echo $data['module_cover'] ?>" alt="event poster" width="350px" height="190px">

                    <video width="350px" height="auto" controls class="box-content">
                        <source src="../../<?php echo $data["module_video"] ?>" type="video/mp4">
                    </video>
                </div>

                <div class="viewDetails-content viewDetails-container">
                    <div class="viewDetails-contentss">
                        <div class="info-box1">
                            <div class="info-title">
                                <p>Module Information</p>
                                <div class="line"></div>
                            </div>

                            <div class="info-content">
                                <table>
                                    <tr>
                                        <td>Module ID</td>
                                        <td>:</td>
                                        <td><?php echo $data["module_id"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Status</td>
                                        <td>:</td>
                                        <td style="color: <?php echo $statusColor ?>"><?php echo $data["module_status"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Module Name</td>
                                        <td>:</td>
                                        <td><?php echo $data["module_name"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Description</td>
                                        <td>:</td>
                                        <td><?php echo $data["module_description"] ?></td>
                                    </tr>

                                    <tr>
                                        <td>Posted By</td>
                                        <td>:</td>
                                        <td><?php echo $author ?></td>
                                    </tr>

                                    <tr>
                                        <td>Module Material</td>
                                        <td>:</td>
                                        <td>
                                            <a href="../../<?php echo $data["module_material"] ?>" target="_blank" style="text-decoration: none;">
                                                <button class="module-material-download-btn" title="Download">
                                                    <i class="fa-solid fa-file-arrow-down"></i>
                                                    <p>Download</p>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="info-box2 event-info-box2">
                            <div class="tracking-box1 event-tracking">
                                <div class="info-title">
                                    <p>Module Performance Monitoring</p>
                                    <div class="line"></div>
                                </div>

                                <div class="info-content">
                                    <div class="icon-text">
                                        <i class="fa-solid fa-book-open-reader"></i>
                                        <p>Total Enrolled: <?php echo $totalEnrolled ?></p>
                                    </div>

                                    <div class="icon-text">
                                        <i class="fa-solid fa-list-check"></i>
                                        <p>Total Quizzes: <?php echo $totalQuizzes . " Questions" ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="viewDetails-table">
                        <div class="info-title">
                            <p>Module Quizzes Result Tracking</p>
                            <div class="line"></div>
                        </div>

                        <table class="viewDetails-tableContent">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Result</th>
                                    <th>Award GP</th>
                                    <th>Total Attempts</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    foreach ($moduleResult as $row) {
                                        $user_name = getUserName($conn, $row["user_id"]);

                                        $resultFormat = $row["highest_score"] . " / " . $totalQuizzes;

                                        echo '<tr>
                                                <td>' . $user_name . '</td>
                                                <td>' . $resultFormat . '</td>
                                                <td>' . $row['awarded_points'] . '</td>
                                                <td>' . $row['total_attempt'] . '</td>
                                                <td>' . $row['finish_datetime'] . '</td>
                                              </tr>';
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