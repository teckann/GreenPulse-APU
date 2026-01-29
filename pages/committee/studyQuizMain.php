<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

    $search = isset($_GET['search'])?$_GET['search']:'';
    $search = trim($search);
    $lowerSearch = strtolower($search);
    
    $sql = "SELECT * FROM modules WHERE module_status = 'Active'";
    
    if (!empty($search)){
        $sql .= " AND (LOWER(module_name) LIKE '%$lowerSearch%' OR LOWER(module_description) LIKE '%$lowerSearch%')";
    }
    
    $sql .= " ORDER BY module_id DESC";
    
    $result = mysqli_query($conn, $sql);

   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study & Quiz Main Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include ("header.php");?>
    
    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>STUDY & QUIZ MANAGEMENT</h1>
            <p>MANAGE STUDY MATERIALS AND QUIZZES IN ONE PLACE.</p>
        </div>
        
        <div class="add-icon" onclick="window.location.href='studyQuizCreateMaterialQuiz.php'">
            <i class="fas fa-add"></i>
        </div>
    </div>

    <section class="event-controls-event-main">
        <form action="#" method = "GET">
            <div class="search-filter-group">
                <div class="search-bar">
                    <input type="text" name = "search" placeholder="Search Events by title or description" class="searchInput">
                    <button type="submit" class = "event-search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
               
        <div class="white-color-box">
             <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($rows = mysqli_fetch_array($result)){
                            $currentUserId = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
                            $isCreator = ($currentUserId !== null && $rows['user_id'] == $currentUserId);
                ?>
            <section class="container-event">
                <div class="content-card-event">
                    <div class="event-left-section">
                        <div class="event-image">
                            <img src="../../<?php echo $rows['module_cover']; ?>" alt="Module Cover">
                        </div>
                    </div>

                    <div class="event-right-section">
                        <div class = "event-posted-info">
                            <div class = "event-posted">
                                <div class = "event-posted-date-id">Module ID: <?php echo $rows['module_id']?></div>
                                </div>
                            <div class = "event-posted">
                                <div class = "event-posted-date-id">Posted by: <?php echo $rows['user_id']?></div>
                            </div>
                            </div>

                        <div class="status-points-row">
                            <div class="more-section" onclick="window.location.href = 'studyQuizModule.php?module_id=<?php echo $rows['module_id'];?>'">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </div>
                        </div>

                        <h2 class="event-title"><?php echo $rows['module_name']?></h2>

                        <p class="event-description">
                            <?php echo $rows['module_description']?>
                        </p>
                    </div>
                </div>
                <?php 
                        } 
                    } else {
                        echo "<p style='text-align: center; padding: 20px;'>No modules found.</p>";
                    }
                ?>
            </section>
        </div>
    </section>

    <?php include ("hamburgerMenu.php");?>
</body>
</html>