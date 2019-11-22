<?php


require_once "src/model/backlog.php";
require_once "src/model/projects.php";
require_once "tests/dbConnectTest.php";
use PHPUnit\Framework\TestCase;

class BacklogTest extends TestCase
{
    public function prepare_user_and_project()
    {
	
        $bdd=dbConnect();
        $req = $bdd->prepare('INSERT INTO user(username, first_name, last_name, password, email, role) VALUES(:username, :firstName, :lastName, :password, :email, :role)');
        $req->execute(array(
                                        'username' => "user1",
                                        'firstName' => "user1",
                                        'lastName' => "user1",
                                        'password' => "user1",
                                        'email' => "user1@user1.fr",
                                        'role' => 'user',
                                    ));

        create_new_project(1, "projetTestBacklog", "une description", 1);
    }
    


    
    public function test_add_inside_project_role()
    {
        clear_Database();
        $this->prepare_user_and_project();
        
        add_inside_project_role(1,"name","description");

        $bdd=dbConnect();

        $stmt = $bdd->prepare(
            "SELECT *
                FROM inside_project_role
                WHERE project_id=1"
        );
        $stmt->execute();
        $this->assertEquals(1,$stmt->rowCount());

        $roleInserted = $stmt->fetchAll();
        $this->assertEquals(8,sizeof($roleInserted[0]));
        $this->assertEquals(1,$roleInserted[0]["id"]);
        $this->assertEquals(1,$roleInserted[0]["project_id"]);
        $this->assertEquals("name",$roleInserted[0]["name"]);
        $this->assertEquals("description",$roleInserted[0]["description"]);



        //$this->clear_Database();

        //create_new_project();
    }

    /*
        @depends test_add_inside_project_role
    */
    public function test_get_all_inside_project_role()
    {
        
        add_inside_project_role(1,"name2","description2");

        $stmt=get_all_inside_project_role(1);
        $this->assertEquals(2,$stmt->rowCount());
        $rolesToVerify=$stmt->fetchAll();

        $this->assertEquals(1,$rolesToVerify[0]["id"]);
        $this->assertEquals(1,$rolesToVerify[0]["project_id"]);
        $this->assertEquals("name",$rolesToVerify[0]["name"]);
        $this->assertEquals("description",$rolesToVerify[0]["description"]);

        $this->assertEquals(2,$rolesToVerify[1]["id"]);
        $this->assertEquals(1,$rolesToVerify[1]["project_id"]);
        $this->assertEquals("name2",$rolesToVerify[1]["name"]);
        $this->assertEquals("description2",$rolesToVerify[1]["description"]);


    }
    /*
        @depends test_get_all_inside_project_role
    */
    public function test_modify_inside_project_role()
    {
        
        modify_inside_project_role(2,"nameModify","descriptionModify");

        $bdd=dbConnect();

        $stmt = $bdd->prepare(
            "SELECT *
                FROM inside_project_role
                WHERE id=2"
        );


        $stmt->execute();
        $this->assertEquals(1,$stmt->rowCount());
        $roleToVerify=$stmt->fetchAll();


        $this->assertEquals("nameModify",$roleToVerify[0]["name"]);
        $this->assertEquals("descriptionModify",$roleToVerify[0]["description"]);


    }

 /*
        @depends test_get_all_inside_project_role
 */
 public function test_remove_by_role_id()
    {
        
        remove_by_role_id(2);

        $bdd=dbConnect();

        $stmt = $bdd->prepare(
            "SELECT *
                FROM inside_project_role
                WHERE id=2"
        );


        $stmt->execute();
        $this->assertEquals(0,$stmt->rowCount());



    }

/*
   @depends test_add_inside_project_role
*/
public function test_add_inside_project_US()
    {

	add_inside_project_US(1, "US1", 1, "Ican", "SoThat","1","low",true);
        

        $bdd=dbConnect();

        $stmt = $bdd->prepare(
            "SELECT *
                FROM user_story
                WHERE id=1"
        );


        $stmt->execute();
        $this->assertEquals(1,$stmt->rowCount());


	$USToVerify=$stmt->fetchAll();


        $this->assertEquals(1,$USToVerify[0]["id"]);
        $this->assertEquals("US1",$USToVerify[0]["name"]);
 	$this->assertEquals(1,$USToVerify[0]["project_id"]);
 	$this->assertEquals("Ican",$USToVerify[0]["i_can"]);
	$this->assertEquals("SoThat",$USToVerify[0]["so_that"]);
 	$this->assertEquals("1",$USToVerify[0]["effort"]);
	$this->assertEquals("low",$USToVerify[0]["priority"]);
 	$this->assertEquals(1,$USToVerify[0]["done"]);




    }
/*
   @depends test_add_inside_project_US
*/
public function test_remove_US_by_id()
    {

	add_inside_project_US(1, "US2", 1, "Ican", "SoThat","1","low",true);
        

        

        
	remove_US_by_id(2);
	$bdd=dbConnect();

        $stmt = $bdd->prepare(
            "SELECT *
                FROM user_story
                WHERE id=2"
        );
	$stmt->execute();	
        $this->assertEquals(0,$stmt->rowCount());





    }

public function test_modify_inside_project_US()
    {

	modify_inside_project_US(1, 1, "US1", 1, "Icanmodify", "SoThatmodify","1","low",true);
        

        $bdd=dbConnect();

        $stmt = $bdd->prepare(
            "SELECT *
                FROM user_story
                WHERE id=1"
        );


        $stmt->execute();
        $this->assertEquals(1,$stmt->rowCount());


	$USToVerify=$stmt->fetchAll();


        $this->assertEquals(1,$USToVerify[0]["id"]);
        $this->assertEquals("US1",$USToVerify[0]["name"]);
 	$this->assertEquals(1,$USToVerify[0]["project_id"]);
 	$this->assertEquals("Icanmodify",$USToVerify[0]["i_can"]);
	$this->assertEquals("SoThatmodify",$USToVerify[0]["so_that"]);
 	$this->assertEquals("1",$USToVerify[0]["effort"]);
	$this->assertEquals("low",$USToVerify[0]["priority"]);
 	$this->assertEquals(1,$USToVerify[0]["done"]);




    }





}
