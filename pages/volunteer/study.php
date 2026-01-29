<?php
    include("studyBackend.php");

    include("../../conn.php");

    
    include("../../backend/sessionData.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <script src="../../scripts/volunteer_study.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        .navBar #studyNav {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
        }

        .navBar #studyNav span {
            color: #000000;
            
            background-color: #ffffff3c; 
            
            border-radius: 0 0 22px 22px; 
            
        }

        .navBar #studyNav:hover {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
            border-radius: 0;
            transform: translateY(0px);

        }

        .navBar .studyNav:hover span {
            color: #000000; 
        }
    </style>
</head>
<body>
    <?php include("header.php") ?>

    <div class="secondGeneralHeader">
 
    <div class="searchBar" id="studySearchBar">
        <form class="studySearchForm" >
            <input autocomplete="off" id="searchStudy" class="searchArea" type="text" name="search" placeholder="Search...">
            <button class="searchButton" id="searchEventBtn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    </div>
    <div class="containerSmallNav">
        <div class="smallNav">
            <div class="smallNavColumn" id="navStudy1">
                <button class="smallNavBtn" id="availableStudyNav">Available Module</button>
            </div>


            <div class="smallNavColumn" id="navStudy2">
                <button class="smallNavBtn" id="completedStudyNav">Completed Module</button>
            </div>

        </div>
    </div>

    <div class="studyMain" id="availableStudy">
        <?php

                $sql_moduleAvailable = "SELECT * FROM modules 
                                    WHERE module_status = 'Active';";
                

                $module = mysqli_query($conn,$sql_moduleAvailable);

                addModuleCard($module);

            ?>
    </div>

    <div class="studyMain" id="completedStudy">
        <?php

                $sql_moduleCompleted = "SELECT * FROM modules 
                                    WHERE module_id IN (
                                        SELECT module_id 
                                        FROM module_history 
                                        WHERE user_id = 'U004'
                                    ) 
                                    AND module_status = 'Active';";
                

                $modules = mysqli_query($conn,$sql_moduleCompleted);

                addModuleCard($modules);

            ?>

    </div>

        
    <div class="reloadSpace">
        <i id="reloadIcon" class="fa-solid fa-rotate-right reload-icon"></i>     
    </div>




</body>
</html>