<?php
/** projects
 *  -------
 *  @file
 *  @brief Various functions, who have for objectif to give all the necessary 
 * for the controller projects you will find fonctions for 
 * project user inside project  essentially CRUD function.
 */


    /**
     * @brief This function return all projects of which a user is a member. 
     * @param id The identifier of the user for whom you want to retrieve all projects
     * @return the PDOStatement contening all the project return -1 if an exception occurs
     */
function get_all_project_by_user_id($id)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT p.id, p.name, p.description, p.visibility, pm.role
                    FROM project=p,project_member=pm
                    WHERE p.id=pm.project_id AND pm.user_id=:usrId"
        );

        $stmt->execute(array(':usrId' => (int) $id));
        return $stmt;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief This function retrieves all projects to which a user is not a member.  
     * @param id The identifier of the user for whom you want to retrieve all projects
     * @return the PDOStatement contening all the project return -1 if an exception occurs
     */
function get_all_project_without_user_id($id)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT p.id, p.name, p.description, p.visibility, pm.role, u.username, u.id
                    FROM project=p,project_member=pm,user=u
                    WHERE p.id=pm.project_id AND pm.user_id!=:usrId AND pm.role='master' AND pm.user_id=u.id"
        );

        $stmt->execute(array(':usrId' => (int) $id));
        return $stmt;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief this function remove a given project inside database on project table 
     * @param id the project id that you want to remove
     * @return 1 if succes -1 if an exception occurs
     */
function remove_by_project_id($id)
{
    try {


        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "DELETE FROM inside_project_role
                    WHERE project_id=:projectId"
        );

        $stmt->execute(array(':projectId' => (int) $id));

        $stmt = $bdd->prepare(
            "DELETE FROM project
                    WHERE id=:projectId"
        );

        $stmt->execute(array(':projectId' => (int) $id));
        return 1; //success
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}
    /**
     * @brief This function creates a new project and inserts it into the project table 
     * @param userId The identifier of the user who created the project this user will be declared by default head of this project 
     * @param name The name of the project you want to create. 
     * @param description The description of the project you want to create. 
     * @param visibility The visibility of the project you want to create by default the project is public.
     * @return The last insert index on the database or -1 if an exception occurs
     */
function create_new_project($userId, $name, $description, $visibility = 1)
{

    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "INSERT INTO 
             project(name,description,visibility) 
            VALUES(:name,:description,:visibility)"
        );

        $stmt->execute(array(
            ':name' => $name,
            ':description' => $description,
            ':visibility' => $visibility
        ));
        $projectId = $bdd->lastInsertId();
        associat_project_and_user($userId, $projectId, "master");
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief This function links a user to a project, this function is automatically called to create a project to associate the creator of the project to the project as project manager. 
     * @param userId The identifier of the user that you want to link to the project
     * @param projectId The identifier of the project that you want to link the user. 
     * @param role The role of the user you want to link to the project. 
     * @return 1 if succes -1 if an exception occurs
     */
function associat_project_and_user($userId, $projectId, $role)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "INSERT INTO 
             project_member(role,project_id,user_id) 
            VALUES(:role,:project_id,:user_id)"
        );

        $stmt->execute(array(
            ':role' => $role,
            ':project_id' => $projectId,
            ':user_id' => $userId

        ));
        return 1;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief This function removes a user from a project. 
     * @param userId The identifier of the user that you want to unlink to the project
     * @param projectId The identifier of the project that you want to unlink the user. 
     * @return 1 if succes -1 if an exception occurs
     */
function leave_a_project($userId, $projectId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "DELETE FROM  project_member
            WHERE project_id=:projectId AND user_id=:userId"
        );

        $stmt->execute(array(
            ':projectId' => $projectId,
            ':userId' => $userId

        ));
        //echo($userId);echo($projectId);
        return 1;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

    /**
     * @brief This function adds an invitation to a project to a user. 
     * @param requesterUserId The identifier of the user that you want to invite to the project
     * @param projectId The identifier of the project that you want to invite the user. 
     * @return 1 if succes -1 if an exception occurs
     */
function add_invitation_request($requesterUserId, $projectId)
{
    try {
        if (check_if_request_already_exist($requesterUserId, $projectId) == 0) {
            $bdd = dbConnect();
            $stmt = $bdd->prepare(
                "INSERT INTO 
            project_invitation(user_id,project_id,request) 
           VALUES(:user_id,:project_id,:request)"
            );

            $stmt->execute(array(
                ':project_id' => $projectId,
                ':user_id' => $requesterUserId,
                ':request' => 1

            ));
            return 1;
        }
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }

    return 1;
}

    /**
     * @brief This function checks if an invitation already exists this function is called when adding an invitation request.
     * @param requesterUserId The identifier of the user that you want to invite to the project
     * @param projectId The identifier of the project that you want to invite the user. 
     * @return 1 if succes -1 if an exception occurs
     */
function check_if_request_already_exist($requesterUserId, $projectId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT *
                    FROM project_invitation
                    WHERE user_id=:user_id AND project_id=:project_id AND request=:request"
        );

        $stmt->execute(
            array(
                ':user_id' => $requesterUserId,
                ':project_id' => $projectId,
                ':request' => 1
            )
        );
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}


