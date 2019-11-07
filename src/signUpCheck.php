<?php

include 'model/index.php';

// Check if the username is already used
if (isset($_POST['action']) && $_POST['action'] == 'usrname') {
    $usrname = $_POST['usrname'];
    $bdd = dbConnect();
    $stmt = $bdd->prepare("SELECT * FROM user WHERE username=:username");
    $stmt->execute(array(
        'username' => $usrname
    ));
    echo $stmt->rowCount();
}

// Check if the mail address is already used
else if (isset($_POST['action']) && $_POST['action'] == 'mail') {
    $mail = $_POST['mail'];
    $bdd = dbConnect();
    $stmt = $bdd->prepare("SELECT * FROM user WHERE email=:mail");
    $stmt->execute(array(
        'mail' => $mail
    ));
    echo $stmt->rowCount();
}
