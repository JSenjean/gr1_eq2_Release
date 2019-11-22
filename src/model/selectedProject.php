<?php

function get_project_master($id){
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM user
            INNER JOIN project_member ON user.id = project_member.user_id
            WHERE project_member.project_id=:projectId
            AND project_member.role = 'master'"
        );
        $stmt->execute(array('projectId' => $id));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

function get_all_project_members($id) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM user
            INNER JOIN project_member ON user.id = project_member.user_id
            WHERE project_member.project_id=:projectId
            AND project_member.role != 'master'"
        );
        $stmt->execute(array('projectId' => $id));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

function get_all_project_joining_requests($id) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM user
            INNER JOIN project_invitation ON user.id = project_invitation.user_id
            WHERE project_invitation.project_id=:projectId
            AND project_invitation.request = 1"
        );
        $stmt->execute(array('projectId' => $id));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

function get_all_project_invitations($id) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM user
            INNER JOIN project_invitation ON user.id = project_invitation.user_id
            WHERE project_invitation.project_id=:projectId
            AND project_invitation.request = 0"
        );
        $stmt->execute(array('projectId' => $id));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

function get_project_by_id($id) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * FROM project
            WHERE project.id=:projectId"
        );
        $stmt->execute(array('projectId' => $id));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

function editProject ($id) {
    $name = trim(strip_tags($_POST['name']));
    $description = trim(strip_tags($_POST['description']));
    $visibility = isset($_POST['visibility']);
    try{
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "UPDATE project 
            SET name=:name, description=:description, visibility=:visibility 
            WHERE id=:id"
        );
        $stmt->execute(array(
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'visibility' => $visibility
        ));
    }
    catch(PDOException $e){
        echo  "<br>" . $e->getMessage();
    }
}

function acceptRequest ($project_id, $user_id, $role) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "INSERT INTO project_member(role, project_id, user_id) 
            SELECT :role, :project_id, :user_id
                FROM dual
                WHERE NOT EXISTS(
                    SELECT * FROM project_member
                    WHERE user_id=:user_id AND project_id=:project_id
            );
            DELETE FROM project_invitation 
            WHERE user_id=:user_id AND project_id=:project_id
        ");
        $stmt->execute(array(
            'role' => $role,
            'project_id' => $project_id,
            'user_id' => $user_id
        ));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

function deleteMember($project_id, $user_id) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "DELETE FROM project_member WHERE project_id=:project_id AND user_id=:user_id
        ");
        $stmt->execute(array(
            'project_id' => $project_id,
            'user_id' => $user_id
        ));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

function is_master($id, $project_id) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT pm.role 
            FROM project_member=pm 
            WHERE pm.user_id=:id 
            AND pm.project_id=:project_id");
        $stmt->execute(array(
            'id' => $id,
            'project_id' => $project_id
        ));
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
    if (isset($stmt)){
        $result = NULL;
        foreach($stmt as $s){
            $result = $s['role'];
        }
        if ($result == 'master'){
            return true;
        } else {
            return false;
        }
    }
}

function is_member($id, $project_id) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT pm.role 
            FROM project_member=pm 
            WHERE pm.user_id=:id 
            AND pm.project_id=:project_id");
        $stmt->execute(array(
            'id' => $id,
            'project_id' => $project_id
        ));
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
    if (isset($stmt)){
        $result = NULL;
        foreach($stmt as $s){
            $result = $s['role'];
        }
        if ($result == 'member'){
            return true;
        } else {
            return false;
        }
    }
}

function deleteInvitationOrRequest($project_id, $user_id) {
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "DELETE FROM project_invitation 
            WHERE project_id=:project_id 
            AND user_id=:user_id"
        );
        $stmt->execute(array(
            'project_id' => $project_id,
            'user_id' => $user_id
        ));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

?>
