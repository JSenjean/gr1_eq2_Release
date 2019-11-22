<?php

function get_all_sprints($projectID)
{
  try {
    $bdd = dbConnect();
    $stmt = $bdd->prepare(
      "SELECT *
          FROM sprint
          WHERE project_id=:projectId
          ORDER BY start"
    );
    $stmt->execute(array(':projectId' => $projectID));
    return $stmt;
  } catch (PDOException $e) {
    echo  "<br>" . $e->getMessage();
    return -1;
  }
}

function add_sprint_background($startDate, $endDate)
{
  $curDate = new DateTime("now");
  $sDate = new DateTime($startDate);
  $eDate = new DateTime($endDate);
  $curDate->settime(0,0);

  if ($eDate < $curDate) {
    return "bg-success";
  } else if ($sDate <= $curDate && $eDate >= $curDate) {
    return "bg-danger";
  }
  return "bg-info";
}

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

function get_all_project_members_and_master($id) {
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

/* Task inside Sprint
 */
function create_new_task($name, $description, $dod, $predecessor, $time, $sprintId, $memberId) {
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
      'maquette'    => NULL
    ));
    return $bdd->lastInsertId();
  } catch (PDOException $e) {
    echo  "<br>" . $e->getMessage();
    return -1;
  }
  return 1;
}

function update_task($id, $name, $description, $dod, $predecessor, $time, $memberId) {
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

function get_all_task_inside_sprint($sprintId) {
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

function get_all_us_inside_sprint($sprintId) {
  try {
      $bdd = dbConnect();
      $stmt = $bdd->prepare(
          "SELECT us.*
              FROM inside_sprint_us=isu,user_story=us
              WHERE isu.sprint_id=:sprintId and us.id=isu.user_story_id"
      );
      $stmt->execute(array('sprintId' => $sprintId));
      return $stmt;
  } catch (PDOException $e) {
      echo "<br>" . $e->getMessage();
  }
}
function switch_task_state($taskId,$state) {
  try {
      $bdd = dbConnect();
      $stmt = $bdd->prepare(
        "UPDATE task
        SET state=:state
        WHERE id=:taskId"
      );
      $stmt->execute(array('state' => $state,
                            'taskId' => $taskId));
      return 1;
  } catch (PDOException $e) {
      echo "<br>" . $e->getMessage();
  }
}
function remove_task($taskId) {
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
