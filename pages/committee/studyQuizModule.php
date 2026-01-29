<?php
    include("../../conn.php");
    include("../../backend/sessionData.php"); 

    $moduleID = mysqli_real_escape_string($conn, $_GET['module_id']);
    $sql = "SELECT * FROM modules WHERE module_id = '$moduleID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) <= 0) {
        echo "<script>alert('Module not found!'); window.location.href='eventMain.php';</script>";
        exit;
    }

    $rows = mysqli_fetch_assoc($result);

    $sql = "SELECT m.*, u.name
    FROM modules m 
    LEFT JOIN users u ON m.user_id = u.user_id
    WHERE m.module_id = '$moduleID'";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study & Quiz Module Page</title>
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
            <p>VIEW THE DETAILS AND IMPORTANT INFORMATION HERE.</p>
        </div>

        <div class="back-icon-hidden" onclick="window.location.href='eventCreate.php'">
            <i class="fas fa-arrow-left"></i>
        </div>

    </div>

    <section class="event-controls-event-main">
        <div class = "white-color-box">
        <div class="event-details-container">
            <?php
                while ($rows = mysqli_fetch_array($result)){
                    $currentUserId = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
                    $isCreator = ($currentUserId !== null && $rows['user_id'] == $currentUserId);
                ?>
                <div class="left-side-container">

                    <div class="left-side-info-box">

                        <div class="more-poster">
                            <img src="../../<?php echo $rows['module_cover']; ?>" alt="Module Cover">
                        </div>
                        <div class="info-row">
                            <span class="info-label">Posted By:</span>
                            <span class="info-value"><?php echo $rows['user_id']?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Posted By:</span>
                            <span class="info-value"><?php echo $rows['name']?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status:</span>
                            <span class="info-value"><?php echo $rows['module_status']?></span>
                        </div>
                    </div>

                    <div class="left-side-info-box-edit-dlt">
                        <div class="info-row">
                            <span class="info-label">Manage Module</span>
                            <div class="study-quiz-button">
                                <?php if ($isCreator): ?>
                                    <div class="btn-edit" onclick="window.location.href='studyQuizEditMaterial.php?module_id=<?php echo $rows['module_id']; ?>'">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368">
                                            <path d="M576-96v-113l210-209q7.26-7.41 16.13-10.71Q811-432 819.76-432q9.55 0 18.31 3.5Q846.83-425 854-418l44 45q6.59 7.26 10.29 16.13Q912-348 912-339.24t-3.29 17.92q-3.3 9.15-10.71 16.32L689-96H576Zm288-243-45-45 45 45ZM624-144h45l115-115-22-23-22-22-116 115v45ZM264-96q-30 0-51-21.15T192-168v-624q0-29.7 21.15-50.85Q234.3-864 264-864h312l192 192v152h-72v-104H528v-168H264v624h240v72H264Zm252-384Zm246 198-22-22 44 45-22-23Z"/>
                                        </svg>
                                    </div>
                                    <div class="btn-delete" onclick="if(confirm('Are you sure you want to delete this module?')) { window.location.href='studyQuizDeleteMaterial.php?module_id=<?php echo $rows['module_id']; ?>'; }">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368">
                                            <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z"/>
                                        </svg>
                                    </div>
                                <?php else: ?>
                                    <div style="padding: 10px; color: #666; font-size: 12px; font-style: italic;">
                                        View only
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            
                        </div>
                        <div class="info-row">
                            <span class="info-label">Manage Quiz</span>
                            <div class="study-quiz-button">
                                <?php if ($isCreator): ?>
                                    <div class="btn-edit" onclick="window.location.href='studyQuizEditQuiz.php?module_id=<?php echo $rows['module_id']; ?>'">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368">
                                            <path d="M576-96v-113l210-209q7.26-7.41 16.13-10.71Q811-432 819.76-432q9.55 0 18.31 3.5Q846.83-425 854-418l44 45q6.59 7.26 10.29 16.13Q912-348 912-339.24t-3.29 17.92q-3.3 9.15-10.71 16.32L689-96H576Zm288-243-45-45 45 45ZM624-144h45l115-115-22-23-22-22-116 115v45ZM264-96q-30 0-51-21.15T192-168v-624q0-29.7 21.15-50.85Q234.3-864 264-864h312l192 192v152h-72v-104H528v-168H264v624h240v72H264Zm252-384Zm246 198-22-22 44 45-22-23Z"/>
                                        </svg>
                                    </div>
                                    <div class="btn-delete" onclick="window.location.href='studyQuizDeleteQuiz.php?module_id=<?php echo $rows['module_id']; ?>'">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#5f6368">
                                            <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z"/>
                                        </svg>
                                    </div>
                                <?php else: ?>
                                    <div style="padding: 10px; color: #666; font-size: 12px; font-style: italic;">
                                        View only
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
           
                <div class="right-side-container">
                    <div class="detail-box">
                        <div class="detail-content">
                            <span class="detail-label">MODULE NAME</span>
                            <span class="detail-value"><?php echo $rows['module_name']?></span>
                        
                        </div>
                    </div>

                    <div class="detail-box">
                        <div class="detail-content">
                            <span class="detail-label">STUDY MATERIAL</span>
                            <div class="detail-value">
                            
                          
                         
                          <button class="btn-study-material"
                            onclick="window.open('../../<?php echo $rows['module_material']; ?>', '_blank')">
                            View Material
                        </button>


                            </div>
                        </div>
                    </div>


                     <div class="detail-box">
                        <div class="detail-content">
                            <span class="detail-label">STUDY VIDEO</span>
                            <div class="detail-value">
                            <video controls><source src="../../<?php echo $rows['module_video']; ?>"></video> <!-- Video format use <video controls>-->
                            </div>
                        </div>
                    </div>

                    <div class="description-container">
                        <div class="detail-icon">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <div class="detail-content">
                            <span class="detail-label">EVENT DESCRIPTION</span>
                            <p class="description-text">
                              <?php echo $rows['module_description']; ?>
                            </p>
                        </div>
                   
                

            </div>
        </div>
                <?php 
                } 
            
            ?>
    </section>
    </div>

    <?php include ("hamburgerMenu.php");?>

</body>
</html>