<?php

    include("../../conn.php");

    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];

    if(isset($_POST["feedBack"])){
        $event_id = $_POST["feedBack"];
    


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
<body><?php include("header.php") ?>

    <div class="profileHead">
        <div>
            <form action="event.php">
            <button class="backEvent" id="oneEventBack">
                <i class="fa-solid fa-arrow-left"></i>
            </button> 
            </form>
        </div>
    </div>

    <form action="oneEvent.php" method="post">

    <div class="feedBackDescriptionBox">
        <h3 class="descLabel">Feedback Form</h3>
        <p class="descText">
            Your FeedBack Really Help Us
        </p>
    </div>

    <div class="feedBackDescriptionBox">
        <h3 class="descLabel">Anything for This event</h3>
        <p class="descText">
            <textarea name="feedBackText" placeholder="Anything for us" required></textarea>
        </p>
    </div>


    <button class="registerBtn" type="submit" name="oneEvent" value="<?php echo$event_id ?>">
        Feedback Form
    </button>

    </form>
</body>
</html>

<?php 
    }else{
        header('Location: event.php');
    }
mysqli_close($conn); ?>