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

                <div class="box-container">  
                    <div class="terms-conditions">
                        <div class="box-title">
                            <h3 class="box-title-desktop">GreenPulse APU - Administrator Terms & Conditions</h3>
                            <h3 class="box-title-mobile">GreenPulse APU</h3>
                            <h3 class="box-title-mobile">Administrator Terms & Conditions</h3>
                            <p>Effective Date: December 11, 2025</p>
                            <p>Platform: GreenPulse APU Admin Panel</p>
                        </div>

                        <div class="box-content">
                            <ul>
                                <li>
                                    <strong>Data Privacy:</strong>
                                    You must strictly protect sensitive user data (e.g., Student IDs) and adhere to PDPA regulations.
                                    Unauthorized sharing of personal or confidential information is strictly prohibited.
                                </li>

                                <li>
                                    <strong>Account Security:</strong>
                                    Your admin account is personal. Do not share your login credentials or password with anyone under any circumstances.
                                </li>

                                <li>
                                    <strong>Content Accuracy:</strong>
                                    Ensure all posted information (including announcements) is accurate, truthful, and kept up-to-date at all times.
                                </li>

                                <li>
                                    <strong>Professional Conduct:</strong>
                                    Maintain a professional and respectful tone in all communications.
                                    Offensive, misleading, or irrelevant content is strictly forbidden.
                                </li>

                                <li>
                                    <strong>Account Integrity:</strong>
                                    Only register legitimate users (students and staff).
                                    Creating fake, duplicate, or unauthorized accounts is strictly prohibited.
                                </li>

                                <li>
                                    <strong>Termination:</strong>
                                    GreenPulse APU reserves the right to immediately revoke admin access if any of these terms are violated.
                                </li>
                            </ul>

                            <div class="slogan">
                                <p class="slogan-desktop">Manage with Clarity, Control with Confidence.</p>

                                <p class="slogan-mobile">Manage with Clarity,</p>
                                <p class="slogan-mobile">Control with Confidence.</p>
                            </div>
                        </div>
                    </div>

                    <div class="smallBox-container">
                        <div class="main-features">
                            <div class="box-title">
                                <h3>Main Features of Admin Panel</h3>
                            </div>

                            <div class="main-features-content">
                                <div>
                                    <strong>Dashboard: </strong>
                                    Overview of key metrics and recent activity.
                                </div>

                                <div>
                                    <strong>Manage Users: </strong>
                                    Add, edit, or remove student and staff accounts.
                                </div>

                                <div>
                                    <strong>Manage Events: </strong>
                                    Create and update events or view attendance.
                                </div>

                                <div>
                                    <strong>Manage Items: </strong>
                                    Track inventory and manage item details.
                                </div>

                                <div>
                                    <strong>Manage Modules: </strong>
                                    Configure academic modules and course settings.
                                </div>
                            </div>
                        </div>

                        <div class="tutorial-video">
                            <div class="box-title">
                                <h3>Admin Training Video</h3>
                            </div>

                            <video width=100% height=auto controls class="box-content">
                                <source src="../../src/elements/training.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include("footer.php"); ?>

        <script src="../../scripts/admin.js"></script>
        <script src="../../scripts/admin_carousel.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>