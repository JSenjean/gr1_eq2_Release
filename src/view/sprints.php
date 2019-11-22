<div class="container mt-3">
  <h4 class="mb-1">Sprints du projet</h4>
  <div class="container">
    <div class="row">
      <?php foreach ($sprints as $value) : $startD = $value['start'];
        $endD = $value['end']; ?>
        <div class="col-lg-3 sprint" data-sprintid="<?php echo $value['id'] ?>">
          <div class="card mt-4 sprintCard <?php $currentProjectBg = add_sprint_background($startD, $endD);
                                              echo $currentProjectBg ?>" style="width: 15rem;">
            <div class="card-header">
              <div class="row">
                <div class="col-lg-2">
                  <button class="btn btn-primary-outline float-left createOrModifySprintModal" data-target='#createOrModifySprintModal' data-toggle="modal" data-projectid="<?php echo $projectId; ?>" data-sprintid="<?php $sprintId = $value['id']; echo $sprintId; ?>" data-name="<?php $name = $value['name'];echo $name; ?>" data-start="<?php echo $startD ?>" data-end="<?php echo $endD ?>" type="button" style="background-color: transparent; border: none;">
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
                <div class="progress">
                  <div class="progress-bar bg-warning text-dark" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
  <div class="col ">
    <button class="btn btn-primary-outline bg-primary col-sm-12 createOrModifySprintModal" type="button" style="border: none;" data-target='#createOrModifySprintModal' data-toggle="modal" data-projectid="<?php echo $projectId; ?>" data-date="<?php echo date("Y-m-d")?>" >
      <em class='fas fa-plus fa-3x' style="color:white" title="CreateSprint"></em>
  </div>
</div>
</br>
</br>
<div class="container" id="taskInsideSprint" hidden>
  <!-- tasks View -->
  <div class="row">
    <div class="col-xl-2">
      <button class="btn bg-primary linkUSToSprint" data-target='#linkUSToSprint' data-toggle='modal'>Ajouter User Story</button>
    </div>
    <div class="col-xl-1">
      <button class="btn bg-primary createOrModifyTaskModal" type="button" data-target='#createOrModifyTaskModal' data-toggle="modal" id="createTask" data-sprintid="" data-projectid="<?php echo $projectId; ?>">Créer une tâche</button>
    </div>
  </div>
  </br>
  <div class="container-fluid table-sprint" id="table-sprint">
    <div class="row">
      <div class="col col-sm text-center US">
        <h5 class="firstCol">User Story</h5>
        <div class="card mt-1">
          <div class="card-header">US1</div>
          <div class="card-body">Description</div>
        </div>
      </div>
      <div class="col col-sm text-center Todo">
        <h5 class="firstCol">Todo</h5>

      </div>
      <div class="col col-sm text-center Doing">
        <h5 class="firstCol">Doing</h5>

      </div>
      <div class="col col-sm text-center Done">
        <h5 class="firstCol">Done</h5>

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


    $('.Todo').find('*').not('.firstCol').remove();
    $('.Doing').find('*').not('.firstCol').remove();
    $('.done').find('*').not('.firstCol').remove();


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
        var taskId
        tasks.forEach(function(item) {

          var where;
          htmlToWrite += "<div class='card mt-2 task' data-taskid='" + item["id"] + "'  >"
          htmlToWrite += "<a class='btn btn-primary-outline pull-right removeTask' data-taskid='" + item["id"] + "' type='button'><em class='fas fa-times' style='color:red' title='supprimer Tache'></em> </a>"
          htmlToWrite += "<a data-target='#createOrModifyTaskModal' data-toggle='modal' class='modalLink' style='cursor:pointer'"
          htmlToWrite += " data-memberid='" + item['member_id'] + "' data-name='" + item['name'] + "' data-description='" + item['description'] + "' data-dod='" + item['dod'] + "' data-time='" + item['time'] + "' data-sprintid='" + item['sprint_id'] + "' data-pred='" + item['predecessor'] + "' data-id='"+ item['id'] + "' data-state='"+ item['state'] + "' >"
          htmlToWrite += "<div class='card-header'>" + item['name'] + "</div>";
          htmlToWrite += "</a>"
          htmlToWrite += "<div class='card-body'>" + item['description'] + "</div>";
          htmlToWrite += "<div class='row switchDiv'>"


          taskId = item['id'];
          if (item["state"] === "todo") {
            where = ".Todo"
            htmlToWrite += "<a class='col-lg-12 float-right switchArrow' data-target='onGoing' data-taskid='"+item['id']+"'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Doing' ></em></a>"
          } else if (item["state"] === "onGoing") {
            where = ".Doing"
            htmlToWrite += "<a class='col-lg-6 float-left switchArrow' data-target='todo' data-taskid='"+item['id']+"'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='passer la tache en Todo' ></em></a>"
            htmlToWrite += "<a class='col-lg-6 float-right switchArrow' data-target='done' data-taskid='"+item['id']+"'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Done' ></em></a>"
          } else if (item["state"] === "done") {
            where = ".Done"
            htmlToWrite += "<a class='col-lg-12 float-left switchArrow' data-target='onGoing' data-taskid='"+item['id']+"'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='Accéder au projet' ></em></a>"
          }

          htmlToWrite += "</div>"
          htmlToWrite += "</div> "

          $(where).append(htmlToWrite);
          htmlToWrite = "";
        });
      }
    })
    //US
    $.ajax({
      type: 'POST',
      url: 'index.php?action=sprints',
      data: {
        getUS: true,
        sprintId: sprintId
      },
      success: function(response) {
        var tasks = JSON.parse(response);
        var htmlToWrite = "";
        tasks.forEach(function(item) {

          htmlToWrite += "<div class='card mt-1'>"
          htmlToWrite += "<div class='card-header'>" + item["name"] + "</div>";
          htmlToWrite += "<div class='card-body'>" + (item['description'] != undefined ? item['description'] : '') + "</div>";
          htmlToWrite += "</div>";
          $(".US").append(htmlToWrite);

          htmlToWrite = "";
        });
      }
    })



  });


  $(document).ready(function() {
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
        //event.stopImmediatePropagation();

        var trigger= $(this);
        
        var taskId= trigger.data("taskid");
        var col;
        var target = trigger.data("target");
        var htmlArrow = "";
        if (target == "onGoing") {
          col = ".Doing";
          htmlArrow += "<a class='col-lg-6 float-left switchArrow' data-target='todo' data-taskid='"+taskId+"'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='passer la tache en Todo' ></em></a>"
          htmlArrow += "<a class='col-lg-6 float-right switchArrow' data-target='done' data-taskid='"+taskId+"'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Done' ></em></a>"
        } else if (target == "todo") {
          col = ".Todo";
          htmlArrow += "<a class='col-lg-12 float-right switchArrow' data-target='onGoing' data-taskid='"+taskId+"'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Doing' ></em></a>"
        } else if (target == "done") {
          col = ".Done";
          htmlArrow += "<a class='col-lg-12 float-left switchArrow' data-target='onGoing' data-taskid='"+taskId+"'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='Accéder au projet' ></em></a>"
        }



        $.ajax({
          type: 'POST',
          url: 'index.php?action=sprints',
          data: {
            switchState: target,
            taskToSwitch: taskId
          },
          success: function(response) {

            var switchDiv = trigger.closest(".switchDiv")
            switchDiv.empty();
            switchDiv.append(htmlArrow);
            var task = switchDiv.closest(".task");
            task.children(".modalLink").attr("data-state",target);
            var taskHtml = task.html();
            switchDiv.closest(".task").remove();
            var htmlToWrite = "<div class='card mt-2 task' data-taskid='" + taskId + "'  >"
            htmlToWrite += taskHtml
            htmlToWrite += "</div>"
            $(col).append(htmlToWrite);

          }
        })



    })


    $(document).on("click", ".removeTask", function(event) {
      event.stopPropagation();
      var trigger= $(this);
      var taskId = trigger.data("taskid");

      $.ajax({
          type: 'POST',
          url: 'index.php?action=sprints',
          data: {
            removeTaskId: taskId,
          },
          success: function(response) {
            trigger.closest(".task").remove()
          }
        })

    })

  });
</script>
