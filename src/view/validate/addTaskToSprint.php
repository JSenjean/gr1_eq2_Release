<div class="modal fade" id="createOrModifyTaskModal" tabindex="-1" role="dialog" aria-labelledby="createOrModifyTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOrModifyTaskModalLabel">Créer une tâche</h5>
                <button type="button" class="close closeCrossTask" data-dismiss="modal" aria-label="Close" id="closeCrossTask">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" data-toggle="validator addNewTask" action="index.php?action=sprints" id="addNewTask">
                    <div class="form-group">
                        <label for="taskName"> Nom de la tâche : </label>
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
        });

        $("#addNewTask").on('submit', function(event) {
            event.preventDefault();


            taskName = $("#taskName").val();
            taskDescription = $("#taskDescription").val();
            taskDod = $("#taskDod").val();;
            taskPredecessor = $("#taskPredecessor").val();
            taskMember = $('#taskMember').val();;
            taskTime = $("#taskTimeValue").val();;

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
                    projectId: projectId
                },
                success: function(response) {
                    $('#closeCrossTask').click();
                    var htmlToWrite = "";
                    var where = "";
                    var whereModify = null;
                    if (!modify) {
                        htmlToWrite += "<div class='card mt-2 task' data-taskid='" + response + "'  >"
                    } else {
                        whereModify = button.closest('.task');
                        whereModify.empty();
                    }
                    htmlToWrite += "<a class='btn btn-primary-outline pull-right removeTask' data-taskid='" + response + "' type='button'><em class='fas fa-times' style='color:red' title='supprimer Tache'></em> </a>"
                    htmlToWrite += "<a data-target='#createOrModifyTaskModal' data-toggle='modal' class='modalLink' style='cursor:pointer'"
                    htmlToWrite += " data-memberid='" + taskMember + "' data-name='" + taskName + "' data-description='" + taskDescription + "' data-dod='" + taskDod + "' data-time='" + taskTime + "' data-sprintid='" + sprintId + "' data-pred='" + taskPredecessor + "' data-id='"+ response + "' data-state='" + taskState + "' >"
                    htmlToWrite += "<div class='card-header'>" + taskName + "</div>";
                    htmlToWrite += "</a>"
                    htmlToWrite += "<div class='card-body'>" + taskDescription + "</div>";
                    htmlToWrite += "<div class='row switchDiv'>"

                    if (taskState === "onGoing") {
                        where = ".Doing";
                        htmlToWrite += "<a class='col-lg-6 float-left switchArrow' data-target='todo' data-taskid='"+ response +"'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='passer la tache en Todo' ></em></a>"
                        htmlToWrite += "<a class='col-lg-6 float-right switchArrow' data-target='done' data-taskid='"+ response +"'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Done' ></em></a>"
                    } else if (taskState === "todo") {
                        where = ".Todo";
                        htmlToWrite += "<a class='col-lg-12 float-right switchArrow' data-target='onGoing' data-taskid='"+ response +"'><em class='fas fa-arrow-alt-circle-right' style='color:green ; cursor:pointer' title='passer la tache en Doing' ></em></a>"
                    } else if (taskState === "done") {
                        where = ".Done";
                        htmlToWrite += "<a class='col-lg-12 float-left switchArrow' data-target='onGoing' data-taskid='"+ response +"'><em class='fas fa-arrow-alt-circle-left' style='color:green ; cursor:pointer' title='Accéder au projet' ></em></a>"
                    }
                    htmlToWrite += "</div>"
                    htmlToWrite += "</div>"
                    
                    if (modify) {
                        whereModify.append(htmlToWrite);
                    } else {
                        $(where).append(htmlToWrite);
                    }
                },
            });
        });
    });
</script>
