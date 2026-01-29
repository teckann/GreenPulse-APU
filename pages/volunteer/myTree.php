<?php
    include("../../conn.php");

    
    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];


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
<body>
    <?php include("header.php") ?>

    <div class="eventHead" id="availableEventHead">
    <div>
        <div><a href="profile.php" class="backEvent"><i class="fa-solid fa-arrow-left"></i></a> My Tree</div>
    </div>

    
    <div class="searchBar" id="availableSearchBar">

            <input autocomplete="off" id="searchEvent" class="searchArea" type="text" name="search" placeholder="Search...">
            <button class="searchButton" id="searchEventBtn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>

    </div>

    </div>

    <div class="myTreeContainer">

        <?php 
        
            $sql_my_tree = "SELECT tah.*, items.*
                            FROM tree_adoption_history tah
                            JOIN items ON tah.item_id = items.item_id
                            WHERE tah.user_id = '$userID';";

            $myTree = mysqli_query($conn,$sql_my_tree);

            if(mysqli_num_rows($myTree) > 0){
                while($oneTree = mysqli_fetch_assoc($myTree)){
            
        ?>


        <div class="mtCard">
            <div class="mtImageBox">
                <img src="../../<?php echo$oneTree["item_image"]; ?>" alt="tree" class="mtImage">
            </div>
            
            <div class="mtDetail">
                <div class="mtName"><?php echo$oneTree["given_name"]; ?></div>
                <div class="mtFertilize">
                    Last Fertilized: <span class="mtFertiDate"><?php echo(date('d F Y', strtotime($oneTree["fertilization_datetime"]))); ?></span>
                </div>
                <form action="oneTree.php" method="post">
                    <button class="mtBtn" name="oneTree" value="<?php echo$oneTree["tree_adoption_id"]; ?>">View <?php echo$oneTree["given_name"]; ?></button>
                </form>
                
            </div>

        </div>

        <?php }} ?>



    </div>

    

</body>
</html>