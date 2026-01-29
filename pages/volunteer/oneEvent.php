<?php

    include("../../conn.php");

    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];

    if(isset($_POST["register"])){
        $insertEventid = $_POST["register"];

        $now_dateTime_toInsert = date('Y-m-d H:i:s');

        $sql_register_event = "INSERT attendance 
                                (event_id, user_id, event_register_datetime, attendance_status)
                                VALUES('$insertEventid','$userID','$now_dateTime_toInsert','Absent')";


            if(mysqli_query($conn,$sql_register_event)){
                
            }else{
                echo "Error: " . $sql_register_event . "<br>" . mysqli_error($conn);
            }
           
    }

    if(isset($_POST["oneEvent"])){
        $event_id = $_POST["oneEvent"];
    } elseif (isset($_POST["register"])) {
        $event_id = $_POST["register"];
    }


    if($event_id){
        

        $sql_one_event = "SELECT *,
                             (SELECT attendance_status FROM attendance WHERE event_id = '$event_id' AND user_id = '$userID') AS attendance_status
                             FROM events WHERE event_id = '$event_id';";

        $clickedEvent = mysqli_fetch_assoc(mysqli_query($conn,$sql_one_event));

        $event_dateTime = new DateTime($clickedEvent["event_datetime"]);
        $now_dateTime = new DateTime();
        $disabledOrNot = '';

        if($event_dateTime >= $now_dateTime){
            $sql_registered_user = "SELECT COUNT(*) AS totalRegistered FROM attendance WHERE event_id = '$event_id'";
            
            $totalRegister = mysqli_fetch_assoc(mysqli_query($conn,$sql_registered_user))["totalRegistered"];

            if(isset($clickedEvent["attendance_status"])){
                
                $btn = 'Registered! :)';
                $disabledOrNot = 'disabled';
            }else if($totalRegister == $clickedEvent["capacity"]){
                $btn = 'Event Full';
                $disabledOrNot = 'disabled';
            }else{
                $btn = 'Register Now!';
                
            }

        }else{
            $disabledOrNot = 'disabled';

            if($clickedEvent["attendance_status"] == 'Present'){
                $btn = 'You Attended 🎉';
            }else if($clickedEvent["attendance_status"] == 'Absent'){
                $btn = 'You Missed :(';
            }else{
                $btn = 'Register Closed';
            }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body><?php include("header.php") ?>

    <div class="profileHead">
        <div>
            <button href="event.php" class="backEvent" id="oneEventBack">
                <i class="fa-solid fa-arrow-left"></i>
            </button> 
        </div>
    </div>

    <div class="eventDetailContainer">

        <div class="oneEventLeft">
            
            <div class="oneEventPic">
                <img src="../../src/eventPosters/poster1.png" alt="Event Image" class="oneEventImg">
            </div>

            <div class="eventFirstSection">
                <h1 class="oneEventTitle"><?php echo$clickedEvent["event_title"]; ?></h1>
                <p class="oneEvent-PostedDate">Posted on <?php echo$clickedEvent["posted_date"]; ?></p>
            </div>

            <div class="eventDescriptionBox">
                <h3 class="descLabel">Description</h3>
                <p class="descText">
                    <?php echo$clickedEvent["event_description"]; ?>
                </p>
            </div>
        </div>

        <div class="oneEventRight">
            
            <div class="oneEvent-infoCard">
                
                <div class="infoRow">
                    <div class="infoIcon"><i class="fa-regular fa-calendar"></i></div>
                    <div class="infoText">
                        <div class="infoLabel">When</div>
                        <div class="infoToFill1"><?php echo date('Y-m-d', strtotime($clickedEvent["event_datetime"])); ?></div>
                        <div class="infoToFill2"><?php echo date('H:i:s', strtotime($clickedEvent["event_datetime"])); ?></div>
                    </div>
                </div>

                <div class="infoRow">
                    <div class="infoIcon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="infoText">
                        <div class="infoLabel">Where</div>
                        <div class="infoToFill1"><?php echo$clickedEvent["location"]; ?></div>
                    </div>
                </div>

                <div class="infoRow">
                    <div class="infoIcon"><i class="fa-solid fa-gift"></i></div>
                    <div class="infoText">
                        <div class="infoLabel">Reward</div>
                        <div class="infoToFill1">+ <?php echo$clickedEvent["points_given"]; ?> GP</div>
                    </div>
                </div>

                <div class="infoRow" id="infoRow-last">
                    <div class="infoText" id="infoText-last">
                        <div class="infoLabel">Availability</div>

                        <?php
                        if(isset($totalRegister)){
                            echo'<div class="oneEventAvailability">
                                <span>'.($clickedEvent["capacity"] - $totalRegister).' spots left</span>
                                <span class="maxSlot">Max: '.$clickedEvent["capacity"].'</span>
                            </div>
                            
                            <div class="oneEventProgressBar">
                                <div class="oneEventProgressFill" style="width:
                                '. ($totalRegister/$clickedEvent["capacity"]*100).'%">
                                </div>
                            </div>';
                        }else{
                            echo'<div class="oneEventAvailability">
                                <span> Event Ended </span>
                            </div>';
                        }
                        ?>

                    </div>
                </div>

                <form action="" method="POST">

                <?php 
                echo'<button '.$disabledOrNot.' class="registerBtn" name="register" type="submit" value="'.$event_id.'">'.$btn.'</button>' 
                ?>

                </form>

            </div>
        </div>

    </div>

    
</body>
</html>

<?php 
}else{
    header('Location: event.php');
}
mysqli_close($conn); ?>