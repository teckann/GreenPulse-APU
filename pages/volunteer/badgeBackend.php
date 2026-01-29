<?php 
                
    include("../../conn.php");

    include("pointBackend.php");

    function getNewRequiredPoint($conn){
        $sql_totalPoint = "SELECT total_earned FROM users WHERE user_id = 'U004'";

            $totalPoints = mysqli_fetch_assoc(mysqli_query($conn,$sql_totalPoint));
            $totalPoint = $totalPoints['total_earned'];

            $sql_requiredPoints = "SELECT MIN(points_required) AS result 
                                    FROM badges 
                                    WHERE points_required > '$totalPoint'";

            $requiredPoints = mysqli_fetch_assoc(mysqli_query($conn,$sql_requiredPoints));


            if($requiredPoints != null){
                return $requiredPoints['result'];
            }else{
                return 0;
            }

    }

    function getPrevRequiredPoint($conn){
            $sql_totalPoint = "SELECT total_earned FROM users WHERE user_id = 'U004'";

        
            $totalPoints = mysqli_fetch_assoc(mysqli_query($conn,$sql_totalPoint));
            $totalPoint = $totalPoints['total_earned'];


            $sql_lastRequiredPoints = "SELECT MAX(points_required) AS result 
                                        FROM badges 
                                        WHERE points_required <= '$totalPoint'";

            $lastRequiredPoints = mysqli_fetch_assoc(mysqli_query($conn,$sql_lastRequiredPoints));

            if($lastRequiredPoints != null){
                
                return $lastRequiredPoints['result'];
            }else{
                return 0;
            }
    }

    function getRemainmingPoint($conn){

            $newRequiredPoints = getNewRequiredPoint($conn);
            $lastRequiredPoints = getPrevRequiredPoint($conn);


            if($newRequiredPoints != null && $lastRequiredPoints != null && 
                $newRequiredPoints > 0 && $lastRequiredPoints > 0){
                return ($newRequiredPoints - $lastRequiredPoints);
                
            }else{
                return $newRequiredPoints;
            }
    }

    if(isset($_GET["getBadge"])){

        if(($_GET["getBadge"]) == "requiredPoints"){
            echo(getNewRequiredPoint($conn));

        }else if(($_GET["getBadge"]) == "remainmingPoints"){
            echo(getRemainmingPoint($conn));

        }else if(($_GET["getBadge"]) == "badgePercentage")
            if(getTotalPoint($conn) != '0'){
                echo((getTotalPoint($conn) - getPrevRequiredPoint($conn)) / getRemainmingPoint($conn));
                    
            }else {
                echo '0';
            }
            
        mysqli_close($conn);
        exit();
    }


    
?>

