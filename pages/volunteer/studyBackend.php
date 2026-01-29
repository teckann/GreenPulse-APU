<?php 



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
?>