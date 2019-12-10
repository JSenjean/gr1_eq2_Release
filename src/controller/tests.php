<?php

    include_once("model/selectedProject.php");
    include_once("model/tests.php");

    $userId = $_SESSION["id"];

    if (isset($_POST['manageTest'])) {
        $command = $_POST['manageTest'];
        if ($command == 'add') {
            echo add_new_test(
                $_POST["projectId"],
                $_POST["name"],
                $_POST["description"],
                $_POST["state"]
            );
        } else if ($command == 'passAll') {
            echo pass_all_tests($_POST["projectId"]);
        } else if ($command == 'edit') {
            echo edit_test(
                $_POST["id"],
                $_POST["name"],
                $_POST["description"],
                $_POST["state"]
            );
        } else if ($command == 'delete') {
            echo delete_test($_POST["id"], $_POST["state"]);
        } else if ($command == 'pass') {
            echo change_state($_POST["id"], 'passed');
        } else if ($command == 'fail') {
            echo change_state($_POST["id"], 'failed');
        }

    } else if (isset($_POST['divToRefresh'])) { // Refresh one of the divs containing the tests
        switch ($_POST['divToRefresh']) {
            case 'failed':
                $testsFailed = get_all_failed_tests($_POST["projectId"]);
                include_once("view/tests/failedTests.php");
                break;
            case 'deprecated':
                $testsDeprecated = get_all_deprecated_tests($_POST["projectId"]);
                include_once("view/tests/deprecatedTests.php");
                break;
            case 'never_run':
                $testsNeverRun = get_all_never_run_tests($_POST["projectId"]);
                include_once("view/tests/neverrunTests.php");
                break;
            case 'passed':
                $testsPassed = get_all_passed_tests($_POST["projectId"]);
                include_once("view/tests/passedTests.php");
                break;
            default:
                echo "Erreur, impossible de rafraîchir la div " . $_POST['divToRefresh'];
                break;
        }
    } else if (isset($_POST['refreshProgressBar'])) { // Refresh the test progress bar
        $proportion = compute_proportion($_POST["projectId"]);
        if ($proportion != -1) {
            $percPassed = $proportion[0];
            $percFailed = $proportion[1];
            $percDeprecated = $proportion[2];
            $percNeverRun = $proportion[3];
        } else {
            $percPassed = 0;
            $percFailed = 0;
            $percDeprecated = 0;
            $percNeverRun = 0;
        }
        include_once("view/tests/progressBar.php");

    } else {

        $projectId = $_GET["projectId"];

        include_once("view/projectNav.php");

        $nbNewDeprecatedTests = check_deprecated($projectId);
        if ($nbNewDeprecatedTests > 0) {
            include_once("view/errors/newDeprecated.php");
        }

        $isMaster = is_master($userId, $projectId);
        $isMember = is_member($userId, $projectId);

        $testsPassed = get_all_passed_tests($projectId);
        $testsDeprecated = get_all_deprecated_tests($projectId);
        $testsFailed = get_all_failed_tests($projectId);
        $testsNeverRun = get_all_never_run_tests($projectId);

        $proportion = compute_proportion($projectId);
        $percPassed = $proportion[0];
        $percFailed = $proportion[1];
        $percDeprecated = $proportion[2];
        $percNeverRun = $proportion[3];

        if (!$isMaster && !$isMember) {
            header('Location: index.php?action=projects');
        }

        if ($_SESSION['role'] == 'user') {
            include_once("view/memberHeader.php");
        } else {
            include_once("view/modHeader.php");
        }
        
        // Main divs
        include_once("view/tests/header.php");
        include_once("view/tests/progressBar.php"); 
        include_once("view/tests/commandPanel.php"); 
        include_once("view/tests/failedTests.php"); 
        include_once("view/tests/deprecatedTests.php"); 
        include_once("view/tests/neverrunTests.php"); 
        include_once("view/tests/passedTests.php"); 
        include_once("view/tests/footer.php"); 

        // Modals
        include_once("view/tests/newTestModal.php");
        include_once("view/tests/passAllTestsModal.php");
        include_once("view/tests/editTestModal.php");
        include_once("view/tests/deleteTestModal.php");

    }

?>
