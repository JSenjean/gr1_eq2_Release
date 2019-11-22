<div id="progressBar">
    <div class="card mt-4">
        <div class="card-body">
            <div class="progress">
                <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $percFailed ?>%" aria-valuenow="<?php echo $percFailed ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percFailed ?>%</div>
                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percDeprecated ?>%" aria-valuenow="<?php echo $percDeprecated ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percDeprecated ?>%</div>
                <div class="progress-bar bg-secondary" role="progressbar" style="width: <?php echo $percNeverRun ?>%" aria-valuenow="<?php echo $percNeverRun ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percNeverRun ?>%</div>
                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percPassed ?>%" aria-valuenow="<?php echo $percPassed ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percPassed ?>%</div>
            </div>
        </div>
    </div>
</div>     