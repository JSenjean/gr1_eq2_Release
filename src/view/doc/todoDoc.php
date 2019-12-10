<div id="addtodo">
    <div class="collapse show" id="neverrun">
        <?php foreach ($docTodo as $d) {  
            $id = $d['id'];
            $name = $d['name'];
            $description = $d['description'];
            $state = $d['state'];
        ?>
            <div class="card border-secondary mt-1" style="border: 1.5px solid;">
                <div class="card-body" data-toggle="collapse" href="#collapse<?php echo $id; ?>">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title"> <?php echo $name; ?> </h5>
                        A faire
                        <div>
                            <a href="#" class="btn" data-id='<?php echo $id; ?>' data-state='<?php echo $state; ?>' id="passThisDocTodo<?php echo $id; ?>" data-type="passThisDocTodo">
                                <em class="fas fa-check" style="color:#20CF2D" alt="Pass"></em>
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

        $("[data-type='passThisDocTodo']").on('click', function(event) {
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
                    refreshDiv(docState);
                    refreshDiv('done');
                    refreshProgressBar();
                }
            })
        })

    })

</script>