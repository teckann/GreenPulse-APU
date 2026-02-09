<?php 

    include("../../conn.php");

    
    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];

function addModuleCard($module) {
        if(mysqli_num_rows($module) > 0){
            while($oneModule = mysqli_fetch_assoc($module)){
                echo'     
                    <form class="oneModuleEnterForm" action="oneModule.php" method="post">
                    <div class="moduleCard">
                        <input type="hidden" name="oneModule" value="'.$oneModule["module_id"].'">

                        <div class="studyCoverBox">
                            <img src="../../'.$oneModule["module_cover"].'" alt="Module Cover" class="studyCoverPage">
                        </div>

                        <div class="downStudy">
                        <p class="moduleCardTitle">'.$oneModule["module_name"].'</p>
                        <P class="moduleCardDetail">'.$oneModule["module_description"].'</P>
                        </div>
                    </div>
                    </form>
                ';
            }
        }else{
            echo '<p class="noEvents">More module coming soon</p>';
        }
    } 



    if(isset($_GET["searchAvailable"])){

        $toSearch = $_GET["searchAvailable"];


        $sql_searchAvailable = "SELECT * FROM modules 
                            WHERE module_status = 'Active'
                            AND module_name LIKE '%$toSearch%';";
        

        $findAvailable = mysqli_query($conn,$sql_searchAvailable);

        addModuleCard($findAvailable);

        mysqli_close($conn);

    }elseif (isset($_GET["searchCompleted"])){

        $toSearch = $_GET["searchCompleted"];

        $sql_searchCompleted = "SELECT * FROM modules 
                                WHERE module_id IN (
                                    SELECT module_id 
                                    FROM module_history 
                                    WHERE user_id = '$userID'
                                ) 
                                AND module_status = 'Active'
                                AND module_name LIKE '%$toSearch%';";
            

        $findCompleted = mysqli_query($conn,$sql_searchCompleted);

        addModuleCard($findCompleted);

        mysqli_close($conn);

    }








?>