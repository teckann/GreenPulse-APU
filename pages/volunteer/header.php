<?php 

if(!$userID){
    $userID = $_SESSION["userID"];
}

    $sql_profileDetails = "SELECT * FROM users WHERE user_id = '$userID';";

    $profileDetails = mysqli_fetch_assoc(mysqli_query($conn,$sql_profileDetails));

    $avatar = $profileDetails['avatar'];

?>


    <script src="../../scripts/volunteer_header.js"></script>


<div id="blockEverything"></div>

<div id="header">
    <div class="logo">
        <a id="logoLink" href="index.php">
            <img src="../../src/elements/logo_horizontal.png" alt="Green Pulse Logo" id="logoImg">

        </a>
    </div>

    <div class="searchBar" id="headerSearchBar">
        <form id="headerSearch">
            <input autocomplete="off" class="searchArea" id="headerSearchArea" type="text" name="search" placeholder="Search for Pages...">
            <button class="searchButton" id="headerSearchButton" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>

            <ul class="dropDown" id="searchDropDown">
            </ul>
        </form>
    </div>

    <div class="navBar">
        <a class="navLink" id="indexNav" href="index.php"><span>Home</span></a>
        <a class="navLink" id="eventNav" href="event.php"><span>Events</span></a>
        <a class="navLink" id="studyNav" href="study.php"><span>Study</span></a>
        <a class="navLink" id="redeemNav" href="redeem.php"><span>Redeem</span></a>
        <a class="navLink" id="profileNav" href="profile.php"><span>Profile</span></a>
    </div>

    <button id="menuButton"><i class="fa-solid fa-bars"></i>
</button>

</div>

<div class="phoneHamburger">
    <div id="hamburgerUp">
        <a href="profile.php" >
            <div id="sidebarUp">
                <span>
                    <img src="../../<?php echo$avatar ?>" alt="User Profile" class="phoneProfilePic">
                </span>
                <?php
                    echo'<span id="userNameSideBar">'.$_SESSION["userName"].'</span>'
                ?>
            </div>
        </a>

        <button class="close-btn">&times;</button>

    </div>

        
    <div class="searchBar" id="phoneSearchBar">
        <form id="phoneHeaderSearch">
            <input autocomplete="off" class="searchArea" id="phoneSearchArea" type="text" name="search" placeholder="Search...">
            <button class="searchButton" id="phoneSearchButton" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>

            <ul class="dropDown" id="phoneSearchDropDown">
            </ul>
        </form>
    </div>


    <div id="headerNavBar">

    <hr>
        <a class="navLink" href="index.php"><span>Home</span><i class="fa-solid fa-chevron-right wide-angle"></i></a>
        <a class="navLink" href="event.php"><span>Events</span><i class="fa-solid fa-chevron-right wide-angle"></i></a>
        <a class="navLink" href="study.php"><span>Study</span><i class="fa-solid fa-chevron-right wide-angle"></i></a>
        <a class="navLink" href="redeem.php"><span>Redeem</span><i class="fa-solid fa-chevron-right wide-angle"></i></a>
        <a class="navLink" href="profile.php"><span>Profile</span><i class="fa-solid fa-chevron-right wide-angle"></i></a>
    </div>

</div>

<div id="pushDown">
        <p></p>
</div>
