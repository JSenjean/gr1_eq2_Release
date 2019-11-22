<div class="modal fade" id="createOrModifySprintModal" tabindex="-1" role="dialog" aria-labelledby="createOrModifySprintModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOrModifySprintModalLabel">Ajouter un sprint</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCross">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" data-toggle="validator" action="index.php?action=addSprint" id="CreateNewSprint">
                    <div class="form-group">
                        <label for="sprintName"> Nom du sprint : </label>
                        <input type="text" classe="sprintName" id="sprintName" maxlength="50 " name="sprintName" required>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class='row'>
                                <div class="col">
                                    <p>Date de début :</p>
                                    <input type="date" class="form-control startDate" id="startDate" name="startDate" value="<?php $curDate = date("Y-m-d");
                                                                                                                    echo $curDate; ?>" required />
                                </div>
                                <div class="col">
                                    <p>Date de Fin :</p>
                                    <input type="date" class="form-control endDate" id="endDate" name="endDate" value="<?php echo $curDate; ?>" required />
                                </div>
                                <div>
                                    <input type="hidden" id="projectID" name="projectID" value="<?php echo $projectId ?>" required />
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button id="validate" type="input" class="btn btn-primary validate">Valider</button>
            </div>
            </form>-
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var projectId = null;
        var sprintId = null;
        var name = null;
        var modify = false;
        var start = null;
        var end = null;

        $("#createOrModifySprintModal").on("shown.bs.modal", function(event) {
            var button = $(event.relatedTarget);
            projectId = button.data('projectid');
            
            if (typeof button.data('name') != 'undefined') {
                sprintId = button.data('sprintid');
                name = button.data('name');
                start = button.data('start');
                end = button.data('end');
                modify = true;
            } else {
                start = button.data('date');
                end = button.data('date');
                var name = "";
                modify = false;
            }

            $("#sprintName").val(name);
            $("#startDate").val(start);
            $("#endDate").val(end);
        });
    });
</script>