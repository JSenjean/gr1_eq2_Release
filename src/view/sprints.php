<div class="container mt-3">

  <div class="row">
    <h4 class="col-lg-3 mb-1">Sprints du projet</h4>
    <button class="col-lg-2 float-left btn btn-primary-outline bg-primary col-sm-12 createOrModifySprintModal text-white" type="button" style="border: none;" data-target='#createOrModifySprintModal' data-toggle="modal" data-projectid="<?php echo $projectId; ?>" data-date="<?php echo date("Y-m-d") ?>">Ajouter un Sprint</button>
  </div>
  <div class="container">
    <div class="row">
      <?php foreach ($sprints as $value) : $startD = $value['start'];
        $endD = $value['end']; ?>
        <div class="col-lg-3 sprint" data-sprintid="<?php echo $value['id'] ?>">
          <div class="card mt-4 sprintCard bg-light" style="width: 15rem;">
            <div class="card-header <?php $currentProjectBg = add_sprint_background($startD, $endD);
                                        echo $currentProjectBg ?>">
              <div class="row">
                <div class="col-lg-2">
                  <button class="btn btn-primary-outline float-left createOrModifySprintModal" data-target='#createOrModifySprintModal' data-toggle="modal" data-projectid="<?php echo $projectId; ?>" data-sprintid="<?php $sprintId = $value['id'];
                                                                                                                                                                                                                        echo $sprintId; ?>" data-name="<?php $name = $value['name'];
                                                                                                                                                                                                                                                                                        echo $name; ?>" data-start="<?php echo $startD ?>" data-end="<?php echo $endD ?>" type="button" style="background-color: transparent; border: none;">
                    <em class='fas fa-pen fa-xs' style="color:blue" title="Modifier Sprint"></em>
                </div>
                <div class="col">
                  <?php echo $name; ?>
                </div>
                <div class="col-lg-2">
                  <button class="btn btn-primary-outline float-right deleteSprint" data-sprintid="<?php echo $sprintId ?>" type="button" style="background-color: transparent; border: none;">
                    <em class='fas fa-times fa-xs' title="Modifier Sprint"></em>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="col">
                <div>
                  <p class="card-text">Début : <?php $startDate = date("j/m/Y", strtotime($startD));
                                                    echo $startDate; ?></p>
                </div>
                <div>
                  <p class="card-text">Fin : <?php $endDate = date("j/m/Y", strtotime($endD));
                                                echo $endDate; ?></p>
                </div>
                <div class="PBarContainer" id="<?php echo $value['id'] ?>" data-alltask="<?php $countAllTask = $value['todo'] + $value['onGoing'] + $value['done']; echo $countAllTask ?>">        
                  <div class="progress pBar" style="<?php echo ($countAllTask != 0) ? "" : "display: none" ?>" data-alltask="<?php echo $countAllTask ?>" data-todo='<?php echo $value['todo'] ?>' data-ongoing='<?php echo $value['onGoing'] ?>' data-done='<?php echo $value['done'] ?>'>
                    <div class="progress-bar bg-danger text-dark pBarTodo" role="progressbar" style="width: <?php echo ($value['todo']/$countAllTask)*100 ?>%" aria-valuenow="<?php echo $value['todo'] ?>" aria-valuemin="0" aria-valuemax="<?php echo $countAllTask ?>"><?php echo $value['todo'] ?></div>
                    <div class="progress-bar bg-warning text-dark pBarOnGoing" role="progressbar" style="width: <?php echo ($value['onGoing']/$countAllTask)*100 ?>%" aria-valuenow="<?php echo $value['onGoing'] ?>" aria-valuemin="0" aria-valuemax="<?php echo $countAllTask ?>"><?php echo $value['onGoing'] ?></div>
                    <div class="progress-bar bg-success text-dark pBarDone" role="progressbar" style="width: <?php echo ($value['done']/$countAllTask)*100 ?>%" aria-valuenow="<?php echo $value['done'] ?>" aria-valuemin="0" aria-valuemax="<?php echo $countAllTask ?>"><?php echo $value['done'] ?></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <p>US: <?php echo $value['nbUS'] ?></p>
                  </div>
                  <div class="col">
                    <p>Effort: <?php echo $value['efforts'] ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>
</br>
</br>
<div class="container" id="taskInsideSprint" hidden>
  <!-- tasks View -->
  <div class="row">
    <div class="col-xl-2">
      <button class="btn bg-primary linkUSToSprintModal text-white" data-target='#linkUSToSprintModal' data-toggle='modal' id="linkUS" data-sprintid="" data-projectid="<?php echo $projectId; ?>">Ajouter User Story</button>
    </div>
    <div class="col-xl-1">
      <button class="btn bg-primary createOrModifyTaskModal text-white" type="button" data-target='#createOrModifyTaskModal' data-toggle="modal" id="createTask" data-sprintid="" data-projectid="<?php echo $projectId; ?>">Créer une tâche</button>
    </div>
  </div>
  </br>
  <div class="container-fluid table-sprint" id="table-sprint">
    <div class="row">
      <div class="US col col-sm-2 text-center">
        <h5 class="firstCol">User Story</h5>
      </div>
      <div class="col col-sm text-center Todo colTask">
        <h5 class="firstCol bg-danger">Todo</h5>

      </div>
      <div class="col col-sm text-center Doing colTask">
        <h5 class="firstCol bg-warning">Doing</h5>

      </div>
      <div class="col col-sm text-center Done colTask">
        <h5 class="firstCol bg-success">Done</h5>

      </div>
    </div>
  </div>

</div>

<link rel="stylesheet" href="sprints.css">
<script>
  $(".sprint").click(function() {
    $(".sprintCard").css("border", "0px");
    $(this).children($(".sprintCard")).css("border", "3px solid blue");
    $("#taskInsideSprint").removeAttr('hidden');

    var sprintId = $(this).data('sprintid');

    $("#createTask").attr('data-sprintid', sprintId);
    $("#linkUS").attr('data-sprintid', sprintId);


    $('.Todo').find('*').not('.firstCol').remove();
    $('.Doing').find('*').not('.firstCol').remove();
    $('.done').find('*').not('.firstCol').remove();
    $('.US').find('*').not('.firstCol').remove();


    $.ajax({
      type: 'POST',
      url: 'index.php?action=sprints',
      data: {
        getTask: true,
        sprintId: sprintId
      },
      success: function(response) {
        var tasks = JSON.parse(response);
        var htmlToWrite = "";
        var taskId;
        tasks.forEach(function(item) {

          var where;
          htmlToWrite += "<div class='card mt-2 task' data-taskid='" + item["id"] +"' data-sprintid='" + sprintId + "'  >"
          htmlToWrite += "<a class='btn btn-primary-outline pull-right removeTask' data-taskid='" + item["id"] + "' data-state='"+ item['state'] + "' type='button'><em class='fas fa-times' style='color:red' title='supprimer Tache'></em> </a>"
          htmlToWrite += "<a data-target='#createOrModifyTaskModal' data-toggle='modal' class='modalLink' style='cursor:pointer'"
          htmlToWrite += " data-memberid='" + item['member_id'] + "' data-name='" + item['name'] + "' data-description='" + item['description'] + "' data-dod='" + item['dod'] + "' data-time='" + item['time'] + "' data-sprintid='" + item['sprint_id'] + "' data-pred='" + item['predecessor'] + "' data-id='" + item['id'] + "' data-state='" + item['state'] + "' >"
          htmlToWrite += "<div class='card-header'>" + item['name'] + "</div>";
          htmlToWrite += "</a>"
          htmlToWrite += "<div class='card-body'>" + item['description'] + "</div>";
          htmlToWrite += "<div class='row switchDiv'>"


          taskId = item['id'];
          if (item["state"] === "todo") {
            where = ".Todo"
            htmlToWrite += "<a class='col-lg-12 float-right switchArrow' data-from='todo' data-target='onGoing' data-taskid='" + item['id'] + "'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Doing' ></em></a>"
          } else if (item["state"] === "onGoing") {
            where = ".Doing"
            htmlToWrite += "<a class='col-lg-6 float-left switchArrow' data-from='onGoing' data-target='todo' data-taskid='" + item['id'] + "'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='passer la tache en Todo' ></em></a>"
            htmlToWrite += "<a class='col-lg-6 float-right switchArrow' data-from='onGoing' data-target='done' data-taskid='" + item['id'] + "'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Done' ></em></a>"
          } else if (item["state"] === "done") {
            where = ".Done"
            htmlToWrite += "<a class='col-lg-12 float-left switchArrow' data-from='done' data-target='onGoing' data-taskid='" + item['id'] + "'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='Accéder au projet' ></em></a>"
          }

          htmlToWrite += "</div>"
          htmlToWrite += "</div> "

          $(where).append(htmlToWrite);
          htmlToWrite = "";
        });
      }
    })
    generateUS();
    function generateUS()
    {
    //US
    $.ajax({
      type: 'POST',
      url: 'index.php?action=sprints',
      data: {
        getUS: true,
        sprintId: sprintId
      },
      success: function(response) {
        var us = JSON.parse(response);
        var htmlToWrite = "";
        var percentTodo = 0;
        var percentDoing = 0;
        var percentDone = 0;

        us.forEach(function(item) {
          nbTodo=(item["nbTodo"]===null) ? 0 : item["nbTodo"];
          nbOnGoing=(item["nbOnGoing"]===null) ? 0 : item["nbOnGoing"];
          nbDone=(item["nbDone"]===null) ? 0 : item["nbDone"];
          nbMaxTache=(item["nbMaxTache"]===null) ? 1 : item["nbMaxTache"];

          percentTodo = item["nbTodo"]/item["nbMaxTache"]*100;
          percentDoing = item["nbOnGoing"]/item["nbMaxTache"]*100;
          percentDone = item["nbDone"]/item["nbMaxTache"]*100;


          htmlToWrite += "<div class='card mt-1'>"
          htmlToWrite += "<div class='card-header'>" + item["name"] + "</div>";
          htmlToWrite += "<div class='progress '>"
          if(item["nbMaxTache"]!=null)
          {
          htmlToWrite += "<div class='progress-bar bg-danger' role='progressbar' style='width: " + percentTodo + "%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='" + nbTodo + "'>" + nbTodo + "</div>"
          htmlToWrite += "<div class='progress-bar bg-warning' role='progressbar' style='width: " + percentDoing + "%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='" + nbOnGoing + "'>" + nbOnGoing + "</div>"
          htmlToWrite += "<div class='progress-bar bg-success' role='progressbar' style='width: " + percentDone + "%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='" + nbDone + "'>" + nbDone + "</div>"
          }
          else
          {
            htmlToWrite += "<div class='progress-bar bg-danger' role='progressbar' style='width: 100%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>aucunes taches</div>"
          }
          htmlToWrite += "</div>"
          htmlToWrite += "</div>";
          $(".US").append(htmlToWrite);

          htmlToWrite = "";
        });
      }
    })
    }
  });



  $(document).ready(function() {
    var sprintId = [];
    $(".deleteSprint").click(function(event) {
      event.stopPropagation();

      var r = confirm("Cette action est irréversible, confirmez-vous la suppression ?");
      if (r) {
        var sprintId = $(this).data('sprintid');
        var button = $(this);

        $.ajax({
          type: 'POST',
          url: 'index.php?action=sprints',
          data: {
            delete: true,
            sprintToDeleteId: sprintId
          },
          success: function(response) {
            button.closest('.sprint').remove();
          }
        })
      }
    })

    $(document).on("click", ".switchArrow", function(event) {
      var trigger = $(this);
      var sprintId = trigger.closest('.task').data('sprintid');
      var divToAppend = document.getElementById(sprintId);
      var progressBar = divToAppend.children[0];
      var allTask = $(progressBar).data('alltask');
      var todo = $(progressBar).data('todo');
      var onGoing = $(progressBar).data('ongoing');
      var done = $(progressBar).data('done');
      var taskId = trigger.data("taskid");
      var col;
      var target = trigger.data("target");
      var htmlArrow = "";
      if (target == "onGoing") {
        var from = trigger.data('from');
        if (from == "todo")
          todo--;
        else 
          done--;
        onGoing++;
        col = ".Doing";
        htmlArrow += "<a class='col-lg-6 float-left switchArrow' data-from='onGoing' data-target='todo' data-taskid='" + taskId + "'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='passer la tache en Todo' ></em></a>"
        htmlArrow += "<a class='col-lg-6 float-right switchArrow' data-from='onGoing' data-target='done' data-taskid='" + taskId + "'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Done' ></em></a>"
      } else if (target == "todo") {
        onGoing--;
        todo++;
        col = ".Todo";
        htmlArrow += "<a class='col-lg-12 float-right switchArrow' data-from='todo' data-target='onGoing' data-taskid='" + taskId + "'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Doing' ></em></a>"
      } else if (target == "done") {
        onGoing--;
        done++;
        col = ".Done";
        htmlArrow += "<a class='col-lg-12 float-left switchArrow' data-from='done' data-target='onGoing' data-taskid='" + taskId + "'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='Accéder au projet' ></em></a>"
      }



      $.ajax({
        type: 'POST',
        url: 'index.php?action=sprints',
        data: {
          switchState: target,
          taskToSwitch: taskId
        },
        success: function(response) {
          // progress Bar
          var width;
          htmlNewPBar = "";
          htmlNewPBar += "<div class='progress pBar' style='' data-alltask='"+ allTask +"' data-todo='"+ todo +"' data-ongoing='"+ onGoing +"' data-done='"+ done +"' >";
          width = (todo/allTask)*100;
          htmlNewPBar += "<div class='progress-bar bg-danger text-dark pBarTodo' role='progressbar' style='width: "+ width +"%' aria-valuenow='"+ todo +"' aria-valuemin='0' aria-valuemax='"+ allTask +"'>"+ todo +"</div>";
          width = (onGoing/allTask)*100;
          htmlNewPBar += "<div class='progress-bar bg-warning text-dark pBarOnGoing' role='progressbar' style='width: "+ width +"%' aria-valuenow='"+ onGoing +"' aria-valuemin='0' aria-valuemax='"+ allTask +"'>"+ onGoing +"</div>";
          width = (done/allTask)*100;
          htmlNewPBar += "<div class='progress-bar bg-success text-dark pBarDone' role='progressbar' style='width: "+ width +"%' aria-valuenow='"+ done +"' aria-valuemin='0' aria-valuemax='"+ allTask +"'>"+ done +"</div>";
          htmlNewPBar += "</div>";
          
          var switchDiv = trigger.closest(".switchDiv");
          switchDiv.empty();
          switchDiv.append(htmlArrow);
          var task = switchDiv.closest(".task");
          task.children(".modalLink").attr("data-state", target);
          var taskHtml = task.html();
          switchDiv.closest(".task").remove();
          var htmlToWrite = "<div class='card mt-2 task' data-taskid='" + taskId + "'  >"
          htmlToWrite += taskHtml
          htmlToWrite += "</div>"
          $(col).append(htmlToWrite);

          // progress Bar
          $(divToAppend).empty();
          $(divToAppend).append(htmlNewPBar);
          width = null;
          progressBar = null;
          divToAppend = null;
          todo = null;
          onGoing = null;
          done = null;
          allTask = null;
          $('.sprint[data-sprintid="'+ sprintId +'"]').click();
        }
      })
    })


    $(document).on("click", ".removeTask", function(event) {
      event.stopPropagation();
      var trigger = $(this);
      var taskId = trigger.data("taskid");

      // progress Bar
      var sprintId = trigger.closest('.task').data('sprintid');
      var divToAppend = document.getElementById(sprintId);
      var progressBar = divToAppend.children[0];
      var allTask = $(progressBar).data('alltask');
      var todo = $(progressBar).data('todo');
      var onGoing = $(progressBar).data('ongoing');
      var done = $(progressBar).data('done');

      $.ajax({
        type: 'POST',
        url: 'index.php?action=sprints',
        data: {
          removeTaskId: taskId,
        },
        success: function(response) {
          var from = trigger.data('state');
          switch (from) {
            case "todo":
                todo--;
                break;
            case "onGoing":
                onGoing--;
                break;
            case "done":
                done--;
                break;
          }
          trigger.closest(".task").remove();
          
          // progress Bar
          var width;
          allTask--;
          htmlNewPBar = "";
          if (allTask == 0) {
            htmlNewPBar += "<div class='progress pBar' style='display: none' data-alltask='"+ allTask +"' data-todo='"+ todo +"' data-ongoing='"+ onGoing +"' data-done='"+ done +"' >";
          } else {
            htmlNewPBar += "<div class='progress pBar' style='' data-alltask='"+ allTask +"' data-todo='"+ todo +"' data-ongoing='"+ onGoing +"' data-done='"+ done +"' >";
          }
          width = (todo/allTask)*100;
          htmlNewPBar += "<div class='progress-bar bg-danger text-dark pBarTodo' role='progressbar' style='width: "+ width +"%' aria-valuenow='"+ todo +"' aria-valuemin='0' aria-valuemax='"+ allTask +"'>"+ todo +"</div>";
          width = (onGoing/allTask)*100;
          htmlNewPBar += "<div class='progress-bar bg-warning text-dark pBarOnGoing' role='progressbar' style='width: "+ width +"%' aria-valuenow='"+ onGoing +"' aria-valuemin='0' aria-valuemax='"+ allTask +"'>"+ onGoing +"</div>";
          width = (done/allTask)*100;
          htmlNewPBar += "<div class='progress-bar bg-success text-dark pBarDone' role='progressbar' style='width: "+ width +"%' aria-valuenow='"+ done +"' aria-valuemin='0' aria-valuemax='"+ allTask +"'>"+ done +"</div>";
          htmlNewPBar += "</div>";

          $(divToAppend).empty();
          $(divToAppend).append(htmlNewPBar);
          width = null;
          progressBar = null;
          divToAppend = null;
          todo = null;
          onGoing = null;
          done = null;
          allTask = null;
        }
      })

    })

  });
</script>