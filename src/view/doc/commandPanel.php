
<div class="card mt-4">
    <div class="card-body">
        <div class="row">
        
            <div class="col-sm">
                <h4>Filtres</h4>
                <div class="custom-control custom-switch">
                    <input type="checkbox" href="#failed" data-toggle="collapse" class="custom-control-input" id="displayfailed" checked>
                    <label for="displayfailed" class="custom-control-label">A faire</label>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" href="#deprecated" data-toggle="collapse" class="custom-control-input" id="displaydeprecated" checked>
                    <label for="displaydeprecated" class="custom-control-label">Dépréciées</label>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" href="#passed" data-toggle="collapse" class="custom-control-input" id="displaypassed" checked>
                    <label for="displaypassed" class="custom-control-label">Terminées</label>
                </div>
            </div>

            <div class="col-sm">
                <h4 class="text-dark card-link">Gestion</h4>
                <a role="button" class="btn btn-primary mb-4 mr-2 confirmNewDocModalLink" data-target='#NewDocModal' href='#' data-toggle="modal">
                    Ajouter une nouvelle documentation
                </a>
                <br>
                <a role="button" class="btn btn-success mb-4 mr-2 confirmPassAllDoc" data-target='#PassAll' href='#' data-toggle="modal">
                    Marquer toutes les documentations comme terminées
                </a>
            </div>
            
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">