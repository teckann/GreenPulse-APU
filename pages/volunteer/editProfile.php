<?php
    include("eventBackend.php");

    include("../../conn.php");

    
    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];


    if(isset($_POST["valueToChange"])){
        $valueChanged = $_POST["valueToChange"];
        $typeChanged = $_POST["typeToChange"];

        $sql_register_event = "UPDATE users
                                SET $typeChanged = '$valueChanged'
                                WHERE user_id = '$userID';";


            if(mysqli_query($conn,$sql_register_event)){
                
            }else{
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
           
    }




    $sql_profileDetails = "SELECT * FROM users WHERE user_id = '$userID';";

    $profileDetails = mysqli_fetch_assoc(mysqli_query($conn,$sql_profileDetails));

    $userName = $profileDetails['name']; 
    $contact = $profileDetails['contact_number']; 
    $email = $profileDetails['education_email'];
    $dob = $profileDetails['date_of_birth'];
    $gender = $profileDetails['gender'];
    $course = $profileDetails['course_name'];
    $nationality = $profileDetails['nationality'];
    $avatar = $profileDetails['avatar'];


    


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

    <div class="profileHead">
    <div>
        <div><a href="profile.php" class="backEvent"><i class="fa-solid fa-arrow-left"></i></a> Edit Profile</div>
    </div>

    </div>
    <div class="editProfileContainer">

    <div class="pointBar-left" id="editProfilePic">
    
            <?php 


                echo '<img src="../../'.$avatar.'" alt="User Profile" class="profilePic">'; 

            
            ?>

        <button id="uploadPicBtn"><i class="fa-solid fa-camera" id="editPicIcon"></i></button>


    </div>

 
        <div class="profileDetailLine">
            <div class="labelProfile">Name 

            </div>
            <form action="oneProfile.php" method="post">
                <div class="inputProfile">
                    <?php

                        echo'<label>'.$userName.'</label>';
                        
                        echo'<button class="buttonProfile" type="submit" name="name" value="'.$userName.'" >
                            <i class="fa-solid fa-chevron-right wide-angle"></i>

                        </button>'
                    
                    ?>
                </div>
            </form>
        </div>

        
        <div class="profileDetailLine">
            <div class="labelProfile" >Contact Number

            </div>
            <form action="oneProfile.php" method="post">
                <div class="inputProfile">
                    <?php
                        echo'<label>'.$contact.'</label>';
                        
                        echo'<button class="buttonProfile" type="submit" name="contact" value="'.$contact.'" >
                            <i class="fa-solid fa-chevron-right wide-angle"></i>

                        </button>'
                    
                    ?>
                </div>
            </form>
        </div>

        
        <div class="profileDetailLine">
            <div class="labelProfile">Email 

            </div>
            <form action="oneProfile.php" method="post">
                <div class="inputProfile">
                    <?php
                        echo'<label for="name">'.$email.'</label>';
                        
                        echo'<button class="buttonProfile" type="submit" name="email" value="'.$email.'" >
                            <i class="fa-solid fa-chevron-right wide-angle"></i>

                        </button>'
                    
                    ?>
                </div>
            </form>
        </div>

        
        <div class="profileDetailLine">
            <div class="labelProfile">Date of Birth 

            </div>
            <form action="oneProfile.php" method="post">
                <div class="inputProfile">
                    <?php

                        echo'<label for="name">'.$dob.'</label>';
                        
                        echo'<button class="buttonProfile" type="submit" name="dob" value="'.$dob.'" >
                            <i class="fa-solid fa-chevron-right wide-angle"></i>

                        </button>'
                    
                    ?>
                </div>
            </form>
        </div>
        
        <div class="profileDetailLine">
            <div class="labelProfile">Course

            </div>
            <form action="oneProfile.php" method="post">
                <div class="inputProfile">
                    <?php

                        echo'<label for="name">'.$course.'</label>';
                        
                        echo'<button class="buttonProfile" type="submit" name="course" value="'.$course.'" >
                            <i class="fa-solid fa-chevron-right wide-angle"></i>

                        </button>'
                    
                    ?>
                </div>
            </form>
        </div>

        
        <div class="profileDetailLine">
            <div class="labelProfile" >Nationality

            </div>
            <form action="oneProfile.php" method="post">
                <div class="inputProfile">
                    <?php

                        echo'<label for="name">'.$nationality.'</label>';
                        
                        echo'<button class="buttonProfile" type="submit" name="nationality" value="'.$nationality.'" >
                            <i class="fa-solid fa-chevron-right wide-angle"></i>

                        </button>'
                    
                    ?>
                </div>
            </form>
        </div>

        
        
        

    <div>
    </div>
</div>

</body>
</html>