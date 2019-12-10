<?php

require_once "model/selectedProject.php";
require_once "model/release.php";

$UserID = $_SESSION["id"];
if (isset($_POST["saveCommit"])) {
    $allCommits = json_decode($_POST["allCommits"]);
    save_all_commit($_POST["projectId"], $allCommits);

} elseif (isset($_POST["saveGitUrl"])) {
    var_dump($_POST["saveGitUrl"]);
    change_git_url($_POST["projectId"], $_POST["saveGitUrl"]);

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
        include_once "view/modHeader.php";
    }

    $gitUrl = get_git_url($projectId)->fetch()["release_git"];
    $commits = get_all_commit($projectId);
    $lastCommit = get_last_commit($projectId)->fetch()["commitDate"];
    if ($lastCommit != null) {
        $lastCommit = new DateTime($lastCommit);
        $tosub = new DateInterval('PT59M59S');
        $lastCommit->sub($tosub);
        $lastCommit = $lastCommit->format("Y-m-d H:i:s");
        $lastCommit = str_replace(" ", "T", $lastCommit);
    }

    include_once "view/projectNav.php";
    include_once "view/release.php";
}
