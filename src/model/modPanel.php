<?php
/** Mod Panel
 *  ---------
 *  @file
 *  @brief Various functions to enable administrator
 *  monitoring from the mod panel page. Mainly CRUD functions
 */


/**
 * @brief Get all the users in the database from a specified role
 * @param role The role we want to get all the users from
 * @return users All the users that have the specified role
 */
function getAllUsers($role)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare("SELECT * FROM user WHERE role=:r");
        $stmt->execute(
            array(
            'r' => $role,
            )
        );
        return $stmt;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
}


/**
 * @brief Change the role of a given user to match the new given role
 * Only possible in the case of an administrator editing the role of a regular user
 * @param user The username of the user that will change role
 * @param newrole The new role that will be given to this user
 * 
 */
function changeUserRole($user, $newrole)
{
    if ($_SESSION['role'] != 'user' && $user != $_SESSION['username']) {
        $bdd = dbConnect();
        $stmt = $bdd->prepare("SELECT * FROM user WHERE username=:user");
        $stmt->execute(
            array(
            'user' => $user,
            )
        );
        $rows = $stmt->rowCount();
        if ($rows != 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (($_SESSION['role'] == "admin" && $result["role"] != 'admin') || ($result["role"] == "user" && $newrole != "admin")) {
                try {
                    $stmt = $bdd->prepare(
                        "UPDATE user 
                            SET role=:newrole 
                            WHERE username=:user"
                    );
                    $stmt->execute(
                        array(
                        'newrole' => $newrole,
                        'user' => $user
                        )
                    );
                } catch (PDOException $e) {
                    echo  "<br>" . $e->getMessage();
                }
            }
        }
    }
}


/**
 * @brief Delete a given user from its username
 * Only possible in the case of an administrator deleting a regular user
 * @param user The username of the user that will be deleted
 */
function deleteUser($user)
{
    if (($_SESSION['role'] == 'admin') && ($_SESSION['username'] != $user)) { // Don't delete yourself
        $bdd = dbConnect();
        $stmt = $bdd->prepare("SELECT * FROM user WHERE username=:user");
        $stmt->execute(
            array(
            'user' => $user,
            )
        );
        $id = $bdd->prepare("SELECT id FROM user WHERE username=:user");
        $id->execute(
            array(
            'user' => $user
            )
        );
        $rows = $id->rowCount();
        if ($rows != 0) {
            $rows = $stmt->rowCount();
            if ($rows != 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result["role"] != 'admin' && $result["role"] != $_SESSION['role']) { //Don't delete the admins
                    try {
                        $stmt = $bdd->prepare(
                            "DELETE 
                                FROM user 
                                WHERE username=:user"
                        );
                        $stmt->execute(
                            array(
                            'user' => $user,
                            )
                        );
                        return 0;
                    } catch (PDOException $e) {
                        echo  "<br>" . $e->getMessage();
                    }
                }
            }
        }
    }
    return -1;
}
