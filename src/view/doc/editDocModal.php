<div class="modal fade" id="EditDocModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDocModal">Modifier la section de documentation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCrossEdit">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" data-toggle="validator" id="postEditedDoc">
                    <div class="form-group">
                        <label for="docName">Intitulé de la section de documentation : </label>
                        <input type="text" required name="docName" id="docNameEdit" maxlength="50 ">
                    </div>
                    <div class="form-group">
                        <label for="docDescription">Description : </label>
                        <textarea type="textarea" class="form-control" required name="docDescription" id="docDescriptionEdit"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="docState">État :</label>
                        <select class="form-control" required name="docState" id="docStateEdit">
                            <option value="todo">A faire</option>
                            <option value="done">Faite</option>
                            <option value="deprecated">Dépréciée</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="confirmEditedDoc">Valider</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {
    
    var docId = null;
    var docName = null;
    var docDescription = null;
    var docState = null;

    $('#EditDocModal').on('show.bs.modal', function (e) {
        docId = $(e.relatedTarget).attr('data-id');
        docName = $(e.relatedTarget).attr('data-name');
        docDescription = $(e.relatedTarget).attr('data-description');
        docState = $(e.relatedTarget).attr('data-state');
        $('input#docNameEdit').val(docName);
        $('textarea#docDescriptionEdit').val(docDescription);
        $('select#docStateEdit').val(docState);
    });

    $('#postEditedDoc').on('submit', function(event) {
        event.preventDefault(); // Prevent page from reloading
        
        $.ajax({
            type: "POST",
            url: 'index.php?action=doc',
            data: {
                manageDoc: 'edit',
                id: docId,
                name: $("#docNameEdit").val(),
                description: $("#docDescriptionEdit").val(),
                state: $("#docStateEdit").val()
            },
            success: function(response) {
                refreshDiv(response);
                if (response != docState){ // Refresh old div if state has changed
                    refreshDiv(docState);
                }
                refreshProgressBar();
                $('#closeCrossEdit').click();
            }
        })

    })
})

</script>
