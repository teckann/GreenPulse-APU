<?php 

    function fillingRow($toFill1, $toFill2, $destinationFile, $type, $id){


        echo '
        
                <div class="historyAmount" id="secondaryHistoryAmount">
                <div class="labelHistory">'.$toFill1.'</div>
                <div class="amountLinkHistory" >
                    <span class="amountHistory">
                        '.$toFill2.'
                    </span>
                    <form method="post" action="'.$destinationFile.'.php">
                        <button name="'.$type.'" type="submit" value="'.$id.'">
                            <i class="fa-solid fa-chevron-right wide-angle"></i>
                        </button>
                </form>
                </div>
            
            </div>

        
        ';
    }

?>