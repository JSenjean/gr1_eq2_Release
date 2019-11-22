<div class="modal fade" id="NewTestModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTestModal">Ajouter un test</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCross">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" data-toggle="validator" id="postNewTest">
                    <div class="form-group">
                        <label for="testName">Intitulé du test : </label>
                        <input type="text" required name="testName" id="testName" maxlength="50 ">
                    </div>
                    <div class="form-group">
                        <label for="testDescription">Description : </label>
                        <textarea type="textarea" class="form-control" required name="testDescription" id="testDescription"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="testState">État :</label>
                        <select class="form-control" required name="testState" id="testState">
                            <option value="never_run">Jamais exécuté</option>
                            <option value="passed">Passé</option>
                            <option value="failed">Échoué</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="confirmNewTest">Valider</button>
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
    $('#testState').on('changed.bs.select', function(event, clickedIndex) {
        alert(clickedIndex);
    });

    $('#postNewTest').on('submit', function(event) {
        event.preventDefault(); // Prevent page from reloading

        $.ajax({
            type: "POST",
            url: 'index.php?action=tests',
            data: {
                projectId: projectId,
                manageTest: 'add',
                name: $("#testName").val(),
                description: $("#testDescription").val(),
                state: $("#testState").val()
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
