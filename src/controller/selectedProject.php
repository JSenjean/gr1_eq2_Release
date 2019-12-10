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

if ($isMaster || $isMember) {
    include_once("view/projectNav.php");

    $projectMaster = get_project_master($projectId);
    $members = get_all_project_members($projectId);
    $requests = get_all_project_joining_requests($projectId);
    $invitations = get_all_project_invitations($projectId);
    $project = get_project_by_id($projectId);
    
    // Sprint progress bar
    include_once("model/sprints.php");
    $sprints = get_all_sprints($projectId)->fetchAll();
    $sDone = 0;
    $sDoing = 0;
    $sUpcomming = 0;
    foreach ($sprints as $sprint) {
        $color = add_sprint_background($sprint['start'], $sprint['end']);
        switch ($color) {
            case "bg-success":
                $sDone++;
                break;
            case "bg-danger":
                $sDoing++;
                break;
            case "bg-info":
                $sUpcomming++;
                break;
        }
    }
    $countSprint = count($sprints);

    // Test progress bar
    include_once("model/tests.php");
    $proportion = compute_proportion($projectId);
    $percPassed = $proportion[0];
    $percFailed = $proportion[1];
    $percDeprecated = $proportion[2];
    $percNeverRun = $proportion[3];

    // Doc progress bar
    include_once("model/doc.php");
    $proportion2 = compute_proportion_doc($projectId);
    $percDone = $proportion2[0];
    $percTodo = $proportion2[1];
    $percDeprecatedDoc = $proportion2[2];

    // Edit project
    if (isset($_SESSION['projectToEdit'])) {
        if ($isMaster) {
            editProject($_SESSION['projectToEdit']);
            $project = get_project_by_id($projectId);
            unset($_SESSION['projectToEdit']);
        } else {
            include_once("view/errors/noRights.php");
        }
    }

    // Accept Request
    if (isset($_SESSION['projectAcceptMember']) && isset($_SESSION['acceptedUser'])) {
        if ($isMaster) {
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
    if (isset($_SESSION['projectDeleteMember']) && isset($_SESSION['userToDelete'])) {
        if ($isMaster) {
            deleteMember($_SESSION['projectDeleteMember'], $_SESSION['userToDelete'], 'member');
            $members = get_all_project_members($projectId);
            unset($_SESSION['projectDeleteMember']);
            unset($_SESSION['userToDelete']);
        } else {
            include_once("view/errors/noRights.php");
        }
    }

    // Delete request
    if (isset($_SESSION['projectDeleteRequest']) && isset($_SESSION['userRequestToDelete'])) {
        if ($isMaster) {
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
    } else if (isset($_GET['page']) == 'sprints') {
        include_once("view/sprints.php");
    } else if (isset($_GET['page']) == 'tests') {
        include_once("view/tests.php");
    } else if (isset($_GET['page']) == 'doc') {
        include_once("view/doc.php");
    } else if (isset($_GET['page']) == 'release') {
        include_once("view/release.php");
    } else {
        include_once("view/selectedProject.php");
    }

} else {
    include_once("view/errors/notMemberOfProject.php");
    include_once("controller/projects.php");
}

?>