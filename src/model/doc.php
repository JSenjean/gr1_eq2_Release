<?php
/** Doc
 *  ---------
 *  @file
 *  @brief Various functions to make the doc page works
 *  Mainly CRUD functions, plus some to deal with the progression bar
 */

/**
 * @brief Get all the doc that is marked as 'done' in the database
 * @param projectId The id of the project we want to get the done doc from
 * @return docs All the done doc found for this project
 */
function get_all_done_doc($projectId) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM doc_section
            WHERE project_id=:projectId
            AND state = 'done'"
        );
        $stmt->execute(array('projectId' => $projectId));
        return $stmt;
    } catch (PDOException $e) {
        echo"<br>" . $e->getMessage();
    }
}

/**
 * @brief Get all the doc that is marked as 'todo' in the database
 * @param projectId The id of the project we want to get the to do doc from
 * @return docs All the to do doc found for this project
 */
function get_all_todo_doc($projectId) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM doc_section
            WHERE project_id=:projectId
            AND state = 'todo'"
        );
        $stmt->execute(array('projectId' => $projectId));
        return $stmt;
    } catch (PDOException $e) {
        echo"<br>" . $e->getMessage();
    }
}

/**
 * @brief Get all the doc that is marked as 'deprecated' in the database
 * @param projectId The id of the project we want to get the deprecated doc from
 * @return docs All the deprecated doc found for this project
 */
function get_all_deprecated_doc($projectId) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM doc_section
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
 * @brief Compute proportion of each type of doc (done, to do, deprecated)
 * @param projectId The id of the project we want to count doc from
 * @return counts Return an array containing the total number of docs, and the numbers of the done, to do, deprecated docs
 */
function count_proportion_doc($projectId) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM doc_section
            WHERE project_id=:projectId"
        );
        $stmt->execute(array('projectId' => $projectId));
    } catch (PDOException $e) {
        echo"<br>" . $e->getMessage();
    }

    $nbDone = 0;
    $nbTodo = 0;
    $nbDeprecated = 0;
    $nbTotalDoc = 0;

    foreach ($stmt as $s) {
        switch ($s['state']) {
            case 'done':
                ++$nbDone;
                break;
            case 'todo':
                ++$nbTodo;
                break;
            case 'deprecated':
                ++$nbDeprecated;
                break;
            default:
                echo "Error, Test n°" . $s['id'] . " named " . $s['name'] . " has an unknown state";
                return -1;
        }
        ++$nbTotalDoc;
    }
    
    return array($nbTotalDoc, $nbDone, $nbTodo, $nbDeprecated);
}

/**
 * @brief Compute the doc proportions of each category (done, to do, deprecated) to make percentages
 * @param projectId The id of the project we want to compute the doc proportions from
 * @return percentages Return an array containing the three percentages of done, todo and deprecated docs
 */
function compute_proportion_doc($projectId) {

    $proportion = count_proportion_doc($projectId);

    $nbTotalDoc = $proportion[0];
    $nbDone = $proportion[1];
    $nbTodo = $proportion[2];
    $nbDeprecated = $proportion[3];

    if ($nbTotalDoc != 0) {

        $percDone = (int) (($nbDone*100)/$nbTotalDoc);
        $percTodo = (int) (($nbTodo*100)/$nbTotalDoc);
        $percDeprecated = (int) (($nbDeprecated*100)/$nbTotalDoc);

        // Avoid blank in progress bar
        $sum = $percDone + $percTodo + $percDeprecated;
        while ($sum < 100) {
            if ($percDone > 0) { ++$percDone; } else if ($percDeprecated > 0) { ++$percDeprecated; } else if ($percTodo > 0) { ++$percTodo; } else {break; }
            $sum = $percDone + $percTodo + $percDeprecated;
        }
    
        return array($percDone, $percTodo, $percDeprecated);

    } else {
        return array(0, 0, 0);
    }
}

/**
 * @brief Function to add a new doc element to the specified project
 * @param projectId The id of the project we want to add the doc to
 * @param name The name of the doc
 * @param description The text description of the doc
 * @param state The enum state of the doc (can be done, to do or deprecated)
 * @return state Return the state of the added doc(this state will be used by the jQuery code to know which part of the page to refresh)
 */
function add_new_doc($projectId, $name, $description, $state) {
    date_default_timezone_set('Europe/Paris');
    $currentDate = date('Y-m-d', time());
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "INSERT INTO
            doc_section(project_id, name, description, last_update, state)
            VALUES(:project_id, :name, :description, :last_update, :state)"
        );
        $stmt->execute(array(
            ':project_id' => $projectId,
            ':name' => $name,
            ':description' => $description,
            ':last_update' => $currentDate,
            ':state' => $state
        ));
        return $state;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
        return -1;
    }
}

/**
 * @brief Function to mark all doc elements of a given project as done and refresh their last update date
 * @param projectId The id of the project that will have all its doc marked as done
 * @return stmt The statement value of the executed sql instruction
 */
function all_doc_done($projectId) {
    date_default_timezone_set('Europe/Paris');
    $currentDate = date('Y-m-d', time());
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "UPDATE doc_section
            SET state=:state, last_update=:last_update
            WHERE project_id=:project_id"
        );
        $stmt->execute(array(
            ':project_id' => $projectId,
            ':last_update' => $currentDate,
            ':state' => 'done'
        ));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
        return -1;
    }
}

/**
 * @brief Modify the informations of a doc from its id
 * @param id The id of the doc we want to modify
 * @param name The new name of the doc element (can be the same as the old one)
 * @param description The new description of the doc (can be the same as the old one)
 * @param state The new state of the doc (can be the same as the old one)
 * @return state Return the state of the edited doc. This way the jQuery code will know what section of the page that needs to be refreshed
 */
function edit_doc($id, $name, $description, $state) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "UPDATE doc_section
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
 * @brief Delete a doc element with its id
 * @param id The id of the doc we want to delete
 * @param state The state of the doc that will be used only in the return instruction
 * @return state Return the state of the deleted doc. This way the jQuery code will know what section of the page that needs to be refreshed
 */
function delete_doc($id, $state) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "DELETE FROM doc_section
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
 * @brief Change the state of a doc element from its id and refresh its last update date. The function can be used only to refresh last update date (without state change)
 * @param id The id of the doc that will change state
 * @param state The new state of the doc
 * @return stmt The returned statement of the executed sql request
 */
function change_state_doc($id, $state) {
    date_default_timezone_set('Europe/Paris');
    $currentDate = date('Y-m-d', time());
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "UPDATE doc_section
            set state=:state, last_update=:last_update
            WHERE id=:id"
        );
        $stmt->execute(array(
            'id' => $id,
            'last_update' => $currentDate,
            'state' => $state
        ));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
        return -1;
    }
}

/**
 * @brief This function check all done doc in the database for a given project and mark it as deprecated if it is too old
 * @param projectId The id of the project we want to check deprecated doc from
 * @return number Return the number of deprecated doc element found. If there was an error during execution, return -1
 */
function check_deprecated_doc($projectId) {
    
    date_default_timezone_set('Europe/Paris');
    $treshold = strtotime("-2 week"); // Arbitrary and temporary value
    
    $nbNewDeprecatedDoc = 0;

    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM doc_section
            WHERE state=:state
            AND project_id=:project_id"
        );
        $stmt->execute(array(
            'state' => 'done',
            'project_id' => $projectId
        ));
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
        return -1;
    }
    foreach ($stmt as $s) {
        $last_update = strtotime($s['last_update']);
        if ($last_update < $treshold) { // If last_update date is older than threshold date
            ++$nbNewDeprecatedDoc;
            $stmt2 = $bdd->prepare(
                "UPDATE doc_section
                set state=:state
                WHERE id=:id"
            );
            $stmt2->execute(array(
                'id' => $s['id'],
                'state' => 'deprecated'
            ));
        }
    }
    return $nbNewDeprecatedDoc;
}

?>