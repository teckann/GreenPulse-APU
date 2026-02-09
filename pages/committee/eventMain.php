<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 
    include("../../backend/utility.php");

    $search = isset($_GET['search'])?$_GET['search']:'';
    $search = trim($search);
    $lowerSearch = strtolower($search);
    $sql = "SELECT e.*, 
               (e.capacity - IFNULL((SELECT COUNT(*) FROM attendance a WHERE a.event_id = e.event_id), 0)) as real_available_spot 
            FROM events e WHERE e.event_status = 'Active'";

    if (!empty ($search)){
        $sql .= " AND (LOWER(e.event_title) LIKE '%$lowerSearch%' OR LOWER(e.event_description) LIKE '%$lowerSearch%')";
    }

    $sql .= " ORDER BY e.posted_date DESC";
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
    <link rel="icon" type="image/png" href="../../src/elements/logo_vertical.png">
</head>
<body>
    <?php include ("header.php");?>

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

    <section class="event-controls-event-main">
        <form action = "#" method = "GET">
            <div class="search-filter-group">
                <div class="search-bar">
                    <input type="text" name = "search" placeholder="Search Events by title or description" class="searchInput">
                    <button type="submit" class = "event-search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            </form>
        
        <div class = "white-color-box">
            <section class="container-event">
                <?php
                    while ($rows = mysqli_fetch_array($result)){
                        $currentUserId = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
                        $isCreator = ($currentUserId !== null && $rows['user_id'] == $currentUserId);
                ?>
                <div class="content-card-event"> 

                <div class="event-left-section">
                    <div class="event-image">
                        <img src="../../<?php echo $rows['event_poster']; ?>" alt="Event Image">
                    </div>

                    <div class="button">
                        <?php if ($isCreator): ?>
                            <div class="btn-edit" onclick="window.location.href='eventEdit.php?event_id=<?php echo $rows['event_id']; ?>'">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368">
                                    <path d="M576-96v-113l210-209q7.26-7.41 16.13-10.71Q811-432 819.76-432q9.55 0 18.31 3.5Q846.83-425 854-418l44 45q6.59 7.26 10.29 16.13Q912-348 912-339.24t-3.29 17.92q-3.3 9.15-10.71 16.32L689-96H576Zm288-243-45-45 45 45ZM624-144h45l115-115-22-23-22-22-116 115v45ZM264-96q-30 0-51-21.15T192-168v-624q0-29.7 21.15-50.85Q234.3-864 264-864h312l192 192v152h-72v-104H528v-168H264v624h240v72H264Zm252-384Zm246 198-22-22 44 45-22-23Z"/>
                                </svg>
                            </div>
                            <div class="btn-delete" onclick="window.location.href='eventDelete.php?event_id=<?php echo $rows['event_id']; ?>'">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368">
                                    <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z"/>
                                </svg>
                            </div>
                        <?php else: ?>
                            <div class = "view-only">
                                View only
                            </div>
                        <?php endif; ?>

                        
                    </div>
                </div>

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
                        <span>AVAILABLE SPOT: <?php echo $rows['real_available_spot'];?></span>
                    </div>

                    <span class="event-status"><?php echo $rows['points_given']; ?> points</span>

                    <?php if ($isCreator): ?>
                        <div class="event-more" onclick = "window.location.href = 'eventMore.php?event_id=<?php echo $rows['event_id'];?>'">
                            <div class="points-badge">
                            <span>MORE</span>
                        </div>
                        </div>
                    <?php endif; ?>  
                    </div>
                </div>

                <div class="event-meta-row">
                    <div class="meta-item">
                    <span class="meta-label">SCHEDULED DATE</span>
                    <span class="meta-value">
                        <?php echo $rows['event_datetime']; ?>
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