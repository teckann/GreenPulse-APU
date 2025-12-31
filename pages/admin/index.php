<?php
    include("../../conn.php");

    // user data (total users, this month register user, last month register user)
    $sql_users = "SELECT 
                    -- total users
                    COUNT(*) as total_users,

                    -- this month register user
                    (SELECT COUNT(*) FROM users 
                    WHERE registration_date >= DATE_FORMAT(NOW(), '%Y-%m-01')) as this_month,

                    -- last month register user
                    (SELECT COUNT(*) FROM users 
                    WHERE registration_date >= DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01') 
                    AND registration_date < DATE_FORMAT(NOW(), '%Y-%m-01')) as last_month             
                  FROM users";

    $result_users = mysqli_query($conn, $sql_users);
    $data_users = mysqli_fetch_assoc($result_users);
    $users = array($data_users["total_users"], $data_users["this_month"], $data_users["last_month"]);


    $sql_trees = "SELECT 
                    -- total users
                    COUNT(*) as total_trees,

                    -- this month register user
                    (SELECT COUNT(*) FROM items WHERE category = 'tree'
                    AND posted_date >= DATE_FORMAT(NOW(), '%Y-%m-01')) as this_month,

                    -- last month register user
                    (SELECT COUNT(*) FROM items WHERE category = 'tree'
                    AND posted_date >= DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01') 
                    AND posted_date < DATE_FORMAT(NOW(), '%Y-%m-01')) as last_month             
                  FROM items WHERE category = 'tree'";

    $result_trees = mysqli_query($conn, $sql_trees);
    $data_trees = mysqli_fetch_assoc($result_trees);
    $trees = array($data_trees["total_trees"], $data_trees["this_month"], $data_trees["last_month"]);


    $sql_events = "SELECT 
                    -- total events
                    COUNT(*) as total_events,

                    -- this month posted events
                    (SELECT COUNT(*) FROM events 
                    WHERE posted_date >= DATE_FORMAT(NOW(), '%Y-%m-01')) as this_month,

                    -- last month posted events
                    (SELECT COUNT(*) FROM events 
                    WHERE posted_date >= DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01') 
                    AND posted_date < DATE_FORMAT(NOW(), '%Y-%m-01')) as last_month             
                  FROM events";

    $result_events = mysqli_query($conn, $sql_events);
    $data_events = mysqli_fetch_assoc($result_events);
    $events = array($data_events["total_events"], $data_events["this_month"], $data_events["last_month"]);


    // * testing data Here
    // $users = array(220, 0, 100);
    // $trees = array(270, 150, 120);
    // $events = array(12, 1, 10);
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

            <div class="data-container">
                <?php
                    $title = array("Total Users", "Total Trees", "Total Events");
                    $all_data = array($users, $trees, $events);
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

        </main>

        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>