<?php


require_once "src/model/backlog.php";
require_once "src/model/projects.php";
require_once "tests/dbConnectTest.php";

use PHPUnit\Framework\TestCase;

class ProjectsTest extends TestCase
{
    public function prepare_users()
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




    public function test_create_new_project()
    {
        clear_Database();
        $this->prepare_users();

        create_new_project(1, "projetTest", "une description", 1);

        $bdd = dbConnect();

        $stmt = $bdd->prepare(
            "SELECT *
                FROM project"
        );


        $stmt->execute();
        $this->assertEquals(1, $stmt->rowCount());

        $projectsInserted = $stmt->fetchAll();
        $this->assertEquals(10, sizeof($projectsInserted[0]));
        $this->assertEquals(1, $projectsInserted[0]["id"]);
        $this->assertEquals("projetTest", $projectsInserted[0]["name"]);
        $this->assertEquals("une description", $projectsInserted[0]["description"]);
        $this->assertEquals(1, $projectsInserted[0]["visibility"]);

        $stmt = $bdd->prepare(
            "SELECT *
                FROM project_member
                WHERE project_id=1 "
        );


        $stmt->execute();

        $this->assertEquals(1, $stmt->rowCount());

        $memberInserted = $stmt->fetchAll();
        $this->assertEquals(8, sizeof($memberInserted[0]));
        $this->assertEquals(1, $memberInserted[0]["id"]);
        $this->assertEquals(1, $memberInserted[0]["project_id"]);
        $this->assertEquals(1, $memberInserted[0]["user_id"]);
        $this->assertEquals("master", $memberInserted[0]["role"]);



        //$this->clear_Database();

        //create_new_project();
    }


    /*
    @depends test_create_new_project
    */
    public function test_associat_project_and_user()
    {
        associat_project_and_user(2, 1, "member");
        $bdd = dbConnect();

        $stmt = $bdd->prepare(
            "SELECT *
                FROM project_member
                WHERE project_id=1 "
        );


        $stmt->execute();

        $this->assertEquals(2, $stmt->rowCount());

        $memberInserted = $stmt->fetchAll();
        $this->assertEquals(8, sizeof($memberInserted[1]));
        $this->assertEquals(2, $memberInserted[1]["id"]);
        $this->assertEquals(1, $memberInserted[1]["project_id"]);
        $this->assertEquals(2, $memberInserted[1]["user_id"]);
        $this->assertEquals("member", $memberInserted[1]["role"]);
    }
    /*
    @depends test_associat_project_and_user
    */
    public function test_leave_a_project()
    {
        leave_a_project(2, 1);
        $bdd = dbConnect();

        $stmt = $bdd->prepare(
            "SELECT *
                FROM project_member
                WHERE user_id=2 "
        );


        $stmt->execute();

        $this->assertEquals(0, $stmt->rowCount());
    }
    /*
    @depends test_leave_a_project
    */
    public function test_get_all_project_without_user_id()
    {
        $projectsWithoutUserId = get_all_project_without_user_id(2);
        $this->assertEquals(1, $projectsWithoutUserId->rowCount());
    }
    /*
    @depends test_get_all_project_without_user_id
    */
    public function test_add_invitation_request()
    {
        add_invitation_request(2, 1);
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT *
                FROM project_invitation"
        );
        $stmt->execute();

        $this->assertEquals(1, $stmt->rowCount());


        $invitations = $stmt->fetchAll();
        $this->assertEquals(8, sizeof($invitations[0]));
        $this->assertEquals(1, $invitations[0]["id"]);
        $this->assertEquals(1, $invitations[0]["project_id"]);
        $this->assertEquals(2, $invitations[0]["user_id"]);
        $this->assertEquals(1, $invitations[0]["request"]);
    }

    /*
    @depends test_add_invitation_request
    */
    public function test_get_all_project_by_user_id()
    {
        $projects = get_all_project_by_user_id(1);

        $this->assertEquals(1, $projects->rowCount());
        $projects = $projects->fetchall();
        $this->assertEquals(10, sizeof($projects[0]));
        $this->assertEquals(1, $projects[0]["id"]);
        $this->assertEquals("projetTest", $projects[0]["name"]);
        $this->assertEquals("une description", $projects[0]["description"]);
        $this->assertEquals("master", $projects[0]["role"]);
        $this->assertEquals(1, $projects[0]["visibility"]);
    }

    /*
    @depends test_get_all_project_by_user_id
    */
    public function test_remove_by_project_id()
    {
         remove_by_project_id(1);

         $bdd = dbConnect();

         $stmt = $bdd->prepare(
             "SELECT *
                 FROM project"
         );
         $stmt->execute();

         $this->assertEquals(0, $stmt->rowCount());
    }
}
