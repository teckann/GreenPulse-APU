<?php

    include("../../conn.php");

    
    include("../../backend/sessionData.php");

    $type = 'text';

    $userID = $_SESSION["userID"];

    switch (true) {
        case isset($_POST['name']):
            $original = ($_POST['name']);
            $header = ' Name';
            $formName = 'name';
            
            
            break;
        case isset($_POST['contact']):
            $original = ($_POST['contact']);
            $header = ' Contact Number';
            $formName = 'contact_number';
            break;
        case isset($_POST['email']):
            $original = ($_POST['email']);
            $header = 'Email';
            $formName = 'education_email';

            $type = ' email';
            break;
        case isset($_POST['dob']):
            $original = ($_POST['dob']);
            $header = ' Date Of Birth';
            $formName = 'date_of_birth';
            break;
        case isset($_POST['course']):
            $original = ($_POST['course']);
            $header = ' Course';
            $formName = 'course_name';

            $type = 'course';
            break;
        case isset($_POST['nationality']):
            $original = ($_POST['nationality']);
            $header = ' Nationality';
            $formName = 'nationality';

            $type = 'nationality';
            break;
        default:
            header("Location: profile.php");
            break;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">


    <title>Profile</title>
    <link rel="stylesheet" href="../../styles/volunteer.css">
    <script src="../../scripts/volunteer.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .navBar #profileNav {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
        }

        .navBar #profileNav span {
            color: #000000;
            
            background-color: #ffffff3c; 
            
            border-radius: 0 0 22px 22px; 
            
        }

        .navBar #profileNav:hover {
            background: radial-gradient(circle at top, transparent 30%, #c6ff00 180%);
            border-radius: 0;
            transform: translateY(0px);

        }

        .navBar .profileNav:hover span {
            color: #000000; 
        }

    </style>
</head>
<body>
    <?php include("header.php") ?>

    <div class="profileHead" id="oneProfileHead">

        <div><a href="editProfile.php" class="backEvent"><i class="fa-solid fa-arrow-left"></i> Cancel </a> </div>

        

    </div>
    

<div class="editProfileContainer">

    <div class="historyHeader" id="firstHistoryHeader">
        <h2>
            <?php
            echo$header;
            ?>
        </h2>
    </div>

    <form action="editProfile.php" method="post">
        <div id="inputChangeProfile">
            
                <?php

                if($type == 'nationality'){
                    include("../general/nationality.php");
                }else if($type == 'course'){
                    include("../general/course.php");
                }else{
                    echo'<input autofocus autocomplete="off" id="detailToChange" name="valueToChange" type="'.$type.'" value="'.$original.'">';
                    echo'<input type="hidden" name="typeToChange" value="'.$formName.'">';                
                }


                ?>
        </div>
        <div id="doneBtnContainer">
            <button id="doneButton" type="submit">Done</button>
        </div>
        
    </form>



</div>

</body>
</html>

<?php 

mysqli_close($conn); ?>