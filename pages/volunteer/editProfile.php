<?php
    include("eventBackend.php");

    include("../../conn.php");
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

    <div class="profileHead">
    <div>
        <div><a href="profile.php" class="backEvent"><i class="fa-solid fa-arrow-left"></i></a> Edit Profile</div>
    </div>

    </div>

    <div class="pointBar-left" id="editProfilePic">
    

        <img src="../../src/avatars/U004_avatar.jpg" alt="User Profile" class="profilePic" id="imgEditProfile">


        <button id="uploadPicBtn"><i class="fa-solid fa-camera" id="editPicIcon"></i></button>


    </div>

    <div id="profileDetailContainer">

    <table id="profileTable">
        <tr class="profileDetailLine">
            <td class="labelProfile">Name:</td>
            <td class="inputProfile" ><input type="text" value="Jimmy" name="name"></td>
            <td class="buttonProfile" ><button><i class="fa-solid fa-chevron-right wide-angle"></button></td>

        </tr>
        <tr class="profileDetailLine">
            <td class="labelProfile">Name:</td>
            <td class="inputProfile" ><input type="text" value="Jimmy" name="name"></td>
            <td class="buttonProfile"><button><i class="fa-solid fa-chevron-right wide-angle"></button></td>
        </tr>
        <tr class="profileDetailLine">
            <td class="labelProfile">Name:</td>
            <td class="inputProfile" ><input type="text" value="Jimmy" name="name"></td>
            <td class="buttonProfile"><button><i class="fa-solid fa-pen-to-square"></i></button></td>
        </tr>
        <tr class="profileDetailLine">
            <td class="labelProfile">Name:</td>
            <td class="inputProfile" ><input type="text" value="Jimmy" name="name"></td>
            <td class="buttonProfile"><button><i class="fa-solid fa-pen-to-square"></i></button></td>
        </tr>
        <tr class="profileDetailLine">
            <td class="labelProfile">Name:</td>
            <td class="inputProfile" ><input type="text" value="Jimmy" name="name"></td>
            <td class="buttonProfile"><button><i class="fa-solid fa-pen-to-square"></i></button></td>
        </tr>
        <tr class="profileDetailLine">
            <td class="labelProfile">Name:</td>
            <td class="inputProfile" ><input type="text" value="Jimmy" name="name"></td>
            <td class="buttonProfile"><button><i class="fa-solid fa-pen-to-square"></i></button></td>
        </tr>
        <tr class="profileDetailLine" id="lastLineProfile">
            <td class="labelProfile">Name:</td>
            <td class="inputProfile" ><input type="text" value="Jimmy" name="name"></td>
            <td class="buttonProfile"><button><i class="fa-solid fa-pen-to-square"></i></button></td>
        </tr>



    </table>
    </div>

</body>
</html>