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
    $modify = $_POST['modifyTask'];
    if ($modify == "true") {
        $taskId = $_POST['taskId'];
    } else {
        $taskId = create_new_task($_POST['newTaskName'], $_POST['taskDescription'], $_POST['taskDod'], $_POST['taskPredecessor'], $_POST['taskTime'], $_POST['sprintId'], $memberId);
    }
    if (isset($_POST['usToUnlinkTask'])) {
        $usToUnlinkTask = $_POST['usToUnlinkTask'];
        if (count($usToUnlinkTask) != 0) {
            unlink_us_from_task($taskId, $usToUnlinkTask);
        }
    }
    if (isset($_POST['usToLinkTask'])) {
        $usToLinkTask = $_POST['usToLinkTask'];
        if (count($usToLinkTask) != 0) {
            link_us_to_task($taskId, $usToLinkTask);
        }
    }
    if ($modify == "true") {
        echo update_task($taskId, $_POST['newTaskName'], $_POST['taskDescription'], $_POST['taskDod'], $_POST['taskPredecessor'], $_POST['taskTime'], $memberId);
    } elseif (isset($_POST['taskType'])) {
        $taskType = $_POST['taskType'];
        if ($taskType == "test") {
            include_once("model/tests.php");
            add_new_test($_POST['projectId'], $_POST['newTaskName'], $_POST['taskDescription'], "never_run");
        } elseif ($taskType == "doc") {
            include_once("model/doc.php");
            add_new_doc($_POST['projectId'], $_POST['newTaskName'], $_POST['taskDescription'], "todo");
        }
        echo 1;
    }
} elseif (isset($_POST['getTask'])) {
    echo json_encode(get_all_task_inside_sprint($_POST['sprintId'])->fetchAll());
} elseif (isset($_POST['getUS'])) {
    echo json_encode(get_all_us_inside_sprint($_POST['sprintId'])->fetchAll());
} elseif (isset($_POST['getAllUS'])) {
    echo json_encode(get_all_us_inside_project($_POST['projectId'])->fetchAll());
} elseif (isset($_POST['linkedUSToTask'])) {
    echo json_encode(get_all_us_inside_task($_POST['taskId'])->fetchAll());
} elseif (isset($_POST['linkedUS'])) {
    echo json_encode(get_all_us_inside_sprint($_POST['sprintId'])->fetchAll());
} elseif (isset($_POST['linkUsToSprint'])) {
    $usToUnlink = $_POST['USToUnlink'];
    $usToLink = $_POST['USToLink'];
    $sprintId = $_POST['sprintId'];
    if (count($usToUnlink) != 0) {
        unlink_us_from_sprint($sprintId, $usToUnlink);
    }
    if (count($usToLink) != 0) {
        link_us_to_sprint($sprintId, $usToLink);
    }
} elseif (isset($_POST['switchState'])) {
    echo switch_task_state($_POST['taskToSwitch'], $_POST['switchState']);
} elseif (isset($_POST['removeTaskId'])) {
    echo remove_task($_POST["removeTaskId"]);
} else {
    if (isset($_POST['sprintName']) && isset($_POST['startDate']) && isset($_POST['endDate'])) {
        create_new_sprint($_POST['sprintName'], $_POST['startDate'], $_POST['endDate'], $_POST['projectID']);
        $projectId = $_POST['projectID'];
    } else {
        $projectId = $_GET['projectId'];
    }
    include_once("view/projectNav.php");
    $UserID = $_SESSION["id"];
    $sprints = get_all_sprints($projectId)->fetchAll();
    $counter = 0;
    foreach ($sprints as $item) {
        $currentTaskState = count_nb_task_by_state_in_sprint($item['id']);
        $sprints[$counter] += array("" . "todo" . "" => "" . $currentTaskState[0] . "");
        $sprints[$counter] += array("" . "onGoing" . "" => "" . $currentTaskState[1] . "");
        $sprints[$counter] += array("" . "done" . "" => "" . $currentTaskState[2] . "");
        $counter++;
    }
    $projectMembers = get_all_project_members_and_master($projectId)->fetchAll();
    if ($_SESSION['role'] == 'user') {
        include_once("view/memberHeader.php");
    } else {
        include_once("view/modHeader.php");
    }
    include_once("view/sprints.php");
    include_once("view/validate/linkUSToSprint.php");
    include_once("view/validate/addSprintToProject.php");
    include_once("view/validate/addTaskToSprint.php");
}
