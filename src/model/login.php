<?php

    if (!isset($_SESSION)) {
        session_start();
    }


    /**
     * Log in with the informations of a POST request
     * The user need to be verified to log in
     */
    function login() {
        if (isset ($_POST ['submit'])) {
            $login = $_POST['login'];
            $password = sha1($_POST['password']);

            if ($login && $password) {
                try {
                    $bdd = dbConnect();
                    $stmt = $bdd->prepare("SELECT * FROM user WHERE :login IN (username, email) AND password=:password ");
                    $stmt->execute(array(
                        ':login' => $login,
                        ':password' => $password,
                       
                    ));
                    $rows = $stmt->rowCount();
                    if ($rows != 0) {
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $_SESSION['username'] = $result ["username"];
                        $_SESSION['id'] = $result ["id"];
                        $_SESSION['role'] = $result ["role"];
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
        }
    }

?>