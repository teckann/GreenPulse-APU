<?php
    // register session data
    $_SESSION["email"] = null;
    $_SESSION["nationality"] = null;
    $_SESSION["name"] = null;
    $_SESSION["DOB"] = null;
    $_SESSION["gender"] = null;
    $_SESSION["course"] = null;
    $_SESSION["contactNumber"] = null;
    $_SESSION["password1"] = null;
    $_SESSION["password2"] = null;
    $_SESSION["hash_password"] = null;
    $_SESSION["newUserID"] = null;


    unset($_SESSION["email"]);
    unset($_SESSION["nationality"]);
    unset($_SESSION["name"]);
    unset($_SESSION["DOB"]);
    unset($_SESSION["gender"]);
    unset($_SESSION["course"]);
    unset($_SESSION["contactNumber"]);
    unset($_SESSION["password1"]);
    unset($_SESSION["password2"]);
    unset($_SESSION["hash_password"]);
    unset($_SESSION["newUserID"]);

    // forget password session
    $_SESSION["userIdInput"] = null;
    $_SESSION["safetyQuestion1"] = null;
    $_SESSION["safetyQuestion2"] = null;
    $_SESSION["answer1"] = null;
    $_SESSION["answer2"]= null;
    $_SESSION["oldPassword"] = null;
    $_SESSION["answerInput1"] = null;
    $_SESSION["answerInput2"]= null;
    $_SESSION['hash_password'] = null;

    unset($_SESSION["userIdInput"]);
    unset($_SESSION["safetyQuestion1"]);
    unset($_SESSION["safetyQuestion2"]);
    unset($_SESSION["answer1"]);
    unset($_SESSION["answer2"]);
    unset($_SESSION["oldPassword"]);
    unset($_SESSION["answerInput1"]);
    unset($_SESSION["answerInput2"]);
    unset($_SESSION['hash_password']);
?>