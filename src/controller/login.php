<?php

    if (!isset($_SESSION)) {
        session_start();
    }

    include_once("model/login.php");
    login();
    
    if (isset($_SESSION['username'])) {
        $id = $_SESSION['id'];
            header('Location: index.php?action=projects');
    } else {
        include_once("view/errors/signin.php");
        include_once("view/index.php");
    }

?>