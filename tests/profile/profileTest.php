<?php

require_once "src/model/projects.php";
require_once "src/model/profile.php";
require_once "tests/dbConnectTest.php";
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase 
{
    public function init()
    {
        $bdd = dbConnect();
        $req = $bdd->prepare('INSERT INTO user(username, first_name, last_name, password, email, role) VALUES(:username, :firstName, :lastName, :password, :email, :role)');
        $req->execute(array(
            'username' => "user1",
            'firstName' => "user1",
            'lastName' => "user1",
            'password' => "user1",
            'email' => "user1@user1.fr",
            'role' => 'user',
        ));
        create_new_project($bdd->lastInsertId(), "ProjectTestSprint", "desc", 1);
        $req = $bdd->prepare('INSERT INTO user(username, first_name, last_name, password, email, role) VALUES(:username, :firstName, :lastName, :password, :email, :role)');
        $req->execute(array(
            'username' => "user2",
            'firstName' => "user2",
            'lastName' => "user2",
            'password' => "user2",
            'email' => "user2@user2.fr",
            'role' => 'user',
        ));
    }

    public function test_getUserProfile() 
    {
        clear_Database();
        $this->init();

        $profile = getUserProfile("user1");
        
        $this->assertEquals($profile['username'], "user1");
        $this->assertEquals($profile['first_name'], "user1");
        $this->assertEquals($profile['last_name'], "user1");
        $this->assertEquals($profile['password'], "user1");
        $this->assertEquals($profile['email'], "user1@user1.fr");
        $this->assertEquals($profile['role'], "user");
        $this->assertEquals($profile['id'], 1);
    }

    /**
     * @depends test_getUserProfile
     */
    public function test_getUserNbParticipation()
    {
        $part = getUserNbParticipation(1);
        
        $this->assertEquals($part[0], 1);
    }

    /**
     * @depends test_getUserProfile
     */
    public function test_getUserInvitationsOrRequest() 
    {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "INSERT INTO
                project_invitation(user_id, project_id, request) VALUES (:user_id, :project_id, :request)"
        );
        $stmt->execute(array(
            'user_id' => 2,
            'project_id' => 1,
            'request' => 1
        ));

        $inv = getUserInvitationsOrRequest(1, 2)->fetchAll();
        $this->assertEquals($inv[0]['id'], 1);
        $this->assertEquals($inv[0]['user_id'], 2);
        $this->assertEquals($inv[0]['request'], 1);
        $this->assertEquals($inv[0]['name'], 'ProjectTestSprint');

        $stmt = $bdd->prepare(
            "UPDATE project_invitation
            SET request=:request
            WHERE id=:id"
        );
        $stmt->execute(array(
            'id' => 1,
            'request' => 0
        ));

        $inv = getUserInvitationsOrRequest(0, 2)->fetchAll();
        $this->assertEquals($inv[0]['id'], 1);
        $this->assertEquals($inv[0]['user_id'], 2);
        $this->assertEquals($inv[0]['request'], 0);
        $this->assertEquals($inv[0]['name'], 'ProjectTestSprint');
    }

    /**
     * @depends test_getUserProfile
     * @depends test_getUserNbParticipation
     * @depends test_getUserInvitationsOrRequest
     */
    public function test_deleteAccount()
    {
        deleteAccount("user2");

        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT * 
            FROM user
            where id=:user_id"
        );
        $stmt->execute(array(
            'user_id' => 2
        ));

        $this->assertEquals(0, $stmt->rowCount());
    }
}
