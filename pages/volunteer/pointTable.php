<?php 
    include("../../conn.php");

    
    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];



    if(isset($_GET["selectedMonth"]) && isset($_GET["showingPF"])){

    

    $selectedMonth = $_GET["selectedMonth"];
    $showing = $_GET["showingPF"];

    if($showing == 'earnedPoint'){
        $backTitle = "Points Earned";
        $secondColumn = "Source";

        $sql_flow_data = "(
                        SELECT 'Event' as category, e.points_given as quantity, e.event_datetime as date
                        FROM attendance a JOIN events e 
                        ON a.event_id = e.event_id
                        WHERE a.user_id = '$userID' AND a.attendance_status = 'Present'
                        AND DATE_FORMAT(e.event_datetime, '%Y-%m') = '$selectedMonth'
                    )

                    UNION ALL

                    (
                        SELECT 'Quiz' as category, mh.awarded_points as quantity, mh.finish_datetime as date
                        FROM module_history mh JOIN modules m ON mh.module_id = m.module_id
                        WHERE mh.user_id = '$userID' 
                        AND DATE_FORMAT(mh.finish_datetime, '%Y-%m') = '$selectedMonth'
                    )
                        
                    ORDER BY date DESC;";
    }else if($showing == 'spentPoint'){
        

        $backTitle = "Points Spent";
        $secondColumn = "Category";

        $sql_flow_data = "(
                            SELECT 'Merchandise' as category, (mph.amount * i.item_redeem_points) as quantity, mph.merchandise_purchase_datetime as date
                            FROM merchandise_purchase_history mph JOIN items i 
                            ON mph.item_id = i.item_id
                            WHERE mph.user_id = '$userID' 
                            AND DATE_FORMAT(mph.merchandise_purchase_datetime, '%Y-%m') = '$selectedMonth'
                        )

                        UNION ALL

                        (
                            SELECT 'Tree' as category, i.item_redeem_points as quantity, tah.tree_adoption_datetime as date
                            FROM tree_adoption_history tah JOIN items i 
                            ON tah.item_id = i.item_id
                            WHERE tah.user_id = '$userID' 
                            AND DATE_FORMAT(tah.tree_adoption_datetime, '%Y-%m') = '$selectedMonth'
                        )
                    
                        ORDER BY date DESC;";
    }

    $pointFlow = mysqli_query($conn, $sql_flow_data);







?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">


    <title>Point</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <script src="../../scripts/volunteer_point.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
    <?php include("header.php") ?>

    <div id="pointHead">
    <div>
        <form method="post" action="pointFlow.php">
        <input type="hidden" name="pointFlow" value="<?php echo$showing ?>">
        <input type="hidden" name="selectedMonth"  value="<?php echo$selectedMonth ?>">
        <div><button type="submit" class="backPoint" id="backFromPoint"><i class="fa-solid fa-arrow-left"></i> <?php echo $backTitle ?> </button>  </div>
        </form>
    </div>

    </div>


    <div class="pointTableContainer">
        <div class="pf-bigTitle">GP Monthly Calendar :</div>

        <table class="tableOfPoint">
            <thead>
                <tr>
                    <th>Date</th>
                    <th><?php echo$secondColumn ?></th>
                    <th>Points</th>
                </tr>
            </thead>

            <tbody>

                <?php 
                
                    if(mysqli_num_rows($pointFlow) > 0){

                        while($row = mysqli_fetch_assoc($pointFlow)){
                            $dateDay = date('m-d', strtotime($row['date']));

                            $earnOrSpent = ($showing == 'earnedPoint') ? '+' : '-';

                            echo'
                                <tr>
                                    <td>'.$dateDay.'</td>
                                    <td class="centerColumn">'.$row["category"].'</td>
                                    <td >'.$earnOrSpent.$row["quantity"].' GP</td>


                                
                                </tr>

                            
                            ';
                        }
                    }
                
                
                ?>


            </tbody>

        </table>
        

    </div>






    

</body>
</html>

<?php 
}else{
    header("Location: point.php");
    exit();
}

mysqli_close($conn)
 ?>