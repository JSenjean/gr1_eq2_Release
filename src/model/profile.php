<?php
/** profile
 *  -------
 *  @file
 *  @brief Various functions, who have for objectif to give all the necessary 
 * for the controller profile you will find fonctions for 
 * project_invitation user essentially CRUD function.
 */

    /**
     * @brief This function return the information about the given user
     * @param userName The name of the user that you want the information 
     * @return an array contening the information about given user return -1 if an exception occurs
     */
function getUserProfile($userName)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * 
                FROM user 
                WHERE username=:username"
        );
        $stmt->execute(array(
            'username' => $userName
        ));
        return $stmt->fetch(PDO::FETCH_ASSOC);
         
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
}


    /**
     * @brief This function Return the number of projects in which a user participates. 
     * @param userId The id of the user that you want the number of project
     * @return  the number of project about given user return -1 if an exception occurs
     */
function getUserNbParticipation($userId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT COUNT(*) 
                FROM project_member 
                WHERE user_id=:id"
        );
        $stmt->execute(array(
            'id' => $userId
        ));
        return $stmt->fetch(PDO::FETCH_NUM);
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
}

    /**
     * @brief Returns all invitations or requests for a given user. 
     * @param isRequest 1 for a request and 0 for an invitation 
     * @param userId The id of the user that you want the number of project
     * @return  the PDOStatement contening thenumber of project about given user return -1 if an exception occurs
     */
function getUserInvitationsOrRequest($isRequest, $userId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT pi.*, p.name
                FROM project_invitation=pi, project=p
                WHERE pi.user_id=:id AND pi.request=:req AND pi.project_id=p.id
                ORDER BY p.name"
        );
        $stmt->execute(array(
            'id' => $userId,
            'req' => $isRequest
        ));
        return $stmt;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
}
    /**
     * @brief This function allows you to cancel a request by deleting the line in the database. this function is automaticly call when you accept an invitation.
     * @param projectIdToCancel the project id
     * @param userId the user id 
     * @return  1 if succes -1 if an exception occurs
     */
function CancelRequest($projectIdToCancel, $userId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "DELETE 
                FROM project_invitation
                WHERE user_id=:user_id AND project_id=:project_id"
        );
        $stmt->execute(array(
            'user_id' => $userId,
            'project_id' => $projectIdToCancel
        ));
        return 1;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }

    return 1;
}


/**
 * @brief This function adds a user who has received an invitation to a project to the project. 
 * @param projectIdToJoin the project id
 * @param userId the user id 
 * @return  1 if succes -1 if an exception occurs
 */
function AcceptInvitaion($projectIdToJoin, $userId)
{
    try {
        $bdd = dbConnect();
        CancelRequest($projectIdToJoin, $userId);
        $stmt = $bdd->prepare(
            "INSERT INTO 
                project_member(user_id,project_id,role) 
                VALUES(:user_id,:project_id,:role)"
        );
        $stmt->execute(array(
            ':project_id' => $projectIdToJoin,
            ':user_id' => $userId,
            ':role' => "member"
        ));
        return 1;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
    
    return 1;
}

/**
 * @brief This function delete the user with his username
 * @param userName the user name of the usert that you want to remove  
 * @return  1 if succes -1 if an exception occurs
 */
function deleteAccount($userName)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "DELETE 
                FROM user 
                WHERE username=:username"
        );
        $stmt->execute(array(
            'username' => $userName
        ));
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
}


/**
 * Update the informations of the user specified by his username from a POST request
 */
function editInfo($user)
{
    if (isset($_POST ['submit'])) {
        $newUsername = trim(strip_tags($_POST['username']));
        $newFirstName = trim(strip_tags($_POST['firstname']));
        $newLastName = trim(strip_tags($_POST['lastname']));
        $newEmail = trim(strip_tags($_POST['email']));

        if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['firstname'] && !empty($_POST['lastname']))) {
            if (strlen($newUsername) <= 100 && strlen($newFirstName) <= 100 && strlen($newLastName) <= 100) {
                if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                    $bdd = dbConnect();
                    $reqmail = $bdd->prepare(
                        "SELECT * 
                            FROM user 
                            WHERE email = ?"
                    );
                    $reqmail->execute(array($newEmail));

                    if ($reqmail->rowCount() > 0) {
                        $result = $reqmail->fetch(PDO::FETCH_ASSOC);
                        if ($result['username'] == $user) { // We can replace its old mail with the same one
                            $mailexist = 0;
                        } else {
                            $mailexist = 1;
                        }
                    }

                    $requsername = $bdd->prepare(
                        "SELECT * 
                            FROM user 
                            WHERE username = ?"
                    );
                    $requsername->execute(array($newUsername));

                    if ($requsername->rowCount() > 0) {
                        $result = $requsername->fetch(PDO::FETCH_ASSOC);
                        if ($result['username'] == $user) { // We can replace its old username with the same one
                            $usernameexist = 0;
                        } else {
                            $usernameexist = 1;
                        }
                    }

                    if ($mailexist == 0) {
                        if ($usernameexist == 0) {
                            try {
                                $stmt = $bdd->prepare(
                                    "UPDATE user 
                                        SET username=:newUsername, first_name=:newFirstName, last_name=:newLastName, email=:newEmail 
                                        WHERE username=:username"
                                );
                                $stmt->execute(array(
                                    'newUsername' => $newUsername,
                                    'newFirstName' => $newFirstName,
                                    'newLastName' => $newLastName,
                                    'newEmail' => $newEmail,
                                    'username' => $user
                                ));
                                $_SESSION['username'] = $newUsername;
                            } catch (PDOException $e) {
                                echo $e . "<br>" . $e->getMessage();
                            }
                            return 0;
                        } else {
                            return -3; // Username already used
                        }
                    } else {
                        return -2; // Mail already used
                    }
                }
            }
        }
    }

    return -1;
}
