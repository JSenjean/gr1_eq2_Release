<?php

require_once "model/projects.php";

if (isset($_POST['askForInvitation'])) {
    echo add_invitation_request($_POST["requesterUserId"], $_POST["projectId"]);
} else {
    include_once "model/projects.php";
    if (isset($_SESSION['username'])) {
        $id = $_SESSION['id'];
        if ($_SESSION['role'] == 'user') {
            include_once "view/memberHeader.php";
        } else {
            include_once "view/modHeader.php";
        }
    } else {
        header('Location: index.php?action=login');
    }

    if (isset($_SESSION['projectToDelete'])) {
        if (remove_by_project_id($_SESSION['projectToDelete']) == 1) {
            unset($_SESSION['projectToDelete']);
            include_once "view/successes/deletedProject.php";
        } else {
            unset($_SESSION['projectToDelete']);
            include_once "view/errors/deletedProject.php";
        }
    }

    if (isset($_SESSION['projectToLeave'])) {
        if (leave_a_project($id, ($_SESSION['projectToLeave'])) == 1) {
            unset($_SESSION['projectToLeave']);
            include_once "view/successes/projectLeft.php";
        } else {
            unset($_SESSION['projectToLeave']);
            include_once "view/errors/deletedProject.php";
        }
    }

    if (isset($_POST['projectName']) && isset($_POST['projectDescription'])) {
        $visibility;
        if (isset($_POST['visibility'])) {
            $visibility = 1;
        } else {
            $visibility = 0;
        }

        create_new_project($id, $_POST['projectName'], $_POST['projectDescription'], $visibility);
    }

    $projects = get_all_project_by_user_id($id);
    $otherProjects = get_all_project_without_user_id($id);
    //$users=get_all_user_not_in_project(4)->fetchAll();
    //$jsonUsers=json_encode($users);
    //print_r($projects);
    include_once "view/projects.php";
    include_once "view/validate/deleteProject.php";
    include_once "view/validate/newProject.php";
    include_once "view/validate/inviteToProject.php";
    
   
}
