<div class="modal fade" id="DeleteTestModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTestModal">Supprimer le test</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCrossDelete">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Souhaitez-vous supprimer ce test ? Cette action est irréversible.         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDeleteTest">Confirmer</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    var testId = null;
    var testState = null;

    $('#DeleteTestModal').on('show.bs.modal', function (e) {
        testId = $(e.relatedTarget).attr('data-id');
        testState = $(e.relatedTarget).attr('data-state');
    });

    $('#confirmDeleteTest').on('click', function(event) {
        event.preventDefault(); // Prevent page from reloading

        $.ajax({
            type: "POST",
            url: 'index.php?action=tests',
            data: {
                id: testId,
                state: testState,
                manageTest: 'delete'
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