<?php

include_once("model/selectedProject.php");

if ($_SESSION['role'] == 'user') {
    include_once("view/memberHeader.php");
} else {
    include_once("view/modHeader.php");
}

    
$projectId = $_GET['projectId'];
$isMaster = is_master($_SESSION["id"], $projectId);
$isMember = is_member($_SESSION["id"], $projectId);

if ($isMaster || $isMember){

    include_once("view/projectNav.php");

    $projectMaster = get_project_master($projectId);
    $members = get_all_project_members($projectId);
    $requests = get_all_project_joining_requests($projectId);
    $invitations = get_all_project_invitations($projectId);
    $project = get_project_by_id($projectId);
    
    // Edit project
    if (isset($_SESSION['projectToEdit'])){
        if ($isMaster){
            editProject($_SESSION['projectToEdit']);
            $project = get_project_by_id($projectId);
            unset($_SESSION['projectToEdit']);
        } else {
            include_once("view/errors/noRights.php");
        }
    }

    // Accept Request
    if (isset($_SESSION['projectAcceptMember']) && isset($_SESSION['acceptedUser'])){
        if ($isMaster){
            acceptRequest($_SESSION['projectAcceptMember'], $_SESSION['acceptedUser'], 'member');
            $members = get_all_project_members($projectId);
            $requests = get_all_project_joining_requests($projectId);
            unset($_SESSION['projectAcceptMember']);
            unset($_SESSION['acceptedUser']);
        } else {
            include_once("view/errors/noRights.php");
        }
    }

    // Delete member
    if (isset($_SESSION['projectDeleteMember']) && isset($_SESSION['userToDelete'])){
        if ($isMaster){
            deleteMember($_SESSION['projectDeleteMember'], $_SESSION['userToDelete'], 'member');
            $members = get_all_project_members($projectId);
            unset($_SESSION['projectDeleteMember']);
            unset($_SESSION['userToDelete']);
        } else {
            include_once("view/errors/noRights.php");
        }
    }

    // Delete request
    if (isset($_SESSION['projectDeleteRequest']) && isset($_SESSION['userRequestToDelete'])){
        if ($isMaster){
            deleteInvitationOrRequest($_SESSION['projectDeleteRequest'], $_SESSION['userRequestToDelete']);
            $invitations = get_all_project_invitations($projectId);
            unset($_SESSION['projectDeleteRequest']);
            unset($_SESSION['userRequestToDelete']);
        } else {
            include_once("view/errors/noRights.php");
        }
    }
    
    if (isset($_GET['page']) == 'backlog') {    
        include_once("view/backlog.php");
    }else if(isset($_GET['page']) == 'sprints') {
        include_once("view/sprints.php");
    }else if(isset($_GET['page']) == 'tests') {
        include_once("view/tests.php");
    }else if(isset($_GET['page']) == 'doc') {
        include_once("view/doc.php");
    }else if(isset($_GET['page']) == 'release') {
        include_once("view/release.php");
    }else {
        include_once("view/selectedProject.php");
    }

} else {
    include_once("view/errors/notMemberOfProject.php");
    include_once("controller/projects.php");
}

?>