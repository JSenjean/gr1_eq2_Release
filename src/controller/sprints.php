<?php
include_once("model/selectedProject.php");
include_once("model/sprints.php");


if (isset($_POST['delete']) && isset($_POST['sprintToDeleteId'])) {
    echo delete_sprint_by_id($_POST['sprintToDeleteId']);
} elseif (isset($_POST['modifyTask'])) {
    $memberId = $_POST["taskMember"];
    if ($memberId == 0) {
        $memberId = null;
    }
    if ($_POST['modifyTask'] == "true") {
        echo update_task($_POST['taskId'], $_POST['newTaskName'], $_POST['taskDescription'], $_POST['taskDod'], $_POST['taskPredecessor'], $_POST['taskTime'], $memberId);
    }
    else {
        echo create_new_task($_POST['newTaskName'], $_POST['taskDescription'], $_POST['taskDod'], $_POST['taskPredecessor'], $_POST['taskTime'], $_POST['sprintId'], $memberId);
    }
} elseif (isset($_POST['getTask'])) {
    echo json_encode(get_all_task_inside_sprint($_POST['sprintId'])->fetchAll());
} elseif (isset($_POST['getUS'])) {
    echo json_encode(get_all_us_inside_sprint($_POST['sprintId'])->fetchAll());
} elseif (isset($_POST['switchState'])) {
    echo switch_task_state($_POST['taskToSwitch'],$_POST['switchState']);
}elseif(isset($_POST['removeTaskId'])){
    echo remove_task($_POST["removeTaskId"]);
}else {
    if (isset($_POST['sprintName']) && isset($_POST['startDate']) && isset($_POST['endDate'])) {
        create_new_sprint($_POST['sprintName'], $_POST['startDate'], $_POST['endDate'], $_POST['projectID']);
        $projectId = $_POST['projectID'];
    } else {
        $projectId = $_GET['projectId'];
    }
    include_once("view/projectNav.php");
    $UserID = $_SESSION["id"];
    $sprints = get_all_sprints($projectId)->fetchAll();
    $projectMembers = get_all_project_members_and_master($projectId)->fetchAll();
    if ($_SESSION['role'] == 'user') {
        include_once("view/memberHeader.php");
    } else {
        include_once("view/modHeader.php");
    }
    include_once("view/sprints.php");
    include_once("view/validate/addSprintToProject.php");
    include_once("view/validate/addTaskToSprint.php");
}
