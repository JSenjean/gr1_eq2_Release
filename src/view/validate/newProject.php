<div class="modal fade" id="NewProjectModal" tabindex="-1" role="dialog" aria-labelledby="deleteProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProjectModalLabel">Créer un nouveau projet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" data-toggle="validator" action="index.php?action=newProject">
                    <div class="form-group">
                        <label for="projectName"> Nom du projet : </label>
                            <input type="text" id="projectName" maxlength="50 " name="projectName" required>
                    </div>
                    <div class="form-group">
                        <label for="projectDescription"> Description : </label>
                            <textarea required  type="textarea" class="form-control"id="projectDescription" name="projectDescription"></textarea>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="visibility" checked name="visibility">
                        <label for="visibility"> Public ?</label>
                            
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button id="confirmNewProject" type="input" class="btn btn-primary">Valider</button>
               
            </div>
            </form>
        </div>
    </div>
</div>
