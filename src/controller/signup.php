<?php

    include_once("model/signup.php");

    $s = signup();

    if ($s == -2){
        include_once("view/errors/signup_mail.php");
        include_once("view/index.php");
    }
    else if ($s == -3){
        include_once("view/errors/signup_username.php"); 
        include_once("view/index.php");
    }
    else if ($s == -4){
        include_once("view/errors/password.php");
        include_once("view/index.php");
    }
    else { // No errors
        unset($_GET['action']);
        $_GET['id'] = $s;
        include_once("view/index.php");
       // include_once("view/verify.php"); // Can be changed to send mail with a verification link
    }

?>