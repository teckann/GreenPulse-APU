<?php 
                
    include("../../conn.php");

    function getCurrentPoint($conn){
        $sql_currentPoint = "SELECT green_points FROM users WHERE user_id = 'U004'";

        $greenPoints = mysqli_fetch_assoc(mysqli_query($conn,$sql_currentPoint));

        if($greenPoints != null){
            return $greenPoints['green_points'];
        }else{
            return 0;
        }
    }

    function getTotalPoint($conn){
        $sql_totalPoint = "SELECT total_earned FROM users WHERE user_id = 'U004'";

        $totalPoints = mysqli_fetch_assoc(mysqli_query($conn,$sql_totalPoint));

        if($totalPoints != null){
            return $totalPoints['total_earned'];
        }else{
            return 0;
        }
    }

    if(isset($_GET["getPoint"])){

        if(($_GET["getPoint"]) == "currentpoint"){
            echo(getCurrentPoint($conn));

        }elseif(($_GET["getPoint"]) == "totalPoint"){
            echo(getTotalPoint($conn));
        }

        mysqli_close($conn);
        exit();
    }



    
?>