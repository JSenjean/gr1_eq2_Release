
<div class="card mt-4">
    <div class="card-body">
        <div class="row">
        
            <div class="col-sm">
                <h4>Filtres</h4>
                <div class="custom-control custom-switch">
                    <input type="checkbox" href="#failed" data-toggle="collapse" class="custom-control-input" id="displayfailed" checked>
                    <label for="displayfailed" class="custom-control-label">Échoués</label>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" href="#deprecated" data-toggle="collapse" class="custom-control-input" id="displaydeprecated" checked>
                    <label for="displaydeprecated" class="custom-control-label">Dépréciés</label>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" href="#neverrun" data-toggle="collapse" class="custom-control-input" id="displayneverrun" checked>
                    <label for="displayneverrun" class="custom-control-label">Jamais lancés</label>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" href="#passed" data-toggle="collapse" class="custom-control-input" id="displaypassed" checked>
                    <label for="displaypassed" class="custom-control-label">Passés</label>
                </div>
            </div>

            <div class="col-sm">
                <h4 class="text-dark card-link">Gestion</h4>
                <a role="button" class="btn btn-primary mb-4 mr-2 confirmNewTestModalLink" data-target='#NewTestModal' href='#' data-toggle="modal">
                    Ajouter un nouveau test
                </a>
                <br>
                <a role="button" class="btn btn-success mb-4 mr-2 confirmPassAll" data-target='#PassAll' href='#' data-toggle="modal">
                    Marquer tous les tests comme passés
                </a>
            </div>
            
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">