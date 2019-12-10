<?php


    include_once("model/selectedProject.php");
    include_once("model/doc.php");

    $userId = $_SESSION["id"];

    if (isset($_POST['manageDoc'])) {
        $command = $_POST['manageDoc'];
        if ($command == 'add') {
            echo add_new_doc(
                $_POST["projectId"],
                $_POST["name"],
                $_POST["description"],
                $_POST["state"]
            );
        } else if ($command == 'doneAll') {
            echo all_doc_done($_POST["projectId"]);
        } else if ($command == 'edit') {
            echo edit_doc(
                $_POST["id"],
                $_POST["name"],
                $_POST["description"],
                $_POST["state"]
            );
        } else if ($command == 'delete') {
            echo delete_doc($_POST["id"], $_POST["state"]);
        } else if ($command == 'done') {
            echo change_state_doc($_POST["id"], 'done');
        } else if ($command == 'deprecated') {
            echo change_state_doc($_POST["id"], 'deprecated');
        } else if ($command == 'todo') {
            echo change_state_doc($_POST["id"], 'todo');
        }

    } else if (isset($_POST['divToRefresh'])) {
        switch ($_POST['divToRefresh']) {
            case 'todo':
                $docTodo = get_all_todo_doc($_POST["projectId"]);
                include_once("view/doc/todoDoc.php");
                break;
            case 'done':
                $docDone = get_all_done_doc($_POST["projectId"]);
                include_once("view/doc/doneDoc.php");
                break;
            case 'deprecated':
                $docDeprecated = get_all_deprecated_doc($_POST["projectId"]);
                include_once("view/doc/deprecatedDoc.php");
                break;
            default:
                echo "Erreur, impossible de rafraîchir la div " . $_POST['divToRefresh'];
                break;
        }
    } else if (isset($_POST['refreshProgressBar'])) {
        $proportion = compute_proportion_doc($_POST["projectId"]);
        if ($proportion != -1) {
            $percDone = $proportion[0];
            $percTodo = $proportion[1];
            $percDeprecated = $proportion[2];
        } else {
            $percDone = 0;
            $percTodo = 0;
            $percDeprecated = 0;
        }
        include_once("view/doc/progressBar.php");

    } else {

        $projectId = $_GET["projectId"];

        include_once("view/projectNav.php");

        $nbNewDeprecatedDoc = check_deprecated_doc($projectId);
        if ($nbNewDeprecatedDoc > 0) {
            include_once("view/errors/newDeprecatedDoc.php");
        }

        $isMaster = is_master($userId, $projectId);
        $isMember = is_member($userId, $projectId);

        $docTodo = get_all_todo_doc($projectId);
        $docDone = get_all_done_doc($projectId);
        $docDeprecated = get_all_deprecated_doc($projectId);

        $proportion = compute_proportion_doc($projectId);
        $percDone = $proportion[0];
        $percTodo = $proportion[1];
        $percDeprecated = $proportion[2];

        if (!$isMaster && !$isMember) {
            header('Location: index.php?action=projects');
        }

        if ($_SESSION['role'] == 'user') {
            include_once("view/memberHeader.php");
        } else {
            include_once("view/modHeader.php");
        }
        
        // Main divs
        include_once("view/doc/header.php");
        include_once("view/doc/progressBar.php"); 
        include_once("view/doc/commandPanel.php"); 
        include_once("view/doc/todoDoc.php"); 
        include_once("view/doc/deprecatedDoc.php"); 
        include_once("view/doc/doneDoc.php"); 
        include_once("view/doc/footer.php"); 

        // Modals
        include_once("view/doc/newDocModal.php");
        include_once("view/doc/passAllDocModal.php");
        include_once("view/doc/editDocModal.php");
        include_once("view/doc/deleteDocModal.php");

    }

?>