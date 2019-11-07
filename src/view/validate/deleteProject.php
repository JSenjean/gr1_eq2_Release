<div class="modal fade" id="deleteProjectModal" tabindex="-1" role="dialog" aria-labelledby="deleteProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProjectModalLabel">Suppression d'un projet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Vous êtes sur le point de supprimer un projet, cette action est irréversible, aucun retour en arrière n'est possible, voulez-vous continuer ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button id="confirmDeleteProject"type="button" class="btn btn-primary">Valider</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    var theHREF;

    $(".confirmDeleteProjectModalLink").click(function(e) {
        e.preventDefault();
        theHREF = $(this).attr("href");
        $("#deleteProjectModal").modal("show");
    });


    $("#confirmDeleteProject").click(function(e) {
        window.location.href = theHREF;
    });
});
</script>