<?php

session_start();
if (!isset($_SESSION['username'])) {
    return;
}

function dbConnect()
{
    $config = parse_ini_file('config.ini');
    return new PDO("mysql:host=" . $config['servername'] . ";dbname=" . $config['dbname'] . ";charset=utf8", $config['username'], $config['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
     
}


function checkConnection()
{
    if (!isset($_SESSION["id"])) {
        return false;
    }
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare("SELECT * FROM user WHERE id=:id");
        $stmt->execute(
            array(
            'id' => $_SESSION['id']
            )
        );
        return ($stmt->rowCount() > 0);
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
    return false;
}
