<?php 

function limit_words($text, $limit) {
    $words = explode(" ", $text);
    
    if (count($words) <= $limit) {
        return $text;
    }
    
    return implode(" ", array_slice($words, 0, $limit)) . '...';
}

function addModuleCard($module) {
        if(mysqli_num_rows($module) > 0){
            while($oneModule = mysqli_fetch_assoc($module)){
                echo'     
                    <div class="moduleCard">

                        <div class="studyCoverBox">
                            <img src="../../src/eventPosters/poster1.png" alt="Module Cover" class="studyCoverPage">
                        </div>

                        <div class="downStudy">
                        <p class="moduleCardTitle">'.$oneModule["module_name"].'</p>
                        <P class="moduleCardDetail">'.limit_words($oneModule["module_description"], 10).'</P>
                        </div>
                    </div>

                ';
            }
        }else{
            echo '<p class="noEvents">More module coming soon</p>';
        }
    } 
?>