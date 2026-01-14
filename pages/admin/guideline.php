<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Guideline</title>

        <link rel="stylesheet" href="../../styles/admin.css">
        <link rel="stylesheet" href="../../styles/carousel.css">
        <?php include("library.php"); ?>
    </head>

    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Guideline</h1>
            <h2 class="page-subTitle">Administrator rules & regulations</h2>

            <div class="flex-container">
                <?php include("carousel.php"); ?>

                <div>  
                    hihi
                </div>
            </div>
        </main>

        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
        <script src="../../scripts/carousel.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>