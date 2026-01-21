<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");

    if (isset($_GET["btnBack"])) {
        header("Location: manageModules.php");
        exit;
    }

    if (isset($_GET["id"])) {

    }
    else {
        
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
            </div>
        </main>
        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>