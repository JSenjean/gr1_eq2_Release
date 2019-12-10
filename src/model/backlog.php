<?php
/** Backlog
 *  -------
 *  @file
 *  @brief Various functions, who have for objectif to give all the necessary 
 * for the controller backlog you will find fonctions for 
 * userStories insideProjectRole essentially CRUD function.
 */



    /**
     * @brief this function add a given project_role inside database on inside_project_role table 
     * @param projectID the project id where you want to insert the project_role
     * @param roleName the name of the role that you want add to the project
     * @param roleDescritpion the description of the role that you want add to the project
     * @return The last insert index on the database or -1 if an exception occurs
     */
function add_inside_project_role($projectID, $roleName, $roleDescription)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "INSERT INTO 
             inside_project_role(project_id,name,description) 
            VALUES(:project_id,:name,:description)"
        );

        $stmt->execute(array(
            ':project_id' => $projectID,
            ':name' => $roleName,
            ':description' => $roleDescription
        ));
        return $bdd->lastInsertId();
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}
    /**
     * @brief this function return all inside_project_role of a given project
     * @param projectID the project id where you want to get the project_role
     * @return the PDOStatement contening all the project role or return -1 if an exception occurs
     */
function get_all_inside_project_role($projectID)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT *
                FROM inside_project_role
                WHERE project_id=:projectId"
        );

        $stmt->execute(array(':projectId' => $projectID));

        return $stmt;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief this function modify a given project_role inside database on inside_project_role table 
     * @param roleID the role id that you want to modify 
     * @param roleName the new name to insert inside the role
     * @param roleDescritpion the new description to insert inside the role
     * @return the roleID that you have modify or -1 if an exception occurs
     */
function modify_inside_project_role($roleID, $roleName, $roleDescription)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "UPDATE inside_project_role
                SET name=:roleName, description=:roleDescription
                WHERE id=:roleID"
        );

        $stmt->execute(array(
            ':roleID' => $roleID,
            ':roleName' => $roleName,
            ':roleDescription' => $roleDescription
        ));
        return $roleID;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief this function remove a given project_role inside database on inside_project_role table 
     * @param roleID the role id that you want to remove
     * @return 1 if succes -1 if an exception occurs
     */
function remove_by_role_id($id)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "DELETE FROM inside_project_role
                    WHERE id=:roleID"
        );

        $stmt->execute(array(':roleID' => $id));
        return 1; //success
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief this function return all User stories of a given project
     * @param projectID the project id where you want to get the user stories
     * @return the PDOStatement contening all the userStories or return -1 if an exception occurs
     */
function get_all_US_by_project_id($project_id)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT us.*
                FROM user_story=us
                WHERE us.project_id=:projectID
                ORDER BY us.done ASC, us.id ASC"
        );

        $stmt->execute(array(':projectID' => $project_id));
        return $stmt; //success
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
}

    /**
     * @brief this function add a given user_story inside database on user_story table 
     * @param projectID the project id where you want to insert the user_story
     * @param USName the name of the User_story that you want add to the project
     * @param roleId the role id that you want to link with the user_story
     * @param iCan the iCan description of the user_story that you want add to the project 
     * @param soThat the soThat description of the user_story that you want add to the project
     * @param difficulty the difficulty of the US value possible : 1 2 3 5 8 13 21 34
     * @param workValue the workValue of the US value possible : low medium hight very-hight 
     * @param done a boolean integer that indicates if the user story is finished  
     * @return The last insert index on the database or -1 if an exception occurs
     */
function add_inside_project_US($projectID, $USName, $roleId, $iCan, $soThat, $difficulty, $workValue, $done)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "INSERT INTO 
             user_story(project_id,name,priority,effort,i_can,so_that,role_id,done) 
            VALUES(:projectID,:USName,:workValue,:difficulty,:iCan,:soThat,:roleId,:done)"
        );

        $stmt->execute(array(
            ':projectID' => $projectID,
            ':USName' => $USName,
            ':roleId' => $roleId,
            ':workValue' => $workValue,
            ':difficulty' => $difficulty,
            ':iCan' => $iCan,
            ':soThat' => $soThat,
            ':roleId' => $roleId,
            ':done' => $done,

        ));
        return $bdd->lastInsertId();
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief this function remove a given user_story inside database on user_story table 
     * @param roleID the user_story id that you want to remove
     * @return 1 if succes -1 if an exception occurs
     */
function remove_US_by_id($USId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "DELETE FROM user_story
                    WHERE id=:USId"
        );

        $stmt->execute(array(':USId' => $USId));
        return 1; //success
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
}

    /**
     * @brief this function modify a given user_story inside database on user_story table 
     * @param usID the user_story id that you want to modify
     * @param USName the new value for the name
     * @param roleId the new value for the roleID
     * @param iCan the new value for the iCan
     * @param soThat the new value for the soThat
     * @param difficulty the new value for the difficulty value possible : 1 2 3 5 8 13 21 34
     * @param workValue the new value for the workValue value possible : low medium hight very-hight 
     * @param done the new value for the done  
     * @return The id of the US or -1 if an exception occurs
     */
function modify_inside_project_US($usID, $projectID, $USName, $roleId, $iCan, $soThat, $difficulty, $workValue, $done)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "UPDATE user_story
                SET 
                    project_id=:projectID,
                    name=:USName,
                    priority=:workValue,
                    effort=:difficulty,
                    i_can=:iCan,
                    so_that=:soThat,
                    role_id=:roleId,
                    done=:done
                WHERE id=:usId"
        );

        $stmt->execute(array(
            ':projectID' => $projectID,
            ':USName' => $USName,
            ':roleId' => $roleId,
            ':workValue' => $workValue,
            ':difficulty' => $difficulty,
            ':iCan' => $iCan,
            ':soThat' => $soThat,
            ':roleId' => $roleId,
            ':done' => $done,
            ':usId' => $usID

        ));
        return $usID;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}
?>
