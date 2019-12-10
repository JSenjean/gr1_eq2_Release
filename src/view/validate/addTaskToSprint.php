<div class="modal fade" id="createOrModifyTaskModal" tabindex="-1" role="dialog" aria-labelledby="createOrModifyTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOrModifyTaskModalLabel">Créer/Modifier une tâche</h5>
                <button type="button" class="close closeCrossTask" data-dismiss="modal" aria-label="Close" id="closeCrossTask">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" data-toggle="validator addNewTask" action="index.php?action=sprints" id="addNewTask">
                    <div class="form-group row m-2">
                        <label for="taskName">Nom de la tâche : </label>
                        <input type="text taskName" id="taskName" maxlength="50 " name="taskName" required>
                    </div>
                    <div>
                        <label for="taskDescription"> Description : </label>
                        <textarea type="textarea taskDescription" id="taskDescription" class="form-control" name="taskDescription"></textarea>
                    </div>
                    <div>
                        <label for="taskDod"> Definition Of Done : </label>
                        <textarea type="textarea taskDod" id="taskDod" class="form-control" name="taskDod"></textarea>
                    </div>
                    <div>
                        <label for="taskPredecessor"> Prédécesseur : </label>
                        <textarea type="textarea taskPredecessor" id="taskPredecessor" class="form-control" name="taskPredecessor"></textarea>
                    </div>
                    </br>
                    <div class="form-inline">
                        <div class="form-group row m-2">
                            <label for="taskTime">Durée :</label>
                            <select class="form-control taskTimeValue" id="taskTimeValue" name="taskTimeValue">
                                <option value="0.5">0.5</option>
                                <option value="1">1</option>
                                <option value="1.5">1.5</option>
                                <option value="2">2</option>
                                <option value="2.5">2.5</option>
                                <option value="3">3</option>
                                <option value="3.5">3.5</option>
                                <option value="4">4</option>
                            </select>
                            <label for="taskUnit"> </label>
                        </div>
                        <div class="form-group row m-2">
                            <label for="taskMember">Membre :</label>
                            <select class="form-control taskMember" id="taskMember" name="taskMember">
                                <option value="0">aucun</option>
                                <?php foreach ($projectMembers as $member) : ?>
                                    <option value="<?php echo $member['id']; ?>"><?php echo $member['username']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="container row m-2">
                            <label for="multSelecTask">Ajouter des UserStory : </label>
                            <select class="selectpicker multSelectTask" data-style="pb-4" id="multSelectTask" name="multSelectTask" multiple data-live-search="true">
                            </select>
                        </div>
                        <div class="container row m-2">
                            <label for="taskType">Type de la tâche : </label>
                            <select class="form-control taskType" id="taskType">
                                <option value="basic">Tâche basique</option>
                                <option value="test">Tâche de test</option>
                                <option value="doc">Tâche de doc</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button id="validate" type="input" class="btn btn-primary validate">Valider</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var projectId = null;
        var sprintId = null;
        var taskId = null;
        var taskName = "";
        var taskDescription = "";
        var taskDod = "";
        var taskPredecessor = "";
        var taskMember = 0;
        var taskTime = 0.5;
        var taskState = null;
        var modify = false;
        var button = null;
        var SelectChildren = null;
        var allSelected = null;
        var allSelectedId = null;
        var taskType = null;

        $("#createOrModifyTaskModal").on("shown.bs.modal", function(event) {
            button = $(event.relatedTarget);

            sprintId = button.data('sprintid');

            if (typeof button.data('memberid') != 'undefined') {
                taskMember = button.data('memberid');
                taskName = button.data('name');
                taskDescription = button.data('description');
                taskDod = button.data('dod');
                taskTime = button.data('time');
                taskPredecessor = button.data('pred');
                taskId = button.data('id');
                taskState = button.data('state');
                modify = true;
            } else {
                projectId = button.data('projectid');
                taskName = "";
                taskDescription = "";
                taskDod = "";
                taskPredecessor = "";
                taskMember = 0;
                taskTime = 0.5;
                taskState = "todo";
                modify = false;
            }
            $("#taskName").val(taskName);
            $("#taskDescription").val(taskDescription);
            $("#taskDod").val(taskDod);
            $("#taskPredecessor").val(taskPredecessor);
            $('#taskMember').val(taskMember);
            $('#taskTimeValue').val(taskTime);

            $.ajax({
                type: 'POST',
                url: 'index.php?action=sprints',
                data: {
                    linkedUS: true,
                    sprintId: sprintId
                },
                success: function(response) {
                    SelectChildren = $(".multSelectTask").parent().children("select").children();
                    if (SelectChildren.length != 0) {
                        for (let i = 0; i < SelectChildren.length; i++) {
                            $(SelectChildren[i]).remove();
                        }
                        $('.multSelectTask').selectpicker('refresh');
                    }
                    var us = JSON.parse(response);
                    var htmlToWrite = "";
                    var where = ".multSelectTask";
                    us.forEach(function(item) {
                        htmlToWrite += "<option style='display: none;' value='" + item['id'] + "' >" + item['name'] + "</option>";
                    });
                    $(where).append(htmlToWrite);

                    SelectChildren = $(".multSelectTask").parent().children("select").children();
                    for (let i = 0; i < SelectChildren.length; i++) {
                        $(SelectChildren[i]).show();
                    }
                    $('.multSelectTask').selectpicker('refresh');
                }
            })

            if (modify) {
                $.ajax({
                    type: 'POST',
                    url: 'index.php?action=sprints',
                    data: {
                        linkedUSToTask: true,
                        taskId: taskId
                    },
                    success: function(response) {
                        var us = JSON.parse(response);
                        allSelected = [];
                        allSelectedId = [];
                        us.forEach(function(item) {
                            allSelected.push(item['user_story_id']);
                            allSelectedId.push(item[0]);
                        });
                        $('.multSelectTask').val(allSelected);
                        $('.multSelectTask').selectpicker('refresh');
                    }
                })
            }
        });

        $("#addNewTask").on('submit', function(event) {
            event.preventDefault();


            taskName = $("#taskName").val();
            taskDescription = $("#taskDescription").val();
            taskDod = $("#taskDod").val();
            taskPredecessor = $("#taskPredecessor").val();
            taskMember = $('#taskMember').val();
            taskTime = $("#taskTimeValue").val();
            taskType = $("#taskType").val();

            var USToLinkTask = $('#multSelectTask').val();
            var USToUnlinkTask = new Array();
            if (allSelected != null) {
                for (let i = 0; i < allSelected.length; i++) {
                    curren_us_id = USToLinkTask.find(us_id => us_id === allSelected[i]);
                    if (curren_us_id != undefined) {
                        removeElement(USToLinkTask, curren_us_id);
                    } else {
                        USToUnlinkTask.push(allSelectedId[i]);
                    }
                }
            }
            $.ajax({
                type: 'POST',
                url: 'index.php?action=sprints',
                data: {
                    modifyTask: modify,
                    newTaskName: taskName,
                    taskDescription: taskDescription,
                    taskDod: taskDod,
                    taskPredecessor: taskPredecessor,
                    taskMember: taskMember,
                    taskTime: taskTime,
                    taskId: taskId,
                    sprintId: sprintId,
                    usToLinkTask: USToLinkTask,
                    usToUnlinkTask: USToUnlinkTask,
                    taskType: taskType,
                    projectId: projectId
                },
                success: function(response) {
                    $('#closeCrossTask').click();
                    var htmlToWrite = "";
                    //var where = "";
                    var whereModify = null;

                    if (!modify) {
                        // progress Bar
                        var divToAppend = document.getElementById(sprintId);
                        var progressBar = divToAppend.children[0];
                        var allTask = $(progressBar).data('alltask');
                        var todo = $(progressBar).data('todo');
                        var onGoing = $(progressBar).data('ongoing');
                        var done = $(progressBar).data('done');

                        // progress Bar
                        var width;
                        allTask++;
                        todo++;
                        htmlNewPBar = "";
                        htmlNewPBar += "<div class='progress pBar' style='' data-alltask='" + allTask + "' data-todo='" + todo + "' data-ongoing='" + onGoing + "' data-done='" + done + "' >";
                        width = (todo / allTask) * 100;
                        htmlNewPBar += "<div class='progress-bar bg-danger text-dark pBarTodo' role='progressbar' style='width: " + width + "%' aria-valuenow='" + todo + "' aria-valuemin='0' aria-valuemax='" + allTask + "'>" + todo + "</div>";
                        width = (onGoing / allTask) * 100;
                        htmlNewPBar += "<div class='progress-bar bg-warning text-dark pBarOnGoing' role='progressbar' style='width: " + width + "%' aria-valuenow='" + onGoing + "' aria-valuemin='0' aria-valuemax='" + allTask + "'>" + onGoing + "</div>";
                        width = (done / allTask) * 100;
                        htmlNewPBar += "<div class='progress-bar bg-success text-dark pBarDone' role='progressbar' style='width: " + width + "%' aria-valuenow='" + done + "' aria-valuemin='0' aria-valuemax='" + allTask + "'>" + done + "</div>";
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
                        $('.sprint[data-sprintid="' + sprintId + '"]').click();
                    } else {
                        whereModify = button.closest('.task');
                        whereModify.empty();
                        htmlToWrite += "<a class='btn btn-primary-outline pull-right removeTask' data-taskid='" + response + "' data-state='" + taskState +  "' type='button'><em class='fas fa-times' style='color:red' title='supprimer Tache'></em> </a>"
                        htmlToWrite += "<a data-target='#createOrModifyTaskModal' data-toggle='modal' class='modalLink' style='cursor:pointer'"
                        htmlToWrite += " data-memberid='" + taskMember + "' data-name='" + taskName + "' data-description='" + taskDescription + "' data-dod='" + taskDod + "' data-time='" + taskTime + "' data-sprintid='" + sprintId + "' data-pred='" + taskPredecessor + "' data-id='" + response + "' data-state='" + taskState + "' >"
                        htmlToWrite += "<div class='card-header'>" + taskName + "</div>";
                        htmlToWrite += "</a>"
                        htmlToWrite += "<div class='card-body'>" + taskDescription + "</div>";
                        htmlToWrite += "<div class='row switchDiv'>"

                        if (taskState === "onGoing") {
                            where = ".Doing";
                            htmlToWrite += "<a class='col-lg-6 float-left switchArrow' data-from='onGoing' data-target='todo' data-taskid='" + response + "'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='passer la tache en Todo' ></em></a>"
                            htmlToWrite += "<a class='col-lg-6 float-right switchArrow' data-from='onGoing' data-target='done' data-taskid='" + response + "'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Done' ></em></a>"
                        } else if (taskState === "todo") {
                            where = ".Todo";
                            htmlToWrite += "<a class='col-lg-12 float-right switchArrow' data-from='todo' data-target='onGoing' data-taskid='" + response + "'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Doing' ></em></a>"
                        } else if (taskState === "done") {
                            where = ".Done";
                            htmlToWrite += "<a class='col-lg-12 float-left switchArrow' data-from='done' data-target='onGoing' data-taskid='" + response + "'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='Accéder au projet' ></em></a>"
                        }
                        htmlToWrite += "</div>"
                        htmlToWrite += "</div>"

                        $(whereModify).append(htmlToWrite);
                        $('.sprint[data-sprintid="' + sprintId + '"]').click();
                    }
                },
            });
        });
    });
</script>