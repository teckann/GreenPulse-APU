<?php
    include("../conn.php");
    include("sessionData.php");
    include("utility.php");

    // record action into log
    // addLog($conn, $userID, "Successful Logout");
    
    // remove the session
    session_unset();

    // close the session
    session_destroy();

    // pop-up message
    echo "<script>
            alert('Successful Logout');
            window.location.href = '../pages/guest/login.php';
          </script>";
?>