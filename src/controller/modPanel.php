<?php

    include_once("model/modPanel.php");

    if (!checkConnection()) {
        include_once("view/errors/notLogged.php");
        include_once("view/index.php");
    } else {

        if (!isset($_SESSION["id"]) || $_SESSION['role'] != "admin") {
            include_once("view/errors/notAdmin.php");
            include_once("view/index.php");
            exit;
        }
        if (isset($_GET['editUser']) && $_GET['editUser'] == 'changerole') {
            changeUserRole($_GET['user'], $_GET['role']);
            include_once("view/successes/changedRole.php");
        }
        if (isset($_GET['editUser']) && $_GET['editUser'] == 'delete') {
            $delusr = deleteUser($_GET['user']);
            if ($delusr == -1) {
                            include_once("view/errors/deleteUser.php");
            } else {
                            include_once("view/successes/deletedUser.php");
            }
        }
    
        $users = getAllUsers('user');
        $admins = getAllUsers('admin');
        include_once("view/modPanel.php");
    
    }

?>