<?php 

    include("../../backend/sessionData.php");

    include("eventBackend.php");

    include("historyFunction.php");

    include("../../conn.php");   

    $userID = $_SESSION["userID"];
    
    
    if(isset($_GET["eventHistory"])){
        
        $toSearch = $_GET["eventHistory"];


        $sql_search_event_history = "SELECT * FROM events 
                                    WHERE event_id IN (
                                        SELECT event_id 
                                        FROM attendance 
                                        WHERE user_id = '$userID'
                                        AND attendance_status = 'Present'
                                    )
                                    AND event_title LIKE '%$toSearch%';";

        $searchHistoryEvent = mysqli_query($conn,$sql_search_event_history);

            echo'<div class="event">';
            addEventCard($searchHistoryEvent);
            echo'</div>';


    }else if(isset($_GET["moduleHistory"])){
        
        $toSearch = $_GET["moduleHistory"];


        $sql_search_module_history = "SELECT m.*, mh.*,
                                 mh.user_id AS volunteer_id,
                                 (SELECT COUNT(*) FROM quiz WHERE quiz.module_id = m.module_id) AS total_quizes
                                 FROM modules m
                                 RIGHT JOIN module_history mh 
                                    ON m.module_id = mh.module_id 
                                    AND mh.user_id = '$userID'
                                    AND m.module_name LIKE '%$toSearch%';";

        $searchHistoryModule = mysqli_query($conn, $sql_search_module_history);

                if(mysqli_num_rows($searchHistoryModule) > 0){
                    while($oneModule = mysqli_fetch_assoc($searchHistoryModule)){
                        fillingRow($oneModule['module_name'], $oneModule['highest_score'].'/'.$oneModule['total_quizes'],
                                    'oneModule' ,'module', $oneModule['module_id']);
                        
                    }
                }else{
                    echo '<p>No history</p>';
                }


    }else if(isset($_GET["merchandiseHistory"])){
        
        $toSearch = $_GET["merchandiseHistory"];


        $sql_search_merchandise_history = "SELECT mph.*, items.*,
                                         mph.user_id AS volunteer_id, 
                                         (mph.amount * items.item_redeem_points) AS total_point_cost
                                         FROM merchandise_purchase_history mph
                                         JOIN items 
                                            ON mph.item_id = items.item_id
                                            AND item_name LIKE '%$toSearch%';";

        $searchHistoryMerchandise = mysqli_query($conn, $sql_search_merchandise_history);

                if(mysqli_num_rows($searchHistoryMerchandise) > 0){
                    while($oneMerchandise = mysqli_fetch_assoc($searchHistoryMerchandise)){
                        fillingRow($oneMerchandise['item_name'], $oneMerchandise['total_point_cost'].' GP',
                                    'oneMerchandise' ,'merchandise', $oneMerchandise['merchandise_purchase_id']);
                        
                    }
                }else{
                    echo '<p>No history</p>';
                }


    }else if(isset($_GET["treeHistory"])){
        
        $toSearch = $_GET["treeHistory"];


        $sql_search_tree_history = "SELECT tah.*, items.*,
                                            tah.user_id AS volunteer_id
                                            FROM tree_adoption_history tah
                                            JOIN items 
                                            ON tah.item_id = items.item_id
                                            AND given_name LIKE '%$toSearch%';";

        $searchHistoryTree = mysqli_query($conn, $sql_search_tree_history);

                if(mysqli_num_rows($searchHistoryTree) > 0){
                    while($oneTree = mysqli_fetch_assoc($searchHistoryTree)){
                        fillingRow($oneTree['given_name'], $oneTree['item_redeem_points'].' GP',
                                    'oneTree' ,'tree', $oneTree['tree_adoption_id']);
                        
                    }
                }else{
                    echo '<p>No history</p>';
                }


    }




?>