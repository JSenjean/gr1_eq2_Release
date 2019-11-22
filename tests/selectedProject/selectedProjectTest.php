<?php

require_once "src/model/projects.php";
require_once "src/model/selectedProject.php";
require_once "tests/dbConnectTest.php";
use PHPUnit\Framework\TestCase;

Class SelectedProjectTest extends TestCase 
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
        create_new_project($bdd->lastInsertId(), "ProjectTestSelected", "desc", 1);

        $req = $bdd->prepare('INSERT INTO user(username, first_name, last_name, password, email, role) VALUES(:username, :firstName, :lastName, :password, :email, :role)');
        $req->execute(array(
                                        'username' => "user2",
                                        'firstName' => "user2",
                                        'lastName' => "user2",
                                        'password' => "user2",
                                        'email' => "user2@user2.fr",
                                        'role' => 'user',
                                    ));
        $req = $bdd->prepare('INSERT INTO project_member(role, project_id, user_id) VALUES(:role, :project_id, :user_id)');
        $req->execute(array(
            'role' => "member",
            'project_id' => 1,
            'user_id' => $bdd->lastInsertId()
        ));
    }

    public function test_get_project_master()
    {
        clear_Database();
        $this->init();

        $stmt = get_project_master(1);
        $this->assertEquals(1,$stmt->rowCount());

        $master = $stmt->fetchAll();
	
        $this->assertEquals($master[0]['username'], 'user1');
        $this->assertEquals($master[0]['first_name'], 'user1');
        $this->assertEquals($master[0]['last_name'], 'user1');
        $this->assertEquals($master[0]['password'], 'user1');
        $this->assertEquals($master[0]['email'], 'user1@user1.fr');
        $this->assertEquals($master[0]['role'], 'master');
    }

    /**
     * @depends test_get_project_master
     */
    public function test_get_all_project_members()
    {
        $stmt = get_all_project_members(1);
        $this->assertEquals(1,$stmt->rowCount());

        $member = $stmt->fetchAll();
        $this->assertEquals($member[0]['username'], 'user2');
        $this->assertEquals($member[0]['first_name'], 'user2');
        $this->assertEquals($member[0]['last_name'], 'user2');
        $this->assertEquals($member[0]['password'], 'user2');
        $this->assertEquals($member[0]['email'], 'user2@user2.fr');
        $this->assertEquals($member[0]['role'], 'member');
    }

    /**
     * @depends test_get_project_master
     */
    public function test_get_project_by_id()
    {
        $stmt = get_project_by_id(1);
        $this->assertEquals(1,$stmt->rowCount());

        $projectInfo = $stmt->fetchAll();
        $this->assertEquals($projectInfo[0]['name'], 'ProjectTestSelected');
        $this->assertEquals($projectInfo[0]['description'], 'desc');
        $this->assertEquals($projectInfo[0]['visibility'], 1);
    }

    /**
     * @depends test_get_project_master
     */
    public function test_is_master()
    {
        $this->assertEquals(is_master(1,1), true);
    }

    /**
     * @depends test_get_project_master
     */
    public function test_is_member()
    {
        $this->assertEquals(is_member(2,1), true);
    }

    /**
     * @depends test_get_project_master
     * @depends test_get_all_project_members
     * @depends test_get_project_by_id
     * @depends test_is_master
     * @depends test_is_member
     */
    public function deleteMember()
    {
        deleteMember(1,2);

        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT *
                FROM project_member
                WHERE role='member'"
        );
        $stmt->execute();
        
        $this->assertEquals(0,$stmt->rowCount());
    }
}
