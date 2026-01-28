<?php
    $sql_avatar = "SELECT * FROM users WHERE user_id = '$userID'";
    $result_avatar = mysqli_query($conn, $sql_avatar);
    $row = mysqli_fetch_assoc($result_avatar);
    $profilePhoto = $row["avatar"];

    $sql_announcement = "SELECT announcement_details FROM announcement ORDER BY announcement_datetime DESC LIMIT 1";
    $result_announcement = mysqli_query($conn, $sql_announcement);
    $announcement_row = mysqli_fetch_assoc($result_announcement);
    $latestAnnouncement = $announcement_row ? $announcement_row["announcement_details"] : "No announcements at this time.";

?> 

<nav class = "navigation-bar">
        <div class = "hamburger-menu">
            <button onclick = "toggleMenu()">
                <img src="../../src/committee/hamburgerMenu.svg" alt="Hamburger Menu">
            </button>
        </div>

    
        <div class = "logo" onclick = "window.location.href='index.php'">
            <img src="../../src/elements/logo_horizontal.png" alt="Logo">
        </div>

        <div class = "desktopMenu">
            <a href="index.php">Home</a>
            <a href="availableTreePage.php">Tree Adoption</a>
            <a href="merchandiseManagement.php">Merchandises</a>
            <a href="eventMain.php">Events</a>
            <a href="studyQuizMain.php">Study & Quiz</a>
        </div>
        
        <div class = "profile">
            <img src="../../<?php echo $profilePhoto ?>" alt="Profile Picture">
        </div>
    </nav>

    <div class = "banner">
        <marquee direction = "left" scrollamount = "10">
            <p><?php echo ($latestAnnouncement); ?></p>
        </marquee>
    </div>
</nav>

<div id="profileNavBarOverlay"></div>

<div id="profileRelatedNavBarPopUp">
    <div class="profileNavBarUpper"><div class="triangleUp"></div></div>
    <div class="profileNavBarBottom">
        <div><a href="committeeProfile.php">General Profile</a></div>
        <div><a href="securityCommonPage.php">Security Settings</a></div>
        <div><a href="../../backend/logoutRedirect.php">Log Out</a></div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const profilePhoto = document.querySelector(".profile")
        const profileNavBarPopUp = document.querySelector("#profileRelatedNavBarPopUp");
        const profileOverlay = document.querySelector("#profileNavBarOverlay");

        profilePhoto.addEventListener("click", () => {
            profileNavBarPopUp.classList.toggle("profileRelatedNavBarOpen");
            profileOverlay.classList.toggle("profileRelatedNavBarOpen");
        })

        profileOverlay.addEventListener("click", () => {
            profileNavBarPopUp.classList.toggle("profileRelatedNavBarOpen");
            profileOverlay.classList.toggle("profileRelatedNavBarOpen");
        })


        // const toggleProfileNavBar = () => {
        //     profileNavBarPopUp.classList.toggle("profileRelatedNavBarOpen");
        // }
    })
</script>