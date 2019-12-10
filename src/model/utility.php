<?php 

/** profile
 *  -------
 *  @file
 *  @brief Various functions, who have for objectif to give all the necessary 
 * for all controller you will find fonctions for 
 * project user essentially CRUD function.
 */

    /**
     * @brief This function returns all users who do not belong to a project. 
     * @param projectId the project id 
     * @return The PDOStatement contening all users or -1 if an exception occurs
     */
function get_all_user_not_in_project($projectId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT u.username,u.id
                FROM user=u 
                WHERE u.id NOT IN ( SELECT user_id 
                                    FROM project_member
                                    WHERE project_id=:project_id)"
        );

        $stmt->execute(
            array(
                ':project_id' => $projectId
            )
        );
        return $stmt;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
}

/**
 * @brief This function adds an invitation to the database and inserts a line in the project_invitation table.
 * @param requesterUserName the username of the user that you wnat to invite to the project  
 * @param projectId the project id 
 * @return return 1 if success or -1 if an exception occurs
 */
function add_invitation_by_user_name($requesterUserName, $projectId)
{
    try {
        $bdd = dbConnect();
        if (check_if_request_already_exist($requesterUserName, $projectId, $bdd) == 0) {
            
            $stmt = $bdd->prepare(
                "INSERT INTO project_invitation (project_invitation.user_id,project_invitation.project_id,project_invitation.request) 
                    SELECT user.id, :project_id,:request 
                        FROM user 
                        WHERE user.username=:userToInvite
                "
            );

            $stmt->execute(array(
                ':project_id' => $projectId,
                ':userToInvite' => $requesterUserName,
                ':request' => 0

            ));
            return 1;
        }
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }

    return 1;
}

    /**
     * @brief This function checks if an invitation already exists this function is called when adding an invitation request.
     * @param requesterUserId The identifier of the user that you want to invite to the project
     * @param projectId The identifier of the project that you want to invite the user. 
     * @return 1 if succes -1 if an exception occurs
     */
function check_if_request_already_exist($requesterUserName, $projectId,$bdd)
{
    try {
        $stmt = $bdd->prepare(
            "SELECT *
                    FROM project_invitation=pi
                    WHERE pi.project_id=:project_id AND pi.user_id=( SELECT id FROM user where username=:name ) "
        );

        $stmt->execute(
            array(
                ':name' => $requesterUserName,
                ':project_id' => $projectId
            )
        );
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
}

?>