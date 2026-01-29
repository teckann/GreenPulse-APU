<?php 

    include("../../conn.php");

    
    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];

    function printPointFlowContent($conn, $userID, $selectedMonth, $showing){
        
    
        $amount1 = 0;
        $amount2 = 0;
        $percent1 = 0;
        $percent2 = 0;

        if($showing == 'earnedPoint'){
        
        $totalLabel = 'Total Earned in '. date('F Y', strtotime($selectedMonth)) .' :';
        $overviewTitle = "Revenue Overview :";

        $ovvBox1 = "From Event :";
        $ovvBox2 = "From Quiz :";

        $totalText = "You discovered the secret of wealth!";

        $sql_event_earn = "SELECT SUM(e.points_given) AS total_earn
                            FROM attendance a JOIN events e
                            ON a.event_id = e.event_id
                            WHERE a.user_id = '$userID'
                            AND a.attendance_status = 'Present'
                            AND DATE_FORMAT(e.event_datetime, '%Y-%m') = '$selectedMonth'";

        $amount1 = mysqli_fetch_assoc(mysqli_query($conn, $sql_event_earn))['total_earn'];

        if(!$amount1){
            $amount1 = 0;
        }

        $sql_quiz_earn = "SELECT SUM(awarded_points) AS total_earn
                            FROM module_history
                            WHERE user_id = '$userID'
                            AND DATE_FORMAT(finish_datetime, '%Y-%m') = '$selectedMonth'";

        $amount2 = mysqli_fetch_assoc(mysqli_query($conn, $sql_quiz_earn))['total_earn'];

        if(!$amount2){
            $amount2 = 0;
        }

        $totalEarnOrSpent = $amount1 + $amount2;

        if($amount1 > $amount2) {

            $ovvText = "The top source of points income for this month was event rewards.";

        }else if ($amount2 > $amount1) {

            $ovvText = "The top source of points income for this month was quiz rewards.";

        }else if($totalEarnOrSpent == 0){
            $ovvText = "Oh o";
            $totalText = "Oh o!";
        }else {

            $ovvText = "You earned equally from Events and Quiz.";
        }

        }else if($showing == 'spentPoint'){

        $totalLabel = 'Total Spent in '. date('F Y', strtotime($selectedMonth)) .' :';
        $overviewTitle = "Expense Overview :";

        $ovvBox1 = "For Merchandise :";
        $ovvBox2 = "For Tree :";

        $totalText = "Every point spent brings new value!";



        $sql_merchandise_spent = "SELECT SUM(mph.amount * i.item_redeem_points) AS total_spent
                                    FROM merchandise_purchase_history mph JOIN items i
                                    ON mph.item_id = i.item_id
                                    WHERE mph.user_id = '$userID'
                                    AND DATE_FORMAT(mph.merchandise_purchase_datetime, '%Y-%m') = '$selectedMonth'";

        $amount1 = mysqli_fetch_assoc(mysqli_query($conn, $sql_merchandise_spent))['total_spent'];

        if(!$amount1){
            $amount1 = 0;
        }

        $sql_tree_spent= "SELECT SUM(i.item_redeem_points) AS total_spent
                            FROM tree_adoption_history tah JOIN items i
                            ON tah.item_id = i.item_id
                            WHERE tah.user_id = '$userID'
                            AND DATE_FORMAT(tah.tree_adoption_datetime, '%Y-%m') = '$selectedMonth'";

        $amount2 = mysqli_fetch_assoc(mysqli_query($conn, $sql_tree_spent))['total_spent'];

        if(!$amount2){
            $amount2 = 0;
        }

        $totalEarnOrSpent = $amount1 + $amount2;

        if($amount1 > $amount2) {

            $ovvText = "You spent most of your points on Merchandise this month.";

        }else if ($amount2 > $amount1) {

            $ovvText = "You spent most of your points on Merchandise this month.";

        }else if($totalEarnOrSpent == 0){
            $ovvText = "Wow";
            $totalText = "Wow!";
        }else {

            $ovvText = "Your spending was balanced between Merchandise and Trees.";
        }

        }

        if($totalEarnOrSpent == 0){
            $totalToCount = 1;
        }else {
            $totalToCount = $totalEarnOrSpent;
        }
        $percent1 = ($amount1 / $totalToCount) * 100;
        $percent2 = ($amount2 / $totalToCount) * 100;

    

?>

<div class="pf-up">
            <div class="pf-bigTitle"> GP Monthly Calender : </div>

            <div class="pf-totalCard">
                <div class="total-label"><?php echo $totalLabel; ?></div>
                    <div class="total-amount">
                        <i class="fa-solid fa-coins"></i>
                        <?php echo $totalEarnOrSpent; ?> GP
                    </div>
                    <p class="total-text"><?php echo $totalText; ?></p>

                

            </div>

        </div>

        <div class="pf-down">
            <div class="overview-title"><?php echo $overviewTitle; ?></div>

            <div class="overview-cards">
                <div class="ovv-box">
                    <div class="ovv-label"><?php echo $ovvBox1; ?></div>
                    <div class="ovv-amount"><?php echo $amount1; ?> GP</div>
                    <div class="ovv-progress">
                        <div class="ovv-fill" style="width: <?php echo $percent1; ?>%;"></div>
                    </div>
                </div>
                <div class="ovv-box">
                    <div class="ovv-label"><?php echo $ovvBox2; ?></div>
                    <div class="ovv-amount"><?php echo $amount2; ?> GP</div>
                    <div class="ovv-progress">
                        <div class="ovv-fill" style="width: <?php echo $percent2; ?>%;"></div>
                    </div>
                </div>
            </div>

            <p class="ovv-text">
                <?php echo $ovvText; ?>
            </p>

            <button class="pf-btn" type="submit" name="showingPF" value="<?php echo $showing; ?>" >
                View Details <i class="fa-solid fa-arrow-right"></i>
            </button>


        </div>

<?php } 
        
if (isset($_GET['jsSelectedMonth']) && isset($_GET['showing'])) {
    
    $month = $_GET['jsSelectedMonth'];
    $showingPf = $_GET['showing'];

    printPointFlowContent($conn, $userID, $month, $showingPf);


    exit();
}
        
        
?>