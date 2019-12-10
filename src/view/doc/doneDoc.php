<div id="adddone">
    <div class="collapse show" id="passed">
        <?php foreach ($docDone as $d) { 
            $id = $d['id'];
            $name = $d['name'];
            $description = $d['description'];
            $state = $d['state'];
        ?>
            <div class="card border-success mt-1" style="border: 1.5px solid;">
                <div class="card-body" data-toggle="collapse" href="#collapse<?php echo $id; ?>">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title"> <?php echo $name; ?> </h5>
                        <span><p class="text-secondary" style="display: inline;">Faite&nbsp&nbsp</p> Dernière mise à jour le <?php echo date_format(date_create_from_format('Y-m-d', $d['last_update']), 'd M Y'); ?></span>
                        <div>
                            <a href="#" class="btn" data-id='<?php echo $id; ?>' data-state='<?php echo $state; ?>' id="passThisDoneDoc<?php echo $id; ?>" data-type="passThisDoneDoc">
                                <em class="fas fa-check" style="color:#20CF2D" alt="Pass"></em>
                            </a>
                            <a href="#" class="btn" data-id='<?php echo $id; ?>' data-state='<?php echo $state; ?>' id="failThisDoneDoc<?php echo $id; ?>" data-type="failThisDoneDoc">
                                <em class="fas fa-times" style="color:#C12F2F" alt="Fail"></em>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="collapse<?php echo $id; ?>">
                    <div class="card-body">
                        <?php echo $description; ?>
                    </div>
                    <a role="button" class="btn btn-danger mb-4 mr-2 float-right confirmDeleteDocModalLink" data-target='#DeleteDocModal' data-id='<?php echo $id; ?>' data-state='<?php echo $state; ?>' href='#' data-toggle="modal">Supprimer</a>
                    <a 
                        role="button" 
                        class="btn btn-primary mb-4 mr-4 float-right confirmEditDocModalLink" 
                        data-target='#EditDocModal' 
                        data-id='<?php echo $id; ?>'
                        data-name='<?php echo $name; ?>' 
                        data-description='<?php echo $description; ?>' 
                        data-state='<?php echo $state; ?>' 
                        href='#' 
                        data-toggle="modal"
                    >
                        Modifier
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>

    $(document).ready(function() {

        $("[data-type='failThisDoneDoc']").click(function(event) {
            event.preventDefault(); // Prevent page from reloading

            var docId = $(this).data('id');
            var docState = $(this).data('state');
        
            $.ajax({
                type: "POST",
                url: 'index.php?action=doc',
                data: {
                    id: docId,
                    manageDoc: 'deprecated'
                },
                success: function(response) {
                    refreshDiv(docState);
                    refreshDiv('deprecated');
                    refreshProgressBar();
                }
            })
        })

    })

    $(document).ready(function() { // Use only to refresh execution of the doc
        
        $("[data-type='passThisDoneDoc']").on('click', function(event) {
            event.preventDefault(); // Prevent page from reloading
            
            var docId = $(this).data('id');
            var docState = $(this).data('state');
        
            $.ajax({
                type: "POST",
                url: 'index.php?action=doc',
                data: {
                    id: docId,
                    manageDoc: 'done'
                },
                success: function(response) {
                    refreshDiv('done');
                    refreshProgressBar();
                }
            })
        })

    })

</script>