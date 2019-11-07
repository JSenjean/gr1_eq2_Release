<?php

    /**
     * Register a new user in the database from a POST request
     * Return a code depending on the success or the errors of the registration
     */
    function signup() {

        if (isset ($_POST ['submit'])) {

            $username = trim(strip_tags($_POST['username']));
            $password = sha1($_POST['password']);
            $password2 = sha1($_POST['password2']);
            $firstName = trim(strip_tags($_POST['firstname']));
            $lastName = trim(strip_tags($_POST['lastname']));
            $email = trim(strip_tags($_POST['email']));
            $email2 = trim(strip_tags($_POST['email2']));

            if(!empty($_POST['username']) AND !empty($_POST['email']) 
                AND !empty($_POST['email2']) 
                AND !empty($_POST['password']) 
                AND !empty($_POST['password2'] 
                AND !empty($_POST['firstname'] 
                AND !empty($_POST['lastname'])))) {
                
                if(strlen($username) <= 50 && strlen($firstName) <= 50 && strlen($lastName) <= 75) {
                    
                    if ($email == $email2 && filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $bdd = dbConnect();
                        $reqmail = $bdd->prepare("SELECT * FROM user WHERE email = ?");
                        $reqmail->execute(array($email));
                        $mailexist = $reqmail->rowCount();
                        $requsername = $bdd->prepare("SELECT * FROM user WHERE username = ?");
                        $requsername->execute(array($username));
                        $usernameexist = $requsername->rowCount();
                        
                        if($mailexist == 0)
                            if($usernameexist == 0)
                                if ($password == $password2){
                                    $rand128 = bin2hex(openssl_random_pseudo_bytes(16)); //Code d'identification 128bits
                                    try {
                                        $req = $bdd->prepare('INSERT INTO user(username, first_name, last_name, password, email, role) VALUES(:username, :firstName, :lastName, :password, :email, :role)');
                                        $req->execute(array(
                                            'username' => $username,
                                            'firstName' => $firstName,
                                            'lastName' => $lastName,
                                            'password' => $password,
                                            'email' => $email,
                                            'role' => 'user',
                                        ));
                                    } 
                                    catch(PDOException $e) {
                                        echo "<br>" . $e->getMessage();
                                    }
                                    return $rand128; 
                                }
                                else
                                    return -4; // Passwords are not identical
                            else
                                return -3; // Username already used
                        else
                            return -2; // Mail already used
                    }
                } 
            } 
        }
        return -1;
    }

?>