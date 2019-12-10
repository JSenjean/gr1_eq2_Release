<div class="modal fade" id="NewDocModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocModal">Ajouter une documentation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCross">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" data-toggle="validator" id="postNewDoc">
                    <div class="form-group">
                        <label for="docName">Intitulé de la section de documentation : </label>
                        <input type="text" required name="docName" id="docName" maxlength="50 ">
                    </div>
                    <div class="form-group">
                        <label for="docDescription">Description : </label>
                        <textarea type="textarea" class="form-control" required name="docDescription" id="docDescription"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="docState">État :</label>
                        <select class="form-control" required name="docState" id="docState">
                            <option value="todo">A faire</option>
                            <option value="done">Faite</option>
                            <option value="deprecated">Dépréciée</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="confirmNewDoc">Valider</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>

var projectId=<?php echo $projectId ?>;

$(document).ready(function() {

    // Script to make sure options appear in the right order in the state selector
    $('#docState').on('changed.bs.select', function(event, clickedIndex) {
        alert(clickedIndex);
    });

    $('#postNewDoc').on('submit', function(event) {
        event.preventDefault(); // Prevent page from reloading

        $.ajax({
            type: "POST",
            url: 'index.php?action=doc',
            data: {
                projectId: projectId,
                manageDoc: 'add',
                name: $("#docName").val(),
                description: $("#docDescription").val(),
                state: $("#docState").val()
            },
            success: function(response) {
                $('#closeCross').click();
                refreshDiv(response);
                refreshProgressBar()
            }
        })
    })
})

</script>
