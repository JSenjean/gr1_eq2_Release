<?php
/** sprints
 *  -------
 *  @file
 *  @brief Various functions, who have for objectif to give all the necessary
 * for sprint controller you will find fonctions for
 * project user essentially CRUD function.
 */

/**
 * @brief This function return a list of all sprint with extra information(the number of us and the effort) of a given project
 * @param id the project id
 * @return The PDOStatement contening all the sprints or -1 if an exception occurs
 */
function get_all_sprints($projectId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "SELECT t1.id, t1.name, t1.start, t1.end, t2.efforts, t2.nbUS, t1.project_id
        FROM
        (SELECT * FROM sprint WHERE project_id =:projectId) t1
        LEFT JOIN
        (SELECT s.id, sum(case us.effort 
                when '1' then 1
                when '2' then 2
                when '3' then 3
                when '5' then 5
                when '8' then 8
                when '13' then 13
                when '21' then 21
                when '34' then 34
                else 0 END 
                ) as efforts, count(us.id) as nbUS
                  FROM sprint as s,inside_sprint_us as isu,user_story as us
                  WHERE isu.sprint_id = s.id and s.project_id =:projectId and us.id=isu.user_story_id
        group by s.id) t2
        ON (t1.id = t2.id)
        Order By start;
        "
    );
        $stmt->execute(array(':projectId' => $projectId));
        return $stmt;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
}

/**
 * @brief This function returns the bootstrap code of the background of a sprint according to its start date and end date
 * @param startDate the startDate of the sprint
 * @param endDate the endDate of the sprint
 * @return a string contening the html bootstrap code for the background color
 */
function add_sprint_background($startDate, $endDate)
{
    $curDate = new DateTime("now");
    $sDate = new DateTime($startDate);
    $eDate = new DateTime($endDate);
    $curDate->settime(0, 0);

    if ($eDate < $curDate) {
        return "bg-success";
    } elseif ($sDate <= $curDate && $eDate >= $curDate) {
        return "bg-danger";
    }
    return "bg-info";
}

/**
 * @brief This function returns the bootstrap code of the background of a sprint according to its start date and end date
 * @param startDate the startDate of the sprint
 * @param endDate the endDate of the sprint
 * @return a string contening the html bootstrap code for the background color
 */
function create_new_sprint($name, $start, $end, $projectId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "INSERT INTO
          sprint(end,start,name,project_id)
          VALUES(:end,:start,:name,:project_id)"
    );
        $stmt->execute(array(
        'end'   => $end,
        'start' => $start,
        'name'  => $name,
        ':project_id' => $projectId
    ));
        return 1;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
    return 1;
}

/**
 * @brief This function removes a sprint from the sprint table according to its identifier
 * @param sprintId the identifier of the sprint to be deleted
 * @return return 1 if success or -1 if an exception occurs
 */
function delete_sprint_by_id($sprintId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "DELETE FROM sprint
          WHERE id=:sprint_id"
    );
        $stmt->execute(array(
        'sprint_id' => $sprintId
    ));
        return 1;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
    return 1;
}

/**
 * @brief This function returns all members of a project including the project leader.
 * @param id the project id
 * @return The PDOStatement contening all the member and master of a project or -1 if an exception occurs
 */
function get_all_project_members_and_master($id)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "SELECT pm.id,u.username FROM project_member=pm, user=u
              WHERE pm.user_id=u.id and pm.project_id=:projectId"
    );
        $stmt->execute(array('projectId' => $id));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

/**
 * @brief This function allows you to create a task in a given sprint.Insert a line in the task table.
 * @param name the task name
 * @param description the description of the task
 * @param dod the definitrion of done  of the task
 * @param predecessor the predecessor task list of the task
 * @param time the time for finish the task
 * @param sprintId the sprint where to add the task
 * @param memberId the member that is reponsable to do the task
 * @return The id of the insertion on the table or -1 if ans exception occurs
 */
function create_new_task($name, $description, $dod, $predecessor, $time, $sprintId, $memberId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "INSERT INTO
          task(sprint_id, member_id, name, predecessor, description, dod, state, time, maquette)
          VALUES(:sprintId,:memberId,:name,:predecessor,:description,:dod,:state,:time,:maquette)"
    );
        $stmt->execute(array(
        'sprintId'    => $sprintId,
        'memberId'    => $memberId,
        'name'        => $name,
        'predecessor' => $predecessor,
        'description' => $description,
        'dod'         => $dod,
        'state'       => 'todo',
        'time'        => $time,
        'maquette'    => null
    ));
        return $bdd->lastInsertId();
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
        return -1;
    }
    return 1;
}

/**
 * @brief This function allows you to modify a given task.
 * @param name the new task name
 * @param description the new  description of the task
 * @param dod the new definitrion of done  of the task
 * @param predecessor the new predecessor task list of the task
 * @param time the new time for finish the task
 * @param sprintId the new sprint where to add the task
 * @param memberId the new member that is reponsable to do the task
 * @return The id of the modified task on the table or -1 if ans exception occurs
 */
function update_task($id, $name, $description, $dod, $predecessor, $time, $memberId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "UPDATE task
          SET name=:name, description=:description, member_id=:memberId, predecessor=:predecessor, dod=:dod, time=:time
          WHERE id=:id"
    );
        $stmt->execute(array(
        'memberId'    => $memberId,
        'name'        => $name,
        'predecessor' => $predecessor,
        'description' => $description,
        'dod'         => $dod,
        'time'        => $time,
        'id'          => $id
    ));
        return $id;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
    return -1;
}

/**
 * @brief This function allows you to return the complete list of tasks inside a sprint.
 * @param sprintId the sprint id
 * @return The PDOStatement contening all the task of a sprint or -1 if an exception occurs
 */
function get_all_task_inside_sprint($sprintId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "SELECT task.*
              FROM task
              WHERE task.sprint_id=:sprintId"
    );
        $stmt->execute(array('sprintId' => $sprintId));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

/**
 * @brief This function return the us linked to a task
 * @param taskId The task id
 * @return The PDOStatement contening the USs linked to the task
 */
function get_all_us_inside_task($taskId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "SELECT isu.* 
          FROM inside_sprint_us=isu, inside_sprint_task_us=ut 
          WHERE isu.id=ut.inside_sprint_us_id and ut.task_id=:taskId"
    );
        $stmt->execute(array('taskId' => $taskId));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

/**
 * @brief This function unlink USs to a given Task by deleting from the table inside_sprint_task_us
 * @param taskId the task id
 * @param allUSToUnlink Array composed of USs
 * @return Return -1 if an error occurs or 1 if it pass
 */
function unlink_us_from_task($taskId, $allUSToUnlink)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "DELETE FROM inside_sprint_task_us
          WHERE inside_sprint_task_us.task_id=:task_id and inside_sprint_task_us.inside_sprint_us_id=:us_id"
    );
        foreach ($allUSToUnlink as $us_id) {
            $stmt->execute(array(
        'task_id' => $taskId,
        'us_id'   => $us_id
        ));
        }
        return 1;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
    return -1;
}

/**
 * @brief This function USs to a specified task
 * @param taskId The task id
 * @param allUSToLink Array composed of USs
 * @return Return -1 if an error occurs or 1 if it pass
 */
function link_us_to_task($taskId, $allUSToLink)
{
    try {
        $bdd = dbConnect();

        $stmt = $bdd->prepare(
        "SELECT id FROM inside_sprint_us
            WHERE user_story_id=:us_id"
    );
        foreach ($allUSToLink as $us_id) {
            $stmt->execute(array(
        'us_id'   => $us_id
        ));

            $currentId = $stmt->fetchAll();
      
            $stmt2 = $bdd->prepare(
            "INSERT INTO inside_sprint_task_us(task_id, inside_sprint_us_id)
              VALUES(:task_id, :ius_id)"
        );
            $stmt2->execute(array(
        'task_id' => $taskId,
        'ius_id'  => $currentId[0]['id']
        ));
        }
        return 1;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
    return -1;
}

/**
 * @brief This function allows you to return the complete list of userstory inside a sprint.
 * @param sprintId the sprint id
 * @return The PDOStatement contening all the userstory of a sprint or -1 if an exception occurs
 */
function get_all_us_inside_sprint($sprintId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "SELECT t1.id, t1.name , t2.state, t2.nbTodo, t2.nbOnGoing, t2.nbDone ,t2.nbMaxTache
        FROM 
            (SELECT us.id , us.name
             FROM inside_sprint_us as isu,user_story as us 
             WHERE isu.sprint_id=:sprintId and us.id=isu.user_story_id) t1
        LEFT JOIN
            (SELECT us.id ,us.name,task.state,
                  sum( case state WHEN 'todo' THEN 1 ELSE 0 END) as nbTodo, 
                  sum( case state WHEN 'onGoing' THEN 1 ELSE 0 END) as nbOnGoing, 
                  sum( case state WHEN 'done' THEN 1 ELSE 0 END) as nbDone,
                  count(us.id) as nbMaxTache
        
                 FROM inside_sprint_us as isu,user_story=us,
                 inside_sprint_task_us as istu,
                 task
        
                  WHERE isu.sprint_id=:sprintId and us.id=isu.user_story_id and istu.inside_sprint_us_id=isu.id and task.id=istu.task_id 
                  group by us.id) t2
        ON (t1.id = t2.id)"
    );
        $stmt->execute(array('sprintId' => $sprintId));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
        return -1;
    }
}

/**
 * @brief This function allows you to return the complete list of userstory inside a project.
 * @param projectId the project id
 * @return The PDOStatement contening all the userstory of a project or -1 if an exception occurs
 */
function get_all_us_inside_project($projectId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "SELECT *
            FROM user_story
            WHERE project_id=:projectId"
    );
        $stmt->execute(array('projectId' => $projectId));
        return $stmt;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

/**
 * @brief This function allows you to change the status of a task.
 * @param taskId the task id
 * @param state the new state of a task possible value : 'todo', 'onGoing', 'done'
 * @return return 1 if success or -1 if an exception occurs
 */
function switch_task_state($taskId, $state)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "UPDATE task
        SET state=:state
        WHERE id=:taskId"
    );
        $stmt->execute(array(
        'state' => $state,
        'taskId' => $taskId
    ));
        return 1;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

/**
 * @brief This function remove a task.
 * @param taskId the task id
 * @return return 1 if success or -1 if an exception occurs
 */
function remove_task($taskId)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "DELETE FROM task
          WHERE id=:taskId"
    );
        $stmt->execute(array('taskId' => $taskId));
        return 1;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

/**
 * @brief This function allows you to link the us to a sprint.
 * @param sprintId the sprint id
 * @param allUSToLink an array contening all the us to link
 * @return return 1 if success or -1 if an exception occurs
 */
function link_us_to_sprint($sprintId, $allUSToLink)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "INSERT INTO inside_sprint_us(sprint_id, user_story_id)
            VALUES(:sprint_id, :us_id)"
    );
        foreach ($allUSToLink as $us_id) {
            $stmt->execute(array(
        'sprint_id' => $sprintId,
        'us_id'     => $us_id
        ));
        }
        return 1;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
    return 1;
}

/**
 * @brief This function allows you to unlink the us to a sprint.
 * @param taskId the task id
 * @param allUSToLink an array contening all the us to unlink
 * @return return 1 if success or -1 if an exception occurs
 */
function unlink_us_from_sprint($sprintId, $allUSToUnlink)
{
    try {
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "DELETE FROM inside_sprint_us
          WHERE sprint_id=:sprint_id and user_story_id=:us_id"
    );
        foreach ($allUSToUnlink as $us_id) {
            $stmt->execute(array(
        'sprint_id' => $sprintId,
        'us_id'     => $us_id
        ));
        }
        return 1;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
    return 1;
}

/**
 * @brief This method returns an array of three columns with the number of tasks
 * @param sprintId the sprint id
 * @return an array with the task bomb to the number of tage onGoin and the number of task done  -1 if an exception occurs
 */
function count_nb_task_by_state_in_sprint($sprintId)
{
    try {
        $state = array('todo', 'onGoing', 'done');
        $result = array(0, 0, 0);
        $bdd = dbConnect();
        $stmt = $bdd->prepare(
        "SELECT COUNT(*) 
            FROM task 
            WHERE sprint_id=:sprintId and state=:state"
    );

        for ($i = 0; $i < 3; $i++) {
            $stmt->execute(array(
        'sprintId' => $sprintId,
        'state'    => $state[$i]
        ));
            $nb = $stmt->fetch(PDO::FETCH_NUM);
            $result[$i] = $nb[0];
        }

        return $result;
    } catch (PDOException $e) {
        echo  "<br>" . $e->getMessage();
    }
}
