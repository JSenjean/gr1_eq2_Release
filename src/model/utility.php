<?php 
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
function add_invitation_by_user_name($requesterUserName, $projectId)
{
    try {
        $bdd = dbConnect();
        if (check_if_request_already_exist($requesterUserName, $projectId,$bdd) == 0) {
            
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