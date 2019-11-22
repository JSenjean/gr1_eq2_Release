<?php

require_once "model/profile.php";
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];

if (isset($_POST['cancelRequestOrInvitation'])) {
    echo CancelRequest($_POST["projectId"], $user_id);
} elseif (isset($_POST['acceptInvitation'])) {
    echo AcceptInvitaion($_POST["projectId"], $user_id);
} elseif (!checkConnection()) {
    include_once "view/errors/notLogged.php";
    include_once "view/index.php";
} else {
    if (isset($_GET['editInfo'])) {
        $result = editInfo($_SESSION["username"]);
        if ($result == -3) {
            include_once "view/errors/alreadyUsedId.php";
        } elseif ($result == -2) {
            include_once "view/errors/alreadyUsedMail.php";
        } elseif ($result == -1) {
            include_once "view/errors/notLogged.php";
        } else {
            include_once "view/successes/editedProfile.php";
        }
    }

    if (!isset($_SESSION['id'])) {
        include_once "view/errors/notLogged.php";
        include_once "view/index.php";
        return;
    } else {
        if ($_GET["action"] == "deleteAccount") {
            if ($_SESSION['role'] == 'user') {
                include_once "view/memberHeader.php";
            } else {
                include_once "view/modHeader.php";
            }
            include_once "view/confirmDeleteUser.php";
        } elseif ($_GET["action"] == "deleteAccountConfirmed") {
            deleteAccount($username);
            include_once "controller/logout.php";
        } else {
            $id = $_SESSION['id'];
            if ($_SESSION['role'] == 'user') {
                include_once "view/memberHeader.php";
            } else {
                include_once "view/modHeader.php";
            }
            $infoUser = getUserProfile($username);
            $userNumberOfProject = getUserNbParticipation($user_id);
            $userInvitations = getUserInvitationsOrRequest(0, $user_id);
            $userRequests = getUserInvitationsOrRequest(1, $user_id);
            include_once "view/profile.php";
        }
    }
}
