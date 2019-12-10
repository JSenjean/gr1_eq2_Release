<?php

function dbConnect()
{
    $config = parse_ini_file('configTest.ini');
    return new PDO("mysql:host=" . $config['servername'] . ";dbname=" . $config['dbname'] . ";charset=utf8", $config['username'], $config['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

function clear_Database()
{
    //clean user
    $bdd = dbConnect();
    $req = $bdd->prepare("DELETE FROM user");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE user AUTO_INCREMENT = 1");
    $req->execute();

    //clean inside_project_role
    $req = $bdd->prepare("DELETE FROM inside_project_role");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE inside_project_role AUTO_INCREMENT = 1");
    $req->execute();

    //clean project
    $req = $bdd->prepare("DELETE FROM project");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE project AUTO_INCREMENT = 1");
    $req->execute();

    //clean project_member
    $req = $bdd->prepare("DELETE FROM project_member");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE project_member AUTO_INCREMENT = 1");
    $req->execute();

    //clean user_story
    $req = $bdd->prepare("DELETE FROM user_story");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE user_story AUTO_INCREMENT = 1");
    $req->execute();

    //clean doc_section
    $req = $bdd->prepare("DELETE FROM doc_section");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE doc_section AUTO_INCREMENT = 1");
    $req->execute();

    //clean faq
    $req = $bdd->prepare("DELETE FROM faq");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE faq AUTO_INCREMENT = 1");
    $req->execute();

    //clean faq_category
    $req = $bdd->prepare("DELETE FROM faq_category");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE faq_category AUTO_INCREMENT = 1");
    $req->execute();
    
    //clean inside_sprint_us
    $req = $bdd->prepare("DELETE FROM inside_sprint_us");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE inside_sprint_us AUTO_INCREMENT = 1");
    $req->execute();

    //clean project_invitation
    $req = $bdd->prepare("DELETE FROM project_invitation");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE project_invitation AUTO_INCREMENT = 1");
    $req->execute();

    //clean task
    $req = $bdd->prepare("DELETE FROM task");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE task AUTO_INCREMENT = 1");
    $req->execute();

    //clean test
    $req = $bdd->prepare("DELETE FROM test");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE test AUTO_INCREMENT = 1");
    $req->execute();

    //clean sprint
    $req = $bdd->prepare("DELETE FROM sprint");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE sprint AUTO_INCREMENT = 1");
    $req->execute();

    //clean inside_sprint_task_us
    $req = $bdd->prepare("DELETE FROM inside_sprint_task_us");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE inside_sprint_task_us AUTO_INCREMENT = 1");
    $req->execute();

    //clean project_commit
    $req = $bdd->prepare("DELETE FROM project_commit");
    $req->execute();
    $req = $bdd->prepare("ALTER TABLE project_commit AUTO_INCREMENT = 1");
    $req->execute();
}
