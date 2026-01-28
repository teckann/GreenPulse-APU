<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/unsetRegisterData.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Committee Home Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
<body>
    <?php include ("header.php");?>

    <section class="heroSection">
        <h1>APU GREENPULSE</h1>
        <p>GROW GREENER FUTURES — VOLUNTEER, SHARE, CELEBRATE.</p>
    </section>

    <section class="content-section">
        <div class="content-card">
            <div class="card-content">
                <h3>Tree Adoption</h3>
                <p>Add, edit, and delete tree records for management.</p>
                
                <button class="card-button" onclick="window.location.href='availableTreePage.php'">
                    <span>Tree Adoption</span>
                    <span>→</span>
                </button>

            </div>
        </div>

        <div class="content-card">
            <div class="card-content">
                <h3>Merchandises</h3>
                <p>Add, edit, and delete merchandise records for management.</p>
                <button class="card-button" onclick="window.location.href='merchandiseManagement.php'">
                    <span>Merchandises</span>
                    <span>→</span>
                </button>
            </div>
        </div>

        <div class="content-card">
            <div class="card-content">
                <h3>Events</h3>
                <p>Add, edit, and delete events records for management.</p>
                <button class="card-button" onclick="window.location.href='eventMain.php'">
                    <span>Events</span>
                    <span>→</span>
                </button>
            </div>
        </div>

        <div class="content-card">
            <div class="card-content">
                <h3>Study & Quiz</h3>
                <p>Add, edit, and delete quiz records for management.</p>
                <button class="card-button" onclick="window.location.href='study&Quiz.php'">
                    <span>Study & Quiz</span>
                    <span>→</span>
                </button>
            </div>
        </div>
    </section>

    <?php include ("hamburgerMenu.php");?>

</body>
</html>