<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");

    $sql = "SELECT * FROM users";
    $target = "";

    // if (isset($_GET["btnSearch"])) {
    //     $attribute = $_GET["attribute"];
    //     $target = $_GET["target"];

    //     $sql = "SELECT * FROM tblstudent WHERE name LIKE '{$target}%'";
    // }

    if (isset($_GET["btnChangeStatus"])) {
        $targetUserID = $_GET["target_userID"];
        $nextStatus = $_GET["next_status"];

        $sql_updateStatus = "UPDATE users SET account_status = '$nextStatus' WHERE user_id = '$targetUserID'";
        mysqli_query($conn, $sql_updateStatus);
    }

    // $show_accountStatus_success = isset($_GET["status"]) && $_GET["status"] === "updated";

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
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
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

                                                    <a href="edit_user.php?id=' . $row['user_id'] . '" class="action-btn" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>

        <?php include("footer.php"); ?>

        <!-- toastr option settings -->
        <script src="../../scripts/toastr_settings.js"></script>
        <script src="../../scripts/admin.js"></script>
    </body>
</html>

<?php
    // if ($show_accountStatus_success) {
    //     echo "<script>
    //             toastr.success('Account Status Successfully Updated');
    //           </script>";
    // }

    mysqli_close($conn);
?>