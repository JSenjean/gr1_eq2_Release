<?php

require_once "src/model/projects.php";
require_once "src/model/sprints.php";
require_once "tests/dbConnectTest.php";
use PHPUnit\Framework\TestCase;

class SprintTest extends TestCase 
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
    }

    public function test_create_new_sprint() 
    {   
        clear_Database();
        $this->init();

        $name = "Sprint1";
        $start = "1999-01-01";
        $end = "2000-01-01";
        $projectId = 1;
        create_new_sprint($name, $start, $end, $projectId);
        
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT *
                FROM sprint
                WHERE project_id=1"
        );
        $stmt->execute();

        $this->assertEquals(1,$stmt->rowCount());
        $sprint = $stmt->fetchAll();
        $this->assertEquals($sprint[0]['name'], $name);
        $this->assertEquals($sprint[0]['start'], $start);
        $this->assertEquals($sprint[0]['end'], $end);

        return $sprint[0]['id'];
    }

    /**
     * @depends test_create_new_sprint
     */
    public function test_get_all_project_members_and_master() {
        $stmt = get_all_project_members_and_master(1);
        $this->assertEquals(1, $stmt->rowCount());

        $member = $stmt->fetchAll();

        $this->assertEquals($member[0]['username'], "user1");
        $this->assertEquals($member[0]['id'], 1);

        return $member[0]['id'];
    }

    /**
     * @depends test_create_new_sprint
     */
    public function test_get_all_sprint() {
        $name = "Sprint1";
        $start = "1999-01-01";
        $end = "2000-01-01";
        $projectId = 1;
        create_new_sprint($name, $start, $end, $projectId);

        $stmt = get_all_sprints($projectId);
        $this->assertEquals(2,$stmt->rowCount());

        $allSprint = $stmt->fetchAll();
        foreach($allSprint as $sprint) {
            $this->assertEquals($sprint['name'], $name);
            $this->assertEquals($sprint['start'], $start);
            $this->assertEquals($sprint['end'], $end);
        }
    }
    /**
     * @depends test_create_new_sprint
     * @depends test_get_all_project_members_and_master
     */
    public function test_create_new_task($Sid, $Mid) {
        $name = "task1";
        $description = "desc1";
        $dod = "dod1";
        $predecessor = "pred1";
        $time = "1";
        create_new_task($name, $description, $dod, $predecessor, $time, $Sid, $Mid);

        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT *
                FROM task"
        );
        $stmt->execute();
        $this->assertEquals(1,$stmt->rowCount());

        $task = $stmt->fetchAll();
        $this->assertEquals($task[0]['name'], $name);
        $this->assertEquals($task[0]['member_id'], $Mid);
        $this->assertEquals($task[0]['sprint_id'], $Sid);
        $this->assertEquals($task[0]['predecessor'], $predecessor);
        $this->assertEquals($task[0]['dod'], $dod);
        $this->assertEquals($task[0]['time'], $time);
        $this->assertEquals($task[0]['description'], $description);
        $this->assertEquals($task[0]['state'], "todo");

        return $task[0]['id'];
    }

    /**
     * @depends test_create_new_task
     */
    public function test_update_task($Tid) {
        $name = "task change";
        $description = "desc change";
        $dod = "dod change";
        $predecessor = "pred change";
        $time = "2.5";
        $memberId = null;
        update_task($Tid, $name, $description, $dod, $predecessor, $time, $memberId);

        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT *
                FROM task"
        );
        $stmt->execute();
        $this->assertEquals(1,$stmt->rowCount());

        $task = $stmt->fetchAll();
        $this->assertEquals($task[0]['name'], $name);
        $this->assertEquals($task[0]['predecessor'], $predecessor);
        $this->assertEquals($task[0]['dod'], $dod);
        $this->assertEquals($task[0]['time'], $time);
        $this->assertEquals($task[0]['description'], $description);
        $this->assertEquals($task[0]['state'], "todo");
    }

    /**
     * @depends test_create_new_sprint
     * @depends test_update_task
     */
    public function test_get_all_task_inside_sprint($Sid)
    {
        $stmt = get_all_task_inside_sprint($Sid);
        $this->assertEquals(1,$stmt->rowCount());

        $name = "task change";
        $description = "desc change";
        $dod = "dod change";
        $predecessor = "pred change";
        $time = "2.5";
        $task = $stmt->fetchAll();
        $this->assertEquals($task[0]['name'], $name);
        $this->assertEquals($task[0]['predecessor'], $predecessor);
        $this->assertEquals($task[0]['dod'], $dod);
        $this->assertEquals($task[0]['time'], $time);
        $this->assertEquals($task[0]['description'], $description);
        $this->assertEquals($task[0]['state'], "todo");
    }

    /**
     * @depends test_create_new_task
     * @depends test_create_new_sprint
     * @depends test_get_all_task_inside_sprint
     */
    public function test_switch_task_state($Tid, $Sid) 
    {   
        $newState = "done";
        switch_task_state($Tid, $newState);
        $task = get_all_task_inside_sprint($Sid)->fetchAll();

        $this->assertEquals($task[0]['state'], $newState);
    }

    /**
     * @depends test_create_new_task
     * @depends test_create_new_sprint
     * @depends test_switch_task_state
     * @depends test_get_all_task_inside_sprint
     */
    public function test_remove_task($Tid, $Sid)
    {
        remove_task($Tid);
        $stmt = get_all_task_inside_sprint($Sid);

        $this->assertEquals(0,$stmt->rowCount());
    }

    /**
     * @depends test_create_new_sprint
     * @depends test_get_all_sprint
     * @depends test_remove_task
     */
    public function test_remove_sprint_by_id($sprintId)
    {
        delete_sprint_by_id($sprintId);
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
            "SELECT *
                FROM sprint"
        );
        $stmt->execute();
        
        $this->assertEquals(1,$stmt->rowCount());
    }

    public function test_add_sprint_background() {
        $longTimeAgo = "1999-01-01";
        $inTheFuture = "2999-01-01";

        $this->assertEquals(add_sprint_background($longTimeAgo, $longTimeAgo), "bg-success");
        $this->assertEquals(add_sprint_background($longTimeAgo, $inTheFuture), "bg-danger");
        $this->assertEquals(add_sprint_background($inTheFuture, $inTheFuture), "bg-info");
    }
}