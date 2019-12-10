<?php
include_once("model/utility.php");
if (isset($_POST["projectIdToAdd"]))
{
    $users = get_all_user_not_in_project(4)->fetchAll();
    $jsonUsers = json_encode($users);
    echo $jsonUsers;
} elseif (isset($_POST["usersToAdd"]))
{
    $usersToInvite = $_POST["usersToAdd"];
    $projectId = $_POST["projectId"];
    foreach ($usersToInvite as $user)
    {
    add_invitation_by_user_name($user, $projectId);
    }
}

?>