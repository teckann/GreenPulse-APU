<?php

    include("../../conn.php");

    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];

    $disableOrNot = '';

    if(isset($_POST["oneTree"])){
        $tree_id = $_POST["oneTree"];


    }else if(isset($_POST["fertilize"])) {
        $tree_id = $_POST["oneTree"];


        $sql_update_fertilize = "UPDATE tree_adoption_history SET
                                    tree_adoption_datetime = NOW()
                                    WHERE user_id = '$userID'
                                    AND tree_adoption_id = '$tree_id';";
    }

    if($tree_id){
        
        $sql_my_tree = "SELECT tah.*, i.*,
                        DATEDIFF(NOW(), tah.tree_adoption_datetime) as age
                        FROM tree_adoption_history tah
                        JOIN items i ON tah.item_id = i.item_id
                        WHERE tah.user_id = '$userID'
                        AND tah.tree_adoption_id = '$tree_id';";

        $myTree = mysqli_fetch_assoc(mysqli_query($conn,$sql_my_tree));

        if($myTree['fertilization_datetime']) {
            $lastFertilized = date('d F Y', strtotime($myTree['fertilization_datetime']));

            $lastFertDate = strtotime($dateFromDB);
            $todayDate = strtotime(date("Y-m-d"));

            


        }else{
            $lastFertilized = 'Not Yet Fertilized';

            
        }




        
    }else {
        header('Location: myTree.php');
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">


    <title>Tree</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <link rel="stylesheet" href="../../styles/volunteer_2.css">
    <script src="../../scripts/volunteer.js"></script>
    <script src="../../scripts/volunteer_study.js"></script>

    <style>
        <?php echo$btnStyle ?>>
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body><?php include("header.php") ?>

    <div id="pointHead">
    <div>
        <form id="backOneModule" action="myTree.php" method="post">
        <div><button class="backPoint" id="backFromPoint" onclick="history.back()" ><i class="fa-solid fa-arrow-left"></i> Your Tree</button>  </div>
        </form>
    </div>

    </div>

    <div class="oneTreeContainer">
        <div class="otContent">
            <div class="otImageBox">
                <img src="../../<?php echo$myTree["item_image"]; ?>" alt="Tree Image" class="otImage">

            </div>

            <div class="otDetail">

            <div class="otDetailCard">
                <div class="otRow">
                    <span class="otLabel">Name :</span>
                    <span class="otText"><?php echo$myTree["given_name"]; ?></span>
                </div>
                <div class="otRow" id="otRow-Zebra">
                    <span class="otLabel">Age :</span>
                    <span class="otText"><?php echo($myTree["age"]+1); ?> </span>
                </div>
                <div class="otRow">
                    <span class="otLabel">Adopted By :</span>
                    <span class="otText"><?php echo(date('d F Y', strtotime($myTree["tree_adoption_datetime"]))); ?></span>
                </div>
                <div class="otRow" id="otRow-Zebra">
                    <span class="otLabel">Species :</span>
                    <span class="otText"><?php echo$myTree["item_name"]; ?></span>
                </div>
            </div>

            <div class="otFertiCard">
                <h3 class="fertTitle">Last Fertilized :</h3>
                <p class="otFertiDate"><?php echo $lastFertilized; ?></p>

            </div>

            </div>

        </div>

    </div>


    
</body>
</html>

<?php 


mysqli_close($conn)
?>