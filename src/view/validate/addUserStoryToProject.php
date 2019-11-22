<div class="modal fade" id="addOrModifyUSToProjectModal" tabindex="-1" role="dialog" aria-labelledby="addOrModifyUSToProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOrModifyUSToProjectModalLabel">Créer une nouvelle User story</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCrossUS">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" data-toggle="validator" action="index.php?action=backlog" id="newOrModifyUSForm">
                    <div class="form-inline">
                        <label for="USName">nom</label>
                        <input required class="form-control col-lg-2 ml-2" id="USName" name="USName" type="text">

                        <label class="ml-2" for="USRole">Rôle</label>
                        <select class="form-control ml-2" id="USRole" name="USRole">
                        </select>

                        <input class="form-check-input ml-2" type="checkbox" id="done">
                        <label class="form-check-label" for="done">
                            terminé ?
                        </label>
                    </div>


                    <div class="form-group m-1">
                        <label for="USICan"> je peux : </label>
                        <textarea type="textarea" class="form-control" id="USICan" name="USICan"></textarea>
                    </div>


                    <div class="form-group m-1">

                        <label for="USSoThat"> afin de : </label>
                        <textarea type="textarea" class="form-control" id="USSoThat" name="USSoThat"></textarea>
                    </div>


                    <div class="form-inline">
                        <div class="form-group row m-1">
                            <label for="USDifficulty">Effort :</label>
                            <select class="form-control" id="USDifficulty" name="USDifficulty">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="5">5</option>
                                <option value="8">8</option>
                                <option value="13">13</option>
                                <option value="21">21</option>
                                <option value="34">34</option>

                            </select>
                        </div>
                        <div class="form-group row m-1">
                            <label for="USWorkValue">Valeur métier :</label>
                            <select class="form-control" id="USWorkValue" name="USWorkValue">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="very high">Very high</option>
                            </select>
                        </div>
                    </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button id="confirmNewRole" type="input" class="btn btn-primary">Valider</button>
            </div>


            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        var writeEndTo = null;
        var roles = null;
        var projectId = null;
        var usName = null;
        var roleId = "0";
        var done = null;
        var usId;
        var iCan = null;
        var soThat = null;
        var difficulty = "1";
        var workValue = "low";

        var modify = false;
        $("#addOrModifyUSToProjectModal").on("shown.bs.modal", function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            projectId = button.data('projectid');
            writeEndTo = button.data('writeendto');
            writeEndTo = '#' + writeEndTo;
            modify=false;
            if (typeof button.data('userstoryid') != 'undefined') { //if we are in a modification
                modify = true;
                usName = button.data('usname');
                roleId = (button.data('roleid')!='' ? button.data('roleid') : "0") ;
                done = button.data('done');
                usId = button.data('userstoryid');
                iCan = button.data('ican');
                soThat = button.data('sothat');
                difficulty = button.data('effort');
                workValue = button.data('priority');
            }
            else
            {
                 usName = null;
                 roleId = "0";
                 done = null;
                 iCan = null;
                 soThat = null;
                 difficulty = "1";
                 workValue = "low";
            }
            $.ajax({
                type: 'POST',
                url: 'index.php?action=backlog',
                data: {
                    projectIdToModifyUS: projectId,
                    allRole: "exist"
                },
                success: function(response) {
                    $("#USRole").empty();
                    roles = JSON.parse(response);
                    $('#USRole').append($('<option>', {
                        value: 0,
                        text: "choisissez un role"
                    }));
                    $.each(roles, function(i, role) {
                        $('#USRole').append($('<option>', {
                            value: role.id,
                            text: role.name
                        }));
                    });
                    //put all the value inside input and select
                    $("#USName").val(usName);
                    $('#USRole').val(roleId);
                    $("#done").prop("checked", done == "1");
                    $("#USICan").val(iCan);
                    $("#USSoThat").val(soThat);
                    $("#USDifficulty").val(difficulty);
                    $("#USWorkValue").val(workValue);
                },

            })

        })

        $("#newOrModifyUSForm").submit(function(event) {
            event.preventDefault();
             usName = $("#USName").val();
             roleId = $("#USRole option:selected").val()
             roleName = $("#USRole option:selected").text()
             done = $("#done").is(':checked');
             iCan = $("#USICan").val();
             soThat = $("#USSoThat").val();
             difficulty = $("#USDifficulty option:selected").val()
             workValue = $("#USWorkValue option:selected").val()
            $.ajax({
                type: 'POST',
                url: 'index.php?action=backlog',
                data: {
                    projectIdToModifyUS: projectId,
                    name: usName,
                    roleId: roleId,
                    done: done,
                    iCan: iCan,
                    soThat: soThat,
                    difficulty: difficulty,
                    workValue: workValue,
                    usId: usId,
                    modify:modify

                },
                success: function(response) {
                    console.log(response);
                    rolename = (roleName == "choisissez un role" ? "pas de role" : roleName);

                    done = (done ? 1:0);
                    var htmlToWrite = '';
                    if (!modify)
                        htmlToWrite += '<div class="col-lg-4 usTop" id="US' + response + '">'
                    htmlToWrite += '<div class="userstory">'
                    htmlToWrite += '<div class="userstory-front">'
                    htmlToWrite += '<img src="http://placehold.it/110x110/85D9E8/000?text=' + usName + '" class="img-fluid" />'
                    htmlToWrite += '<p>effort: ' + difficulty + ' / Priorité: ' + workValue + ' </p>'
                    htmlToWrite += '<p>' + rolename + '</p>'
                    htmlToWrite += '</div>'
                    htmlToWrite += '<div class="userstory-back">';
                    htmlToWrite += '<div class="row">';
                    htmlToWrite += '<div class="col">'
                    htmlToWrite += '<button data-target="#addOrModifyUSToProjectModal" data-toggle="modal" class="btn btn-primary-outline" ' 
                    htmlToWrite += 'data-projectid="' + projectId + '" ' 
                    htmlToWrite += 'data-userstoryid="' + response + '" ' 
                    htmlToWrite += 'data-usname="' + usName + '" ' 
                    htmlToWrite += 'data-roleid="' + roleId + '"  '
                    htmlToWrite += 'data-done="' + done + '" '
                    htmlToWrite += 'data-effort="' + difficulty + '" ' 
                    htmlToWrite += 'data-priority="' + workValue + '" '
                    htmlToWrite += 'data-ican="' + iCan + '" '
                    htmlToWrite += 'data-sothat="' + soThat + '" '
                    htmlToWrite += 'data-writeEndTo="US' + response + '" type="button">'
                    htmlToWrite += '<em class="fas fa-pen" style="color:blue" title="Modifier US"></em>'
                    htmlToWrite += '</div>'
                    htmlToWrite += '<div class="col">'
                    htmlToWrite += '<button class="btn btn-primary-outline float-right removeUsButton" data-userstoryid="' + response + '"type="button">'
                    htmlToWrite += '<em class="fas fa-times" style="color:red" title="Modifier US"></em>'
                    htmlToWrite += '</div>'
                    htmlToWrite += '</div>'
                    htmlToWrite += '<span>'
                    htmlToWrite += '<p><strong>En tant que</strong> ' + rolename + '</p>'
                    htmlToWrite += '</span>'
                    htmlToWrite += '<span>'
                    htmlToWrite += '<p><strong>Je peux</strong> ' + iCan + '</p>'
                    htmlToWrite += '</span>'
                    htmlToWrite += '<span>'
                    htmlToWrite += '<p><strong>Afin De </strong> ' + soThat + '</p>'
                    htmlToWrite += '</span>'
                    htmlToWrite += '</div>'
                    htmlToWrite += '</div>'
                    if (!modify)
                        htmlToWrite += '</div>'

                    if (modify)
                        $(writeEndTo).empty();
                    modify=false;
                    $(writeEndTo).append(htmlToWrite);
                    $('#closeCrossUS').click();
                },

            })

        })

        $("#addOrModifyUSToProjectModal").on("hidden.bs.modal", function(event) {
            modify=false;
            })


    })
    
</script>