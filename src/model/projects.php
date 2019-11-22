<?php

/**
 * Return all project with id
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
    }
}


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
    }
}
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
    }
}

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
    }
}
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
    }
}
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
    }
}
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
    }

    return 1;
}

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
    }
}


