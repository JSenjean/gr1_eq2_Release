<div class="modal fade" id="addOrModifyRoleToProjectModal" tabindex="-1" role="dialog" aria-labelledby="addOrModifyRoleToProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOrModifyRoleToProjectModalLabel">Créer un nouveau rôle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCross">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" data-toggle="validator" action="index.php?action=backlog" id="newOrModifyRoleForm">
                    <div class="form-group">
                        <label for="roleName"> Titre du rôle : </label>
                        <input type="text" id="roleName" maxlength="50 " name="roleName" required>
                    </div>
                    <div class="form-group">
                        <label for="roleDescription"> Description : </label>
                        <textarea required type="textarea" class="form-control" id="roleDescription" name="roleDescription"></textarea>
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
        var projectId=null;
        var roleName=null;
        var roleDescription=null;
        var writeEndTo=null;
        var modify=false;
        var roleId;
        $("#addOrModifyRoleToProjectModal").on("shown.bs.modal", function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
                projectId = button.data('projectid'); // Extract info from data-* attributes
                writeEndTo = button.data('writeendto');
                writeEndTo = '#' + writeEndTo;

            if (typeof button.data('roleid') != 'undefined') {
                modify = true;
                roleId = button.data('roleid')

                $("#roleName").val(button.data('rolename'));
                $("#roleDescription").val(button.data('roledescription'));

            } else {
                $("#roleName").val('');
                $("#roleDescription").val('');
            }

        })

        $("#newOrModifyRoleForm").submit(function(event) {
                event.preventDefault();
                var roleName = $("#roleName").val();
                var roleDescription = $("#roleDescription").val();
                $.ajax({
                        type: 'POST',
                        url: 'index.php?action=backlog',
                        data: {
                            projectIdToModifyRole: projectId,
                            roleName: roleName,
                            roleDescription: roleDescription,
                            roleId:roleId,
                            modify:modify
                        },
                        success: function(response) {
                                var htmlToWrite= '';
                                if(!modify)
                                htmlToWrite += '<div class="card" id="card' +response+'">'
                                htmlToWrite += '<div class="card-header" id="heading' + response + '">'
                                htmlToWrite += '<h5 class="mb-0">'
                                htmlToWrite += '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse' + response + '" aria-expanded="true" aria-controls="collapse' + response + '">'
                                htmlToWrite += roleName
                                htmlToWrite += '</button>'
                                htmlToWrite += '</h5>'
                                htmlToWrite += '</div>';
                                htmlToWrite += '<div id="collapse' + response + '" class="collapse" aria-labelledby="heading' + response + '" data-parent="' + writeEndTo + '">'
                                htmlToWrite += '<div class="card-body">'
                                htmlToWrite += roleDescription
                                htmlToWrite += '</div>'
                                htmlToWrite += '<div class="card-footer">'
                                htmlToWrite += '<button type="button" class="btn btn-danger removeRoleButton" data-roleid="' + response + '">'
                                htmlToWrite += 'Suppprimer'
                                htmlToWrite +=  '</button>'
                                htmlToWrite += '<button type="button" class="btn btn-primary" data-target="#addOrModifyRoleToProjectModal" data-toggle="modal" class="addOrModifyRoleToProjectLink" data-roleid="' + response + '" data-rolename="' + roleName + '" data-roleDescription="' + roleDescription + '" data-projectid="' + projectId + '" data-writeEndTo="card' + response + '">'
                                htmlToWrite += 'Modifier'
                                htmlToWrite += '</button>'
                                htmlToWrite += '</div>'
                                htmlToWrite += '</div>'
                                if(!modify)
                                htmlToWrite += '</div>'

                                if(modify)
                                $(writeEndTo).empty();
                                $(writeEndTo).append(htmlToWrite);
                                modify=false;
                                
                                $('#closeCross').click();
                            

                    },

                });
        });

        $("#addOrModifyRoleToProjectModal").on("hidden.bs.modal", function(event) {
            modify=false;
            })


    })
</script>