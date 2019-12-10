<?php
/** release
 *  -------
 *  @file
 *  @brief Various functions, who have for objectif to give all the necessary 
 * for the controller release you will find fonctions for 
 * project_commits essentially CRUD function.
 */

 
    /**
     * @brief This function return the git url of a given project 
     * @param projectID The identifier of the project that you want the url 
     * @return the PDOStatement contening the gitUrl return -1 if an exception occurs
     */
function get_git_url($projectID)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT release_git
                FROM project
                WHERE id=:projectId"
        );

        $stmt->execute(array(':projectId' => $projectID));
        return $stmt;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}
    /**
     * @brief save all given commits int the database in project_commit table  
     * @param projectID The identifier of the project that you to save the commit
     * @param allCommits An array containing the commits to be inserted must be a two-dimensional array 
     * @return 1 if succes -1 if an exception occurs
     */
function save_all_commit($projectID, $allCommits)
{
    //$command.="INSERT INTO project_commit(project_id,sha,committerName,commitMessage,commitUrl) VALUES(" . $projectID .",". $oneCommit->sha . ",". $oneCommit->commit->author->name . "," . $oneCommit->commit->message . "," . $oneCommit->html_url ." )";

    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "INSERT INTO project_commit(project_id,sha,committerName,commitMessage,commitUrl,commitDate) VALUES(:projectID,:sha,:committerName,:commitMessage,:commitUrl,:commitDate)"
        );
        foreach ($allCommits as $cell) {
            if (is_array($cell)) {
                foreach ($cell as $oneCommit) {
                    $stmt->execute(
                        array(
                    ':projectID' => $projectID,
                    ':sha' => $oneCommit->sha,
                    ':committerName' => $oneCommit->commit->author->name,
                    ':commitMessage' => $oneCommit->commit->message,
                    ':commitUrl' => $oneCommit->html_url,
                    ':commitDate' => date('Y-m-d H:i:s', strtotime(($oneCommit->commit->author->date))),

                )
                    );
                }
            }
        }
        if (count($allCommits[1]) > 0) {
            deprecate_all_test($projectID);
        }
        return 1;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief This function is automatically called when you insert a new commit in the database and makes all the tests of a project obsolete.  
     * @param projectID The identifier of the project
     * @return 1 if succes -1 if an exception occurs
     */
function deprecate_all_test($projectID)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "UPDATE test SET state='deprecated' WHERE project_id=:projectId"
        );
        $stmt->execute(array(':projectId' => $projectID));
        return 1;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief This function allows you to modify the git URL associated with a project  
     * @param projectID The identifier of the project
     * @param gitUrl the new gitUrl
     * @return 1 if succes -1 if an exception occurs
     */
function change_git_url($projectID, $gitUrl)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "UPDATE project SET release_git=:gitUrl WHERE id=:projectId"
        );
        $stmt->execute(
            array(
            ':projectId' => $projectID,
            ':gitUrl' => $gitUrl,
            )
        );
        delete_all_commits($projectID);
        return 1;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}


    /**
     * @brief This function removes all commits for a project from the database. This function is automatically called when you change the URL of a project's git.   
     * @param projectID The identifier of the project
     * @return 1 if succes -1 if an exception occurs
     */
function delete_all_commits($projectID)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "DELETE FROM project_commit WHERE project_id=:projectId"
        );
        $stmt->execute(
            array(
            ':projectId' => $projectID,
            )
        );
        return 1;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}


    /**
     * @brief This function returns all the commits for a given project.  
     * @param projectID The identifier of the project that you the commits
     * @return the PDOStatement contening the all commit or return -1 if an exception occurs
     */
function get_all_commit($projectID)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT *
                FROM project_commit
                WHERE project_id=:projectId
                ORDER BY commitDate DESC"

        );

        $stmt->execute(array(':projectId' => $projectID));
        return $stmt;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief This function returns the last commit for a given project.  
     * @param projectID The identifier of the project that you the commit
     * @return the PDOStatement contening the commit or return -1 if an exception occurs
     */
function get_last_commit($projectID)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT commitDate
                FROM project_commit
                WHERE project_id=:projectId
                ORDER BY commitDate DESC
                LIMIT 1"
        );

        $stmt->execute(array(':projectId' => $projectID));
        return $stmt;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}
