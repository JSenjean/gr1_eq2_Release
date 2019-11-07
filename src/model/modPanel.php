<?php

    /**
     * Return all the users with a specified role from the database
     */
    function getAllUsers($role){  
        try{
            $bdd = dbConnect();
            $stmt = $bdd->prepare("SELECT * FROM user WHERE role=:r");
            $stmt->execute(array(
                'r' => $role,
            ));
            return $stmt;
        }
        catch(PDOException $e){
            echo  "<br>" . $e->getMessage();
        }   
    }


    /**
     * Modify the role of a specified user the newrole
     * Only usable if the one who make the change have a higher rank than the specified user
     */
    function changeUserRole($user, $newrole){
        if ($_SESSION['role'] != 'user' && $user != $_SESSION['username']){
            $bdd = dbConnect();
            $stmt = $bdd->prepare("SELECT * FROM user WHERE username=:user"); 
            $stmt->execute(array(
                'user' => $user,
            ));
            $rows = $stmt->rowCount();
            if ($rows != 0){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if (($_SESSION['role'] == "admin" && $result["role"] != 'admin') || ($result["role"] == "user" && $newrole != "admin")){
                    try{
                        $stmt = $bdd->prepare("UPDATE user SET role=:newrole WHERE username=:user");
                        $stmt->execute(array(
                            'newrole' => $newrole,
                            'user' => $user
                        ));
                    }
                    catch(PDOException $e){
                        echo  "<br>" . $e->getMessage();
                    } 
                }
            }
        }
    }


    /**
     * Delete the specified user
     * Only usable if the one who make the delete have a higher rank than the specified user
     */
    function deleteUser($user){
        if (($_SESSION['role'] == 'admin') && ($_SESSION['username'] != $user)){ // Don't delete yourself
            $bdd = dbConnect();
            $stmt = $bdd->prepare("SELECT * FROM user WHERE username=:user"); 
            $stmt->execute(array(
                'user' => $user,
            ));
            $id = $bdd->prepare("SELECT id FROM user WHERE username=:user");
            $id->execute(array(
                'user' => $user
            ));
            $rows = $id->rowCount();
            if ($rows != 0){
                $idUser = $id->fetch(PDO::FETCH_ASSOC);
                $rows = $stmt->rowCount();
                if ($rows != 0){
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($result["role"] != 'admin' && $result["role"] != $_SESSION['role'] ){ //Don't delete the admins
                        try{
                            $stmt = $bdd->prepare("DELETE FROM user WHERE username=:user");
                            $stmt->execute(array(
                                'user' => $user,
                            ));
                            return 0;
                        }
                        catch(PDOException $e){
                            echo  "<br>" . $e->getMessage();
                        } 
                    }
                }
            }
        }
        return -1;  
    }

?>