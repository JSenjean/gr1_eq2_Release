<div class="modal fade" id="PassAll" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passAllModal">Marquer toutes les sections de documentation comme terminées</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCross">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Souhaitez-vous vraiment tout marquer comme terminé ? La date de dernière mise à jour sera actualisée.         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" id="confirmPassAll">Valider</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>

var projectId=<?php echo $projectId ?>;

$(document).ready(function() {

    $('#confirmPassAll').on('click', function(event) {
        event.preventDefault(); // Prevent page from reloading

        $.ajax({
            type: "POST",
            url: 'index.php?action=doc',
            data: {
                projectId: projectId,
                manageDoc: 'doneAll'
            },
            success: function(response) {
                refreshDiv('todo');
                refreshDiv('deprecated');
                refreshDiv('done');
                refreshProgressBar();
            }
        })
    })
})

</script>
