<div class="modal fade" id="inviteToProjectModal" tabindex="-1" role="dialog" aria-labelledby="inviteToProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProjectModalLabel">Ajouter des membres</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCross">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body ui-front">
                <form method="POST" data-toggle="validator" action="index.php?action=newProject" id='addUserForm'>
                    <div class="form-group ">
                        <label for="userName"> Nom de l'utilisateur : </label>
                        <input type="text" id="userName" maxlength="50 " name="userName">
                        <button type="button" class="btn btn-secondary" id="addUser" name="addUser">Ajouter</button>
                    </div>
                    <div class="form-group" id="userAdding">

                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeButton">Annuler</button>
                <button id="confirmInviteToProject" class="btn btn-primary">Valider</button>

            </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        var users = [];
        var projectId;
        var usersPick = [];
        var nbUser = 0;
        $("#inviteToProjectModal").on("show.bs.modal", function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            projectId = button.data('projectid') // Extract info from data-* attributes

            $.ajax({
                type: 'POST',
                url: 'index.php?action=utility',
                data: {
                    projectIdToAdd: projectId
                },
                success: function(response) {


                    users = JSON.parse(response);
                },

            });
        });
        $(document).ajaxStop(function() {
            var userForAutocomplete = [];
            users.forEach(function(element) {
                userForAutocomplete.push(element[0]);
            })


            $("#addUser").click(function(e) {

                var currentName = $("#userName").val();
                nameIndex = userForAutocomplete.indexOf(currentName);
                if (nameIndex !== -1) {
                    $("#userAdding").append('<span class="bg-success m-1 rounded" id="' + nbUser + '"><span class="text-white m-2 ">' + $("#userName").val() + '<a href="#"><i class="fas fa-times removeUser" style="color:white ;cursor:pointer" id="' + nbUser + '"></i></a></span></span>');
                    nbUser++;
                    usersPick.push(currentName);
                    $("#userName").val('');
                    //remove the user chose from the userForAutocomplete
                    userForAutocomplete.splice(nameIndex, 1);
                    $("#userName").autocomplete("option", "source", userForAutocomplete);
                } else {
                    alert("cet utilisateur n'existe pas ")
                }

            });

            // when you click on cross for delete user remove the user in the modal
            $(document).on("click", ".removeUser", function(e) {
                userRemove = $(this).parent().parent().text()
                userForAutocomplete.push((userRemove));
                indexOfUserToRemove = usersPick.indexOf[userRemove];
                usersPick.splice(indexOfUserToRemove, 1);
                $('span[id=' + $(this).attr('id') + ']').remove();
            })
            $("#userName").autocomplete({
                source: userForAutocomplete
            });


            $("#confirmInviteToProject").click(function(e) {
                if(usersPick.length>0)
                {
                $.ajax({
                type: 'POST',
                url: 'index.php?action=utility',
                data: {
                    usersToAdd: usersPick,
                    projectId: projectId
                },
                success: function(response) {
                   $('#closeCross').click();
                },

            });
                }
                else{
                    alert("vous n'avez pas choisi d'utilisateurs")
                }
            });
            $("#closeCross, #closeButton").click(function(event){
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

            })

        })
    })
</script>