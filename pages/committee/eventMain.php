<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    if (!isset($_SESSION['userID'])) {
        echo "<script>alert('Please login first!'); window.location.href='../guest/login.php';</script>";
        exit;
    }

    // Search Bar Step

    //1. Check if user click on the button
    $search = isset($_GET['search'])?$_GET['search']:'';

    //2 . trim and make word user seach to lower case
    $search = trim($search);
    $lowerSearch = strtolower($search);

    // . Build SQL query
    $sql = "SELECT * FROM events";

    // . If search is not empty then add WHERE clause
    if (!empty ($search)){
        // originally i type $sql = " WHERE... [=] but need to add [.] in front the =
        // = is assign [means change, cover, rewrite?]
        // . means concatenation assignment, so will add the sql clause after 
        // if no use [.] then the $sql will become " WHERE event_title LIKE '%search%' OR event_description LIKE '%$search%'"; 
        // [no "SELECT * FROM events";] so have error

        // LOWER(event_title) = temporary change the event_title in database into lowercase so can compare with user type eh word
        // wont change the word in database
        $sql .= " WHERE LOWER(event_title) LIKE '%$lowerSearch%' OR LOWER(event_description) LIKE '%$lowerSearch%'";
    }

    // the arrange the event by date
    $sql .= " ORDER BY event_id  DESC";

    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Page</title>
    <link rel="stylesheet" href="../../styles/committee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png"> -->
</head>
</head>
<body>
    <?php include ("header.php");?>
    
    <!-- Upper Part -->
    <div class="header-content">
        <div class="back-icon" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </div>
        
        <div class="heroSection">
            <h1>EVENT MANAGEMENT</h1>
            <p>CREATE AND MANAGE GREEN INITIATIVE EVENTS.</p>
        </div>
        
        <div class="add-icon" onclick="window.location.href='eventCreate.php'">
            <i class="fas fa-add"></i>
        </div>
    </div>

    <!-- Lower Part  -->
    <section class="event-controls-event-main">
        <form action="#" method = "GET">
            <div class="search-filter-group">
                <div class="search-bar">
                    <input type="text" name = "search" placeholder="Search Events by title or description" class="searchInput"
                    value = "<?php echo $search;?>">
                    <button type="submit" class = "event-search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            </form>
        
        <div class = "white-color-box">
            <section class="container-event">
                <?php
                    // Replace the event card section in your eventMain.php (starting from the while loop)
                    while ($rows = mysqli_fetch_array($result)){
                        // Check if current user is the creator
                        // Use userID from login page (matching your login.php session variable)
                        $currentUserId = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
                        $isCreator = ($currentUserId !== null && $rows['user_id'] == $currentUserId);
                    ?>
                <div class="content-card-event"> 

                <!-- Left Side: Image Section -->
                <div class="event-left-section">
                    <div class="event-image">
                        <img src="../../<?php echo $rows['event_poster']; ?>" alt="Event Image">
                    </div>

                    <div class="button">
                        <?php if ($isCreator): ?>
                            <!-- Only show edit/delete buttons if user created this event -->
                            <div class="btn-edit" onclick="window.location.href='eventEdit.php?event_id=<?php echo $rows['event_id']; ?>'">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368">
                                    <path d="M576-96v-113l210-209q7.26-7.41 16.13-10.71Q811-432 819.76-432q9.55 0 18.31 3.5Q846.83-425 854-418l44 45q6.59 7.26 10.29 16.13Q912-348 912-339.24t-3.29 17.92q-3.3 9.15-10.71 16.32L689-96H576Zm288-243-45-45 45 45ZM624-144h45l115-115-22-23-22-22-116 115v45ZM264-96q-30 0-51-21.15T192-168v-624q0-29.7 21.15-50.85Q234.3-864 264-864h312l192 192v152h-72v-104H528v-168H264v624h240v72H264Zm252-384Zm246 198-22-22 44 45-22-23Z"/>
                                </svg>
                            </div>
                            <div class="btn-delete" onclick="if(confirm('Are you sure you want to delete this event?')) { window.location.href='eventDelete.php?event_id=<?php echo $rows['event_id']; ?>'; }">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368">
                                    <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z"/>
                                </svg>
                            </div>
                        <?php else: ?>
                            <!-- Show message that only creator can edit -->
                            <div style="padding: 10px; color: #666; font-size: 12px; font-style: italic;">
                                View only
                            </div>
                        <?php endif; ?>
                    </div>
                </div>



                <!-- Right Side: Details Section -->
                <div class="event-right-section">
                    <div class = "event-posted-info">

                    <div class = "event-posted">
                            <div class = "event-posted-date-id">Event ID: <?php echo $rows['event_id']?></div>
                        </div>
                    <div class = "event-posted">
                            <div class = "event-posted-date-id">Posted by: <?php echo $rows['user_id']?></div>
                        </div>
                        <div class = "event-posted">
                            <div class = "event-posted-date-id">Posted on: <?php echo $rows['posted_date']?></div>
                        </div>
                    </div>

                    <div class = "event-title-row">
                        <h2 class="event-title"><?php echo $rows['event_title']; ?></h2>
                        <p class="event-description">
                            <?php echo $rows['event_description']; ?>
                        </p>
                    </div>

                <div class="status-points-row">
                    <div class = "event-status-row">

                    <div class="event-status">
                        <span class="circle"></span>
                        <span>CAPACITY: <?php echo $rows['capacity']?></span>
                    </div>

                    <div class="event-status">
                        <span class="circle"></span>
                        <span>AVAILABLE SPOT: <?php echo $rows['available_spot']?></span>
                    </div>

                    <span class="points-badge"><?php echo $rows['points_given']; ?> points</span>

                    <?php if ($isCreator): ?>
                        <div class="event-more" onclick = "window.location.href = 'eventMore.php?event_id=<?php echo $rows['event_id'];?>'">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </div>
                    <?php endif; ?>
   
                        
                    </div>
                </div>
                   


                <div class="event-meta-row">
                    <div class="meta-item">
                    <span class="meta-label">SCHEDULED DATE</span>
                    <span class="meta-value">
                        <?php echo date('M d, Y - h:i A', strtotime($rows['event_datetime'])); ?>
                    </span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">DURATION</span>
                    <span class="meta-value"><?php echo $rows['duration']; ?></span>
                </div>

                    </div>
                    <div class="event-meta-row">
                          <div class="meta-item">
                            <span class="meta-label">LOCATION</span>
                            <span class="meta-value"><?php echo $rows['location']; ?></span>
                        </div>
                    </div>
                </div>
                
                </div>
           <?php 
                } 
            
            ?>
            </section>
        </div>

    <?php
    include ("hamburgerMenu.php")?>
    
</body>
</html>