<?php
    function addEventCard($events) {
        if(mysqli_num_rows($events) > 0){
            while($oneEvent = mysqli_fetch_assoc($events)){
                echo'     <div class="eventBox">
                        <div class="event-left">
                            <img src="../../'.$oneEvent["event_poster"].'" alt="Event Picture" class="eventPic">
                        </div>

                        <div class="eventDetail">
                            <h4 class="eventTitle">'.$oneEvent["event_title"].'</h4>

                            <div class="eventRow">
                                <span class="oneEventDetail">
                                <i class="fa-regular fa-calendar"></i>
                                <span class="dateTime">'.$oneEvent["event_datetime"].'</span>
                                </span>

                                <span class="oneEventDetail">
                                <i class="fa-solid fa-location-dot"></i>
                                <span class="location">'.$oneEvent["location"].'</span>
                                </span>
                            </div>
                            <div>
                                <span class="oneEventDetail">
                                <i class="fa-solid fa-ticket"></i>
                                <span id="slotAvailability">'.$oneEvent["available_spot"].'</span>
                                </span>
                            </div>
                        </div>   
                        
                        <button class="viewEvent">View</button>
                    </div>
                ';
            }
        }else{
            echo '<p class="noEvents">More events coming soon</p>';
        }
    } 

    if(isset($_GET["searchMyEvent"])){

        include("../../conn.php");

        $toSearch = $_GET["searchMyEvent"];


        $sql_search_event = "SELECT * FROM events 
                            WHERE event_id IN (
                                SELECT event_id 
                                FROM attendance 
                                WHERE user_id = 'U004'
                            )
                            AND event_title LIKE '%$toSearch%';";

        if(isset($_GET["filtering"])){


            if(($_GET["filtering"]) == "upcoming"){

                $sql_search_event = "SELECT * FROM events 
                                        WHERE event_id IN (
                                            SELECT event_id 
                                            FROM attendance 
                                            WHERE user_id = 'U004'
                                        ) 
                                        AND event_datetime >= CURRENT_DATE
                                        AND event_title LIKE '%$toSearch%';";
                    

            }elseif(($_GET["filtering"]) == "past"){
                $sql_search_event = "SELECT * FROM events 
                                        WHERE event_id IN (
                                            SELECT event_id 
                                            FROM attendance 
                                            WHERE user_id = 'U004'
                                        ) 
                                        AND event_datetime < CURRENT_DATE
                                        AND event_title LIKE '%$toSearch%';";
            }
        }
        

        $findEvents = mysqli_query($conn,$sql_search_event);
        
        addEventCard($findEvents);

        mysqli_close($conn);

    }elseif (isset($_GET["searchAvailableEvent"])){

        include("../../conn.php");

        $toSearch = $_GET["searchAvailableEvent"] ?? '';


        $sql_search_event = "SELECT * FROM events 
                            WHERE event_datetime >= CURRENT_DATE
                            AND event_title LIKE '%$toSearch%';";
        

        $findEvents = mysqli_query($conn,$sql_search_event);
        
        addEventCard($findEvents);

        mysqli_close($conn);

    }

    
    if(isset($_GET["myfilter"])){

    include("../../conn.php");

        if(($_GET["myfilter"]) == "all"){
                $sql_all_my_event = "SELECT * FROM events 
                                    WHERE event_id IN (
                                        SELECT event_id 
                                        FROM attendance 
                                        WHERE user_id = 'U004'
                                    );";
                

                $allMyEvents = mysqli_query($conn,$sql_all_my_event);
                
                addEventCard($allMyEvents);


        }elseif(($_GET["myfilter"]) == "upcoming"){
            $sql_soon_my_event = "SELECT * FROM events 
                                    WHERE event_id IN (
                                        SELECT event_id 
                                        FROM attendance 
                                        WHERE user_id = 'U004'
                                    ) 
                                    AND event_datetime >= CURRENT_DATE;";
                

                $soonMyEvents = mysqli_query($conn,$sql_soon_my_event);
                
                addEventCard($soonMyEvents);
        }elseif(($_GET["myfilter"]) == "past"){
            $sql_past_my_event = "SELECT * FROM events 
                                    WHERE event_id IN (
                                        SELECT event_id 
                                        FROM attendance 
                                        WHERE user_id = 'U004'
                                    ) 
                                    AND event_datetime < CURRENT_DATE;";
                

                $pastMyEvents = mysqli_query($conn,$sql_past_my_event);
                
                addEventCard($pastMyEvents);
        }


        mysqli_close($conn);

    }
?>