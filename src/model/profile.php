<?php

    /**
     * Return all the informations of the current user
     */
    function getUserProfile(){
        try{
            $bdd = dbConnect();
            $username = $_SESSION['username'];
            $stmt = $bdd->prepare(
                "SELECT * 
                    FROM user 
                    WHERE username=:username"
            );
            $stmt->execute(array(
                'username' => $username
            ));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(PDOException $e){
            echo  "<br>" . $e->getMessage();
        }
    }


    /**
     * Return the user's number of project
     */
    function getUserNbParticipation(){
        try{
            $bdd = dbConnect();
            $stmt = $bdd->prepare(
                "SELECT COUNT(*) 
                    FROM project_member 
                    WHERE user_id=:id"
            );
            $stmt->execute(array(
                'id' => $_SESSION['id']
            ));
            $result = $stmt->fetch(PDO::FETCH_NUM);
            return $result;
        }
        catch(PDOException $e){
            echo  "<br>" . $e->getMessage();
        }
    }

    /**
     *  Function that return either the user's invitations if isRequest's value is 0 or the user's requests if isRequest is 1
     */
    function getUserInvitationsOrRequest($isRequest) {
        try{
            $bdd = dbConnect();
            $stmt = $bdd->prepare(
                "SELECT pi.*, p.name
                    FROM project_invitation=pi, project=p
                    WHERE pi.user_id=:id AND pi.request=:req AND pi.project_id=p.id
                    ORDER BY p.name"
            );
            $stmt->execute(array(
                'id' => $_SESSION['id'],
                'req' => $isRequest
            ));
            return $stmt;
        }
        catch(PDOException $e){
            echo  "<br>" . $e->getMessage();
        }
    }

    function CancelRequest($projectIdToCancel) {
        try{
            $bdd = dbConnect();
            $stmt = $bdd->prepare(
                "DELETE 
                    FROM project_invitation
                    WHERE user_id=:user_id AND project_id=:project_id"
            );
            $stmt->execute(array(
                'user_id' => $_SESSION['id'],
                'project_id' => $projectIdToCancel
            ));
            return 1;
        }
        catch(PDOException $e){
            echo  "<br>" . $e->getMessage();
        }

        return 1;
    }

    function AcceptInvitaion($projectIdToJoin) {
        try{
            $bdd = dbConnect();
            CancelRequest($projectIdToJoin);
            $stmt = $bdd->prepare(
                "INSERT INTO 
                    project_member(user_id,project_id,role) 
                    VALUES(:user_id,:project_id,:role)"
            );
            $stmt->execute(array(
                ':project_id' => $projectIdToJoin,
                ':user_id' => $_SESSION['id'],
                ':role' => "member"
            ));
            return 1;
        }
        catch(PDOException $e){
            echo  "<br>" . $e->getMessage();
        }
        
        return 1;
    }

    /**
     * Delete the account of the current user
     */
    function deleteAccount(){
        try{
            $bdd = dbConnect();
            $stmt = $bdd->prepare(
                "DELETE 
                    FROM user 
                    WHERE username=:username"
            );
            $stmt->execute(array(
                'username' => $_SESSION['username']
            ));
        }
        catch(PDOException $e){
            echo  "<br>" . $e->getMessage();
        }
    }


    /**
     * Update the informations of the user specified by his username from a POST request
     */
    function editInfo($user) {

        if (isset ($_POST ['submit'])) {
            $newUsername = trim(strip_tags($_POST['username']));
            $newFirstName = trim(strip_tags($_POST['firstname']));
            $newLastName = trim(strip_tags($_POST['lastname']));
            $newEmail = trim(strip_tags($_POST['email']));

            if(!empty($_POST['username']) AND !empty($_POST['email']) AND !empty($_POST['firstname'] AND !empty($_POST['lastname']))) {

                if(strlen($newUsername) <= 100 && strlen($newFirstName) <= 100 && strlen($newLastName) <= 100) {

                    if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)){

                        $bdd = dbConnect();
                        $reqmail = $bdd->prepare(
                            "SELECT * 
                                FROM user 
                                WHERE email = ?"
                        );
                        $reqmail->execute(array($newEmail));

                        if ($reqmail->rowCount() > 0){
                            $result = $reqmail->fetch(PDO::FETCH_ASSOC);
                            if ($result['username'] == $user) // We can replace its old mail with the same one
                                $mailexist = 0;
                            else
                                $mailexist = 1;
                        }

                        $requsername = $bdd->prepare(
                            "SELECT * 
                                FROM user 
                                WHERE username = ?"
                        );
                        $requsername->execute(array($newUsername));

                        if ($requsername->rowCount() > 0){
                            $result = $requsername->fetch(PDO::FETCH_ASSOC);
                            if ($result['username'] == $user) // We can replace its old username with the same one
                                $usernameexist = 0;
                            else
                                $usernameexist = 1;
                        }

                        if($mailexist == 0) {
                            if($usernameexist == 0) {
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
                                }
                                catch(PDOException $e) {
                                    echo $e . "<br>" . $e->getMessage();
                                }
                                return 0;

                            } else
                                return -3; // Username already used
                        } else
                            return -2; // Mail already used
                    }
                }
            }
        }

        return -1;

    }

?>
