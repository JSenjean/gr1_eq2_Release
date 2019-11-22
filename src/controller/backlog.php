<?php

require_once "model/selectedProject.php";
require_once "model/backlog.php";
require_once "model/sprints.php";
$UserID = $_SESSION["id"];
if (isset($_POST["projectIdToModifyRole"])) {
    $projectIdToModify=$_POST["projectIdToModifyRole"];
    if (isset($_POST["modify"])) {
        $roleName= $_POST["roleName"];
        $roleDescription=$_POST["roleDescription"];
        if ($_POST["modify"]=="true") {
            echo modify_inside_project_role(
                $_POST["roleId"],
                $roleName,
                $roleDescription
            );
        } else {
            echo add_inside_project_role(
                $projectIdToModify,
                $roleName,
                $roleDescription
            );
        }
    } elseif (isset($_POST["removeRole"])) {
        echo remove_by_role_id($_POST["roleId"]);
    }
} elseif (isset($_POST["projectIdToModifyUS"])) {
    $projectIdToModify=$_POST["projectIdToModifyUS"];
    if (isset($_POST["allRole"])) {
        echo json_encode(
            get_all_inside_project_role($projectIdToModify)->fetchAll()
        );
    } elseif (isset($_POST["modify"])) {
        $name=$_POST["name"];
        $roleId=$_POST["roleId"];
        if (intval($roleId)=="0") {
            $roleId=null;
        }
        $done=($_POST["done"]=="true") ? 1 : 0;
        $iCan=$_POST["iCan"];
        $soThat=$_POST["soThat"];
        $difficulty=$_POST["difficulty"];
        $difficulty;
        $workValue=$_POST["workValue"];

        if ($_POST["modify"]=="true") {
            echo modify_inside_project_US(
                $_POST["usId"], 
                $projectIdToModify, 
                $name, 
                $roleId, 
                $iCan, 
                $soThat, 
                $difficulty, 
                $workValue, 
                $done
            );
        } else {
            echo add_inside_project_US(
                $projectIdToModify, 
                $name, 
                $roleId, 
                $iCan, 
                $soThat, 
                $difficulty, 
                $workValue, 
                $done
            );
        }
    } elseif (isset($_POST["removeUSId"])) {
        echo remove_US_by_id($_POST["removeUSId"]);
    }
} else {
    $projectId = $_GET["projectId"];
    $isMaster = is_master($UserID, $projectId);
    $isMember = is_member($UserID, $projectId);
    if (!$isMaster && !$isMember) {
        header('Location: index.php?action=projects');
    }


    if ($_SESSION['role'] == 'user') {
        include_once "view/memberHeader.php";
    } else {
        include_once "view/modHeader.php" ;
    }

    $roles = get_all_inside_project_role($projectId)->fetchAll();
    $rolesID=array();
    foreach ($roles as $role) {
        $rolesID+= array("".$role['id']."" => "".$role['name']."");
    }

    $userStories = get_all_US_by_project_id($projectId)->fetchAll();

    include_once "view/projectNav.php";
    include_once "view/backlog.php";
    include_once "view/validate/addRoleToProject.php";
    include_once "view/validate/addUserStoryToProject.php";
}
