<div class="modal fade" id="EditTestModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTestModal">Modifier le test</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeCrossEdit">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" data-toggle="validator" id="postEditedTest">
                    <div class="form-group">
                        <label for="testName">Intitulé du test : </label>
                        <input type="text" required name="testName" id="testNameEdit" maxlength="50 ">
                    </div>
                    <div class="form-group">
                        <label for="testDescription">Description : </label>
                        <textarea type="textarea" class="form-control" required name="testDescription" id="testDescriptionEdit"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="testState">État :</label>
                        <select class="form-control" required name="testState" id="testStateEdit">
                            <option value="never_run">Jamais exécuté</option>
                            <option value="passed">Passé</option>
                            <option value="failed">Échoué</option>
                            <option value="deprecated">Déprécié</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="confirmEditedTest">Valider</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {
    
    var testId = null;
    var testName = null;
    var testDescription = null;
    var testState = null;

    $('#EditTestModal').on('show.bs.modal', function (e) {
        testId = $(e.relatedTarget).attr('data-id');
        testName = $(e.relatedTarget).attr('data-name');
        testDescription = $(e.relatedTarget).attr('data-description');
        testState = $(e.relatedTarget).attr('data-state');
        $('input#testNameEdit').val(testName);
        $('textarea#testDescriptionEdit').val(testDescription);
        $('select#testStateEdit').val(testState);
    });

    $('#postEditedTest').on('submit', function(event) {
        event.preventDefault(); // Prevent page from reloading
        
        $.ajax({
            type: "POST",
            url: 'index.php?action=tests',
            data: {
                manageTest: 'edit',
                id: testId,
                name: $("#testNameEdit").val(),
                description: $("#testDescriptionEdit").val(),
                state: $("#testStateEdit").val()
            },
            success: function(response) {
                refreshDiv(response);
                if (response != testState){ // Refresh old div if state has changed
                    refreshDiv(testState);
                }
                refreshProgressBar();
                $('#closeCrossEdit').click();
            }
        })

    })
})

</script>
