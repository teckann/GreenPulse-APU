<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Items</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Manage Items</h1>
            <h2 class="page-subTitle">Overview of all posted items</h2>

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