<?php
/** Tests
 *  ---------
 *  @file
 *  @brief Various functions to make the tests page works
 *  Mainly CRUD functions, plus some to deal with the progression bar
 */

/**
 * @brief Get all the tests that are marked as 'passed' in the database
 * @param projectId The id of the project we want to get the passed tests from
 * @return tests All the passed tests found for this project
 */
function get_all_passed_tests($projectId) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM test
            WHERE project_id=:projectId
            AND state = 'passed'"
        );
        $stmt->execute(array('projectId' => $projectId));
        return $stmt;
    } catch (PDOException $e) {
        echo"<br>" . $e->getMessage();
    }
}

/**
 * @brief Get all the tests that are marked as 'deprecated' in the database
 * @param projectId The id of the project we want to get the deprecated tests from
 * @return tests All the deprecated tests found for this project
 */
function get_all_deprecated_tests($projectId) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM test
            WHERE project_id=:projectId
            AND state = 'deprecated'"
        );
        $stmt->execute(array('projectId' => $projectId));
        return $stmt;
    } catch (PDOException $e) {
        echo"<br>" . $e->getMessage();
    }
}

/**
 * @brief Get all the tests that are marked as 'failed' in the database
 * @param projectId The id of the project we want to get the failed tests from
 * @return tests All the failed tests found for this project
 */
function get_all_failed_tests($projectId) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM test
            WHERE project_id=:projectId
            AND state = 'failed'"
        );
        $stmt->execute(array('projectId' => $projectId));
        return $stmt;
    } catch (PDOException $e) {
        echo"<br>" . $e->getMessage();
    }
}

/**
 * @brief Get all the tests that are marked as 'never run' in the database
 * @param projectId The id of the project we want to get the never run tests from
 * @return tests All the never run tests found for this project
 */
function get_all_never_run_tests($projectId) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM test
            WHERE project_id=:projectId
            AND state = 'never_run'"
        );
        $stmt->execute(array('projectId' => $projectId));
        return $stmt;
    } catch (PDOException $e) {
        echo"<br>" . $e->getMessage();
    }
}

/**
 * @brief Compute proportion of each type of test (passed, failed, deprecated, never run)
 * @param projectId The id of the project we want to count tests from
 * @return counts Return an array containing the total number of tests, and the numbers of the passed, failed, deprecated and never run tests 
 */
function count_proportion($projectId) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM test
            WHERE project_id=:projectId"
        );
        $stmt->execute(array('projectId' => $projectId));
    } catch (PDOException $e) {
        echo"<br>" . $e->getMessage();
    }

    $nbPassed = 0;
    $nbFailed = 0;
    $nbDeprecated = 0;
    $nbNeverRun = 0;
    $nbTotalTests = 0;

    foreach ($stmt as $s) {
        switch ($s['state']) {
            case 'passed':
                ++$nbPassed;
                break;
            case 'failed':
                ++$nbFailed;
                break;
            case 'deprecated':
                ++$nbDeprecated;
                break;
            case 'never_run':
                ++$nbNeverRun;
                break;
            default:
                echo "Error, Test n°" . $s['id'] . " named " . $s['name'] . " has an unknown state";
                return -1;
        }
        ++$nbTotalTests;
    }
    
    return array($nbTotalTests, $nbPassed, $nbFailed, $nbDeprecated, $nbNeverRun);
}

/**
 * @brief Compute the tests proportions of each category (passed, failed, deprecated, never run) to make percentages
 * @param projectId The id of the project we want to compute the tests proportions from
 * @return percentages Return an array containing the four percentages of passed, failed, deprecated and never run tests
 */
function compute_proportion($projectId) {

    $proportion = count_proportion($projectId);

    $nbTotalTests = $proportion[0];
    $nbPassed = $proportion[1];
    $nbFailed = $proportion[2];
    $nbDeprecated = $proportion[3];
    $nbNeverRun = $proportion[4];

    if ($nbTotalTests != 0) {

        $percPassed = (int) (($nbPassed*100)/$nbTotalTests);
        $percFailed = (int) (($nbFailed*100)/$nbTotalTests);
        $percDeprecated = (int) (($nbDeprecated*100)/$nbTotalTests);
        $percNeverRun = (int) (($nbNeverRun*100)/$nbTotalTests);

        // Avoid blank in progress bar
        $sum = $percPassed + $percFailed + $percDeprecated + $percNeverRun;
        while ($sum < 100) {
            if ($percPassed > 0) { ++$percPassed; } else if ($percNeverRun > 0) { ++$percNeverRun; } else if ($percDeprecated > 0) { ++$percDeprecated; } else if ($percFailed > 0) { ++$percFailed; } else {break; }
            $sum = $percPassed + $percFailed + $percDeprecated + $percNeverRun;
        }
    
        return array($percPassed, $percFailed, $percDeprecated, $percNeverRun);

    } else {
        return array(0, 0, 0, 0);
    }
}

/**
 * @brief Function to add a new test to the specified projet
 * @param projectId The id of the project we want to add the test to
 * @param name The name of the test
 * @param description The text description of the test
 * @param state The enum state of the test (can be passed, failed, deprecated or never_run)
 * @return state Return the state of the added test (this state will be used by the jQuery code to know which part of the page to refresh)
 */
function add_new_test($projectId, $name, $description, $state) {
    date_default_timezone_set('Europe/Paris');
    $currentDate = date('Y-m-d', time());
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "INSERT INTO
            test(project_id, name, description, last_run, state)
            VALUES(:project_id, :name, :description, :last_run, :state)"
        );
        $stmt->execute(array(
            ':project_id' => $projectId,
            ':name' => $name,
            ':description' => $description,
            ':last_run' => $currentDate,
            ':state' => $state
        ));
        return $state;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
        return -1;
    }
}

/**
 * @brief Function to mark all tests of a given project as passed and refresh their execution date
 * @param projectId The id of the project that will have all its tests marked as passed
 * @return stmt The statement value of the executed sql instruction
 */
function pass_all_tests($projectId) {
    date_default_timezone_set('Europe/Paris');
    $currentDate = date('Y-m-d', time());
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "UPDATE test
            SET state=:state, last_run=:last_run
            WHERE project_id=:project_id"
        );
        $stmt->execute(array(
            ':project_id' => $projectId,
            ':last_run' => $currentDate,
            ':state' => 'passed'
        ));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
        return -1;
    }
}

/**
 * @brief Modify the informations of a test from its id
 * @param id The id of the test we want to modify
 * @param name The new name of the test (can be the same as the old one)
 * @param description The new description of the test (can be the same as the old one)
 * @param state The new state of the test (can be the same as the old one)
 * @return state Return the state of the edited test. This way the jQuery code will know what section of the page that needs to be refreshed
 */
function edit_test($id, $name, $description, $state) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "UPDATE test
            SET name=:name, description=:description, state=:state
            WHERE id=:id"
        );
        $stmt->execute(array(
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'state' => $state
        ));
        return $state;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
        return -1;
    }
}

/**
 * @brief Delete a test from its id
 * @param id The id of the test we want to delete
 * @param state The state of the test that will be used only in the return instruction
 * @return state Return the state of the deleted test. This way the jQuery code will know what section of the page that needs to be refreshed
 */
function delete_test($id, $state) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "DELETE FROM test
            WHERE id=:id"
        );
        $stmt->execute(array(
            'id' => $id
        ));
        return $state;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
        return -1;
    }
}

/**
 * @brief Change the state of a test from its id and refresh its execution date. The function can be used only to refresh last execution date (without state change)
 * @param id The id of the test that will change state
 * @param state The new state of the test
 * @return stmt The returned statement of the executed sql request
 */
function change_state($id, $state) {
    date_default_timezone_set('Europe/Paris');
    $currentDate = date('Y-m-d', time());
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "UPDATE test
            set state=:state, last_run=:last_run
            WHERE id=:id"
        );
        $stmt->execute(array(
            'id' => $id,
            'last_run' => $currentDate,
            'state' => $state
        ));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
        return -1;
    }
}

/**
 * @brief This function check all passed tests in the database for a given project and mark them as deprecated if they are too old
 * @param projectId The id of the project we want to check deprecated tests from
 * @return number Return the number of deprecated tests found. If there was an error during execution, return -1
 */
function check_deprecated($projectId) {
    
    date_default_timezone_set('Europe/Paris');
    $treshold = strtotime("-2 week"); // Arbitrary and temporary value
    
    $nbNewDeprecatedTests = 0;

    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM test
            WHERE state=:state
            AND project_id=:project_id"
        );
        $stmt->execute(array(
            'state' => 'passed',
            'project_id' => $projectId
        ));
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
        return -1;
    }
    foreach ($stmt as $s) {
        $last_run = strtotime($s['last_run']);
        if ($last_run < $treshold) { // If last_run date is older than threshold date
            ++$nbNewDeprecatedTests;
            $stmt2 = $bdd->prepare(
                "UPDATE test
                set state=:state
                WHERE id=:id"
            );
            $stmt2->execute(array(
                'id' => $s['id'],
                'state' => 'deprecated'
            ));
        }
    }
    return $nbNewDeprecatedTests;
}

?>
