<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

    $sqlMerchandise = "SELECT COUNT(*) as total FROM items 
                       WHERE category = 'merchandise' AND item_status = 'Active'";
    $resultMerchandise = mysqli_query($conn, $sqlMerchandise);
    $rowMerchandise = mysqli_fetch_assoc($resultMerchandise);
    $merchandiseCount = $rowMerchandise['total'];
    
    $sqlTrees = "SELECT COUNT(*) as total FROM tree_adoption_history 
                 WHERE tree_adoption_status = 'Active'";
    $resultTrees = mysqli_query($conn, $sqlTrees);
    $rowTrees = mysqli_fetch_assoc($resultTrees);
    $treesPlanted = $rowTrees['total'];
    
    $sqlEvents = "SELECT COUNT(*) as total FROM events WHERE event_status = 'Active'";
    $resultEvents = mysqli_query($conn, $sqlEvents);
    $rowEvents = mysqli_fetch_assoc($resultEvents);
    $eventsCount = $rowEvents['total'];
    
    $sqlModules = "SELECT COUNT(*) as total FROM modules WHERE module_status = 'Active'";
    $resultModules = mysqli_query($conn, $sqlModules);
    $rowModules = mysqli_fetch_assoc($resultModules);
    $modulesCount = $rowModules['total'];
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

</head>
<body>
    <?php include ("header.php");?>

    <div class="video-container">
        <video autoplay muted loop playsinline class="background-video">
            <source src="../../src/elements/background-video.mp4" type="video/mp4">
        </video>

        <div class="video-content">
            <h1>APU GREENPULSE</h1>
            <h1>COMMITTEE HOME PAGE</h1>
        </div>
    </div>

    <div class="mission">
        <div class="whole-page">
            <div class="mission-left">
                <div class="mission-border">
                    <h1>WHO ARE APU GREENPULSE COMMITTEE</h1>
                </div>
                <p>The APU GreenPulse Committee is committed to planning, managing, and delivering sustainability initiatives that promote environmental awareness and active participation within the APU community.</p>
            </div>
        </div>

        <div class="image-under">
            <div class="background-image">
                <img src="../../src/elements/committee-background-image.jpg" alt="Committee Image">
            </div>
            <div class="background-image">
                <img src="../../src/elements/committee-background-image-2.jpg" alt="Committee Image">
            </div>
            <div class="background-image">
                <img src="../../src/elements/committee-background-image-3.jpg" alt="Committee Image">
            </div>
        </div>
    </div>

    <div class="current-impact">
        <div class="whole-page">
            <div class="big-title">
                <h1>CURRENT IMPACT.</h1>
                <div class = "impact-title">
                    <p class = year>2025</p>
                    <p class = "impact-description">The project has successfully achieved tree planting activities,<br>merchandise releases, event organization, and module development.</p>
                    <p class = "year">2026</p>
                </div>
            </div>
        </div>

        <div class="stats-container">
            <div class="stats-grid">
                <div class="current-impact-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px" fill="#2d5a27">
                        <path d="M160-280v80h640v-80H160Zm0-440h88q-5-9-6.5-19t-1.5-21q0-50 35-85t85-35q30 0 55.5 15.5T460-826l20 26 20-26q18-24 44-39t56-15q50 0 85 35t35 85q0 11-1.5 21t-6.5 19h88q33 0 56.5 23.5T880-640v440q0 33-23.5 56.5T800-120H160q-33 0-56.5-23.5T80-200v-440q0-33 23.5-56.5T160-720Zm0 320h640v-240H596l84 114-64 46-136-184-136 184-64-46 82-114H160v240Zm200-320q17 0 28.5-11.5T400-760q0-17-11.5-28.5T360-800q-17 0-28.5 11.5T320-760q0 17 11.5 28.5T360-720Zm240 0q17 0 28.5-11.5T640-760q0-17-11.5-28.5T600-800q-17 0-28.5 11.5T560-760q0 17 11.5 28.5T600-720Z"/>
                    </svg>            
                </div>
                <div class="stat-label">
                    <p>AVAILABLE MERCHANDISE</p>
                </div>
                <div class="data">
                    <h1><?php echo $merchandiseCount; ?></h1>
                </div>
            </div>

            <div class="stats-grid">
                <div class="current-impact-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#2d5a27">
                        <path d="M295.33-80v-152.67H0l177.33-262.66h-88L360-880l120 170.67L600-880l270.67 384.67h-87.34L960-232.67H665.33V-80h-130v-152.67h-110V-80h-130Zm381-219.33h158.34L657-562h81.67L600-759.33 523-649l107.67 153.67h-87.34l133 196Zm-550.33 0h468.67L417-562h81.67L360-759.33 221.33-562h82.34L126-299.33Zm0 0h177.67-82.34 277.34H417h177.67H126Zm550.33 0h-133 87.34H523h215.67H657h177.67-158.34Zm-141 66.66h130-130Zm185.67 0Z"/>
                    </svg>         
                </div>
                <div class="stat-label">
                    <p>TREES PLANTED</p>
                </div>
                <div class="data">
                    <h1><?php echo $treesPlanted; ?></h1>
                </div>
            </div>

            <div class="stats-grid">
                <div class="current-impact-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#2d5a27">
                        <path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/>
                    </svg>         
                </div>
                <div class="stat-label">
                    <p>EVENTS HELD</p>
                </div>
                <div class="data">
                    <h1><?php echo $eventsCount; ?></h1>
                </div>
            </div>

            <div class="stats-grid">
                <div class="current-impact-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#2d5a27">
                        <path d="M293.33-80q-55.23 0-94.28-39.05Q160-158.1 160-213.33v-533.34q0-55.23 39.05-94.28Q238.1-880 293.33-880H800v600q-25.67 0-42.83 19.83Q740-240.33 740-213.33q0 27 17.17 46.83 17.16 19.83 42.83 19.83V-80H293.33Zm-66.66-249q14.66-9 31.33-13.33 16.67-4.34 35.33-4.34H320v-466.66h-26.67q-27.77 0-47.22 19.44-19.44 19.45-19.44 47.22V-329Zm160-17.67h346.66v-466.66H386.67v466.66Zm-160 17.67v-484.33V-329Zm66.36 182.33h397.3q-8-14.66-12.5-31.5-4.5-16.83-4.5-35.16 0-18.67 4.34-35.34Q682-265.33 691-280H293.07q-27.74 0-47.07 19.44-19.33 19.45-19.33 47.23 0 28 19.33 47.33t47.03 19.33Z"/>
                    </svg>                
                </div>
                <div class="stat-label">
                    <p>MODULES CREATED</p>
                </div>
                <div class="data">
                    <h1><?php echo $modulesCount; ?></h1>
                </div>
            </div>

        </div>
    </div>

    <div class="current-impact green">
        <div class="whole-page">
            <div class = "start-manage-container">
                <div class = "start-manage-title">
                    <h1>READY TO MAKE A REAL-WORLD DIFFERENCE?</h1>
                    <p>Start Manage APU GreenPulse Now!</p>
                </div>
                <div class = "space"></div>
                <button class = "btn-manage-event" onclick = "window.location.href= 'availableTreePage.php'">
                Manage Now
            </button>
            </div>
</div>
</div>
<div class="copy-right">
        <p>Copyright 2026 &copy; GreenPulse APU. All rights reserved.</p>
    </div>

    <?php include ("hamburgerMenu.php");?>

    

</body>
</html>