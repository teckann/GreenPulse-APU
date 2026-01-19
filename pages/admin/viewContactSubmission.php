<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");

    if (isset($_GET["btnBack"])) {
        header("Location: manageEvents.php");
        exit;
    }

    $data = array();
    $allParticipantsInfo = array();

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
        
        $sql = "SELECT * FROM contact_submission WHERE submission_id = '$id'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
    }
    else {
        echo "<script>
                alert('Invalid Access');
                window.location.href = 'manageSystem.php';
              </script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>XXXXX</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>XXXXX</h1>
            <h2 class="page-subTitle">xxxxxxxx</h2>

            <div class="flex-container">
                
            </div>
        </main>
        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>