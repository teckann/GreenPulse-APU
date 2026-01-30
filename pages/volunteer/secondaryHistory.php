<?php

    include("eventBackend.php");

    include("historyFunction.php");

    include("../../conn.php");   

    switch (true) {
        case isset($_POST['event']):
            $header = 'Event Attended';
            $dataAttribute = 'eventHistory';
            $destinationFile = 'oneEvent';

            $sql_historyEvent = "SELECT * FROM events 
                                  WHERE event_id IN (
                                    SELECT event_id 
                                    FROM attendance 
                                    WHERE user_id = '$userID'
                                    AND attendance_status = 'Present'
                                );";



            $historyEvent = mysqli_query($conn,$sql_historyEvent);


            

            
            break;
        case isset($_POST['module']):
            $header = 'Quiz Answered';
            $dataAttribute = 'moduleHistory';
            $destinationFile = 'oneModule';

            $sql_historyModule = "SELECT m.*, mh.*,
                                 mh.user_id AS volunteer_id,
                                 (SELECT COUNT(*) FROM quiz WHERE quiz.module_id = m.module_id) AS total_quizes
                                 FROM modules m
                                 RIGHT JOIN module_history mh 
                                    ON m.module_id = mh.module_id 
                                    AND mh.user_id = '$userID';";




            break;
        case isset($_POST['merchandise']):
            $header = 'Merchandise Redeemed';
            $dataAttribute = 'merchandiseHistory';
            $destinationFile = 'itemHistory';

            $sql_historyMerchandise = "SELECT mph.*, items.*,
                                         mph.user_id AS volunteer_id, 
                                         (mph.amount * items.item_redeem_points) AS total_point_cost
                                         FROM merchandise_purchase_history mph
                                         JOIN items 
                                            ON mph.item_id = items.item_id
                                            AND mph.user_id = '$userID';";

            break;
        case isset($_POST['tree']):
            $header = 'Tree Adopted';
            $dataAttribute = 'treeHistory';
            $destinationFile = 'itemHistory';

            $sql_historyTree = "SELECT tah.*, items.*,
                                tah.user_id AS volunteer_id
                                FROM tree_adoption_history tah
                                JOIN items 
                                ON tah.item_id = items.item_id
                                AND tah.user_id = '$userID';";
            

            break;
        default:
            header("Location: index.php");
            break;
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <script src="../../scripts/volunteer_redeem.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
    <?php include("header.php") ?>

    <div class="eventHead" id="historyHead">
    <div id="historyBack">
        <div><a href="history.php" class="backEvent"><i class="fa-solid fa-arrow-left"></i></a> <?php echo $header; ?></div>
    </div>

    
    <div class="searchBar" id="historySearchBar">
        <form class="historySearchForm" >
            <input autocomplete="off" id="searchHistory" data-to-search="<?php echo$dataAttribute ?>" class="searchArea" type="text" name="search" placeholder="Search...">
            <button disabled class="searchButton" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>

        </form>
    </div>

    </div>

    <div id="secondaryHistoryContainer">



    <?php 

    
    switch (true) {
        case isset($_POST['event']):

            echo'<div class="event">';
            addEventCard($historyEvent);
            echo'</div>';

            
            break;
        case isset($_POST['module']):



                $allModule = mysqli_query($conn, $sql_historyModule);

                if(mysqli_num_rows($allModule) > 0){
                    while($oneModule = mysqli_fetch_assoc($allModule)){

                    if($oneModule["volunteer_id"] == $userID){
                        fillingRow($oneModule['module_name'], $oneModule['highest_score'].'/'.$oneModule['total_quizes'],
                                    $destinationFile ,'oneModule', $oneModule['module_id']);
                    }
                        
                    }
                }else{
                    echo '<p>No history</p>';
                }
            



            break;
        case isset($_POST['merchandise']):
            
                $allMerchandise = mysqli_query($conn, $sql_historyMerchandise);

                if(mysqli_num_rows($allMerchandise) > 0){
                    while($oneMerchandise = mysqli_fetch_assoc($allMerchandise)){
                        fillingRow($oneMerchandise['item_name'], $oneMerchandise['total_point_cost'].' GP',
                                    $destinationFile ,'merchandise', $oneMerchandise['merchandise_purchase_id']);
                        
                    }
                }else{
                    echo '<p>No history</p>';
                }

            break;
        case isset($_POST['tree']):
            
                $allTree= mysqli_query($conn, $sql_historyTree);

                if(mysqli_num_rows($allTree) > 0){
                    while($oneTree = mysqli_fetch_assoc($allTree)){
                        fillingRow($oneTree['given_name'], $oneTree['item_redeem_points'].' GP',
                                    $destinationFile ,'tree', $oneTree['tree_adoption_id']);
                        
                    }
                }else{
                    echo '<p>No history</p>';
                }
            

            break;
        default:
            header("Location: index.php");
            break;
    }


    ?>

    </div>

        
    <div class="reloadSpace">
        <i id="reloadIcon" class="fa-solid fa-rotate-right reload-icon"></i>     
    </div>

    <footer class="footerGeneral">
    <p>More events coming soon</p>
    </footer>



</body>
</html>