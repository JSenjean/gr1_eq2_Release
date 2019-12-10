<div class="modal fade" id="DeleteDocModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDocModal">Supprimer cette documentation ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCrossDelete">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Souhaitez-vous supprimer cette section de documentation ? Cette action est irréversible.         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDeleteDoc">Confirmer</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    var docId = null;
    var docState = null;

    $('#DeleteDocModal').on('show.bs.modal', function (e) {
        docId = $(e.relatedTarget).attr('data-id');
        docState = $(e.relatedTarget).attr('data-state');
    });

    $('#confirmDeleteDoc').on('click', function(event) {
        event.preventDefault(); // Prevent page from reloading

        $.ajax({
            type: "POST",
            url: 'index.php?action=doc',
            data: {
                id: docId,
                state: docState,
                manageDoc: 'delete'
            },
            success: function(response) {
                refreshDiv(response);
                refreshProgressBar();
                $('#closeCrossDelete').click();
            }
        })
    })
})
</script>