<?php
    $sql_userInfo = "SELECT avatar FROM users WHERE user_id = '$userID'";
    $result_userInfo = mysqli_query($conn, $sql_userInfo);
    $data_userInfo = mysqli_fetch_assoc($result_userInfo);

    $avatar = $data_userInfo["avatar"] ?? "src/avatars/default.png";
?>

<nav>
    <button id="open-menu" class="icon-menu">
        <i class="fa-solid fa-bars"></i>
    </button>
    <h2>GreenPulse APU</h2>
</nav>

<aside id="sidebar">
    <button id="close-menu" class="icon-menu">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <img src="../../src/elements/logo.png" alt="Logo" width="70rem" height="70rem">
    
    <div class="search-box">
        <input type="text" id="txtSearchInput" placeholder="Search...">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>

    <p class="sidebar-subTitle">Main Menu</p>

    <div class="nav-pages">
        <a id="dashboard" href="../../pages/admin/index.php">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>

        <a id="manageUsers" href="../../pages/admin/manageUsers.php">
            <i class="fa-solid fa-users"></i> Manage Users
        </a>

        <a id="manageEvents" href="#">
            <i class="fa-solid fa-calendar-check"></i> Manage Events
        </a>

        <a id="manageItems" href="#">
            <i class="fa-solid fa-box-open"></i> Manage Items
        </a>

        <a id="manageModules" href="#">
            <i class="fa-solid fa-layer-group"></i> Manage Modules
        </a>

        <a id="ManageSystem" href="#">
            <i class="fa-solid fa-gear"></i> Manage System
        </a>

        <a id="logActivity" href="#">
            <i class="fa-solid fa-clipboard-list"></i> Log Activity
        </a>
    </div>

    <p class="sidebar-subTitle">Account</p>
    <div class="nav-pages">
        <a id="profile" href="#">
            <i class="fa-solid fa-user"></i> Profile
        </a>

        <a id="guildeline" href="#">
            <i class="fa-solid fa-book"></i> Guildeline
        </a>
    </div>

    <div class="user-info-section">
        <img src="../../<?php echo $avatar ?>" alt="user_avatar" width="35px" height="35px">

        <div class="user-info-box">
            <p class="name"> <?php echo $userName ?? "Unknown User" ?> </p>
            <p class="role">Admin</p>
        </div>

        <form action="../../logoutRedirect.php" method="POST" class="logout-form">
            <button type="submit" class="logout-btn" title="Logout">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
        </form>
    </div>
</aside>