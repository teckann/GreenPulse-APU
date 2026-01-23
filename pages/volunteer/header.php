
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
        <a class="navLink" href="index.php">Home</a>
        <a class="navLink" href="event.php">Events</a>
        <a class="navLink" href="study.php">Study</a>
        <a class="navLink" href="redeem.php">Redeem</a>
        <a class="navLink" href="profile.php">Profile</a>
    </div>

    <button id="menuButton">🍔</button>

</div>

<div class="phoneHamburger">
    <div id="hamburgerUp">
        <a href="profile.php" >
            <div id="sidebarUp">
                <span>
                    <img src="../../src/avatars/U004_avatar.jpg" alt="User Profile" class="phoneProfilePic">
                </span>
                <?php
                    echo'<span id="userNameSideBar">Jimmy</span>'
                ?>
            </div>
        </a>

        <button class="close-btn">&times;</button>

    </div>

        
    <div class="searchBar" id="phoneSearchBar">
        <form id="headerSearch">
            <input autocomplete="off" class="searchArea" id="phoneSearchArea" type="text" name="search" placeholder="Search...">
            <button class="searchButton" id="phoneSearchButton" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>

            <ul class="dropDown" id="phoneSearchDropDown">
            </ul>
        </form>
    </div>

    <div id="headerNavBar">
        <a class="navLink" href="index.php">Home</a>
        <a class="navLink" href="event.php">Events</a>
        <a class="navLink" href="study.php">Study</a>
        <a class="navLink" href="redeem.php">Redeem</a>
        <a class="navLink" href="profile.php">Profile</a>
    </div>

</div>

<div id="pushDown">
        <p></p>
</div>
