<div id="progressBar">
    <div class="card mt-4">
        <div class="card-body">
            <div class="progress">
                <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $percTodo ?>%" aria-valuenow="<?php echo $percTodo ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percTodo ?>%</div>
                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percDeprecated ?>%" aria-valuenow="<?php echo $percDeprecated ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percDeprecated ?>%</div>
                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percDone ?>%" aria-valuenow="<?php echo $percDone ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percDone ?>%</div>
            </div>
        </div>
    </div>
</div>     