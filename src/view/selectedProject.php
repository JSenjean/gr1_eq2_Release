<div class="row pt-5">

    <div class="col-sm">
        <div class="card">
            <div class="card-body">

                <div class="clearfix">
                    <h3 class="text-dark card-link">Gestion des membres</h1>
                        <?php if ($isMaster) { ?>
                            <br><a href="#" class="btn btn-primary">Ajouter des membres</a>
                        <?php } ?>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title mt-0">Membres</h5>
                        <div class="d-flex justify-content-between">
                            <?php foreach ($projectMaster as $pm) {
                                echo $pm['username'];
                                break;
                            }
                            if ($isMaster) { ?>
                                <a data-toggle="modal" data-target="#editInfoModal" class="btn">
                                    <em class='fas fa-crown' style="color:#F3E90A"></em>
                                </a>
                            <?php } else { ?>
                                <em class='fas fa-crown' style="color:#F3E90A"></em>
                            <?php } ?>
                        </div>
                        <?php
                        foreach ($members as $m) {
                            echo '<div class="d-flex justify-content-between">';
                            echo $m['username'] . '<br>';
                            if ($isMaster) {
                                echo '
                                    <a href="index.php?action=selectedProjectDeletedMember&projectId=' . $projectId . '&userId=' . $m['user_id'] . '" class="btn">
                                        <em class="fas fa-times" style="color:#C12F2F; padding-right:4px;" alt="Delete"></em>
                                    </a>
                                    ';
                            }
                            echo '</div>';
                        } ?>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Requêtes en attente</h5>
                        <?php foreach ($requests as $r) {
                            echo '<div class="d-flex justify-content-between">';
                            echo $r['username'] . '<br>';
                            if ($isMaster) {
                                echo '
                                <div>
                                    <a href="index.php?action=selectedProjectAcceptRequest&projectId=' . $projectId . '&userId=' . $r['user_id'] . '" class="btn">
                                        <em class="fas fa-check" style="color:#20CF2D" alt="Validate"></em>
                                    </a>
                                    <a href="index.php?action=selectedProjectDeleteInvitationOrRequest&projectId=' . $projectId . '&userId=' . $r['user_id'] . '" class="btn">
                                        <em class="fas fa-times" style="color:#C12F2F" alt="Deny"></em>
                                    </a>
                                </div>
                                ';
                            }
                            echo '</div>';
                        } ?>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Invitations envoyées</h5>
                        <?php foreach ($invitations as $i) {
                            echo '<div class="d-flex justify-content-between">';
                            echo $i['username'] . '<br>';
                            if ($isMaster) {
                                echo '
                                    <a href="index.php?action=selectedProjectDeleteInvitationOrRequest&projectId=' . $projectId . '&userId=' . $i['user_id'] . '" class="btn">
                                        <em class="fas fa-times" style="color:#C12F2F" alt="Cancel"></em>
                                    </a>
                                    ';
                            }
                            echo '</div>';
                        } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <br>

    <div class="col-sm">
        <div class="card">
            <div class="card-body">

                <div class="clearfix">
                    <h3 class="text-dark card-link">Suivi du projet</h1>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Sprints</h5>
                        <div class="progress mb-3" style="<?php echo ($countSprint != 0) ? "" : "display: none" ?>">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ($sDone/$countSprint)*100 ?>%" aria-valuenow="<?php echo $sDone ?>" aria-valuemin="0" aria-valuemax="<?php echo $countSprint ?>"><?php echo $sDone ?></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo ($sDoing/$countSprint)*100 ?>%" aria-valuenow="<?php echo $sDoing ?>" aria-valuemin="0" aria-valuemax="<?php echo $countSprint ?>"><?php echo $sDoing ?></div>
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo ($sUpcomming/$countSprint)*100 ?>%" aria-valuenow="<?php echo $sUpcomming ?>" aria-valuemin="0" aria-valuemax="<?php echo $countSprint ?>"><?php echo $sUpcomming ?></div>
                        </div>
                        <a href="#" class="btn btn-primary">Détails</a>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Tests</h5>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $percFailed ?>%" aria-valuenow="<?php echo $percFailed ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percFailed ?>%</div>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percDeprecated ?>%" aria-valuenow="<?php echo $percDeprecated ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percDeprecated ?>%</div>
                            <div class="progress-bar bg-secondary" role="progressbar" style="width: <?php echo $percNeverRun ?>%" aria-valuenow="<?php echo $percNeverRun ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percNeverRun ?>%</div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percPassed ?>%" aria-valuenow="<?php echo $percPassed ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percPassed ?>%</div>
                        </div>
                        <a href="index.php?action=tests&projectId=<?php echo $projectId ?>" class="btn btn-primary">Détails</a>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Documentation</h5>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-secondary" role="progressbar" style="width: <?php echo $percTodo ?>%" aria-valuenow="<?php echo $percTodo ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percTodo ?>%</div>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percDeprecatedDoc ?>%" aria-valuenow="<?php echo $percDeprecatedDoc ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percDeprecatedDoc ?>%</div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percDone ?>%" aria-valuenow="<?php echo $percDone ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percDone ?>%</div>
                        </div>
                        <a href="index.php?action=doc&projectId=<?php echo $projectId ?>" class="btn btn-primary">Détails</a>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <br>

    <div class="col-sm">
        <div class="card">
            <div class="card-body">

                <div class="clearfix">
                    <h3 class="text-dark card-link">Informations générales</h1>
                        <?php if ($isMaster) { ?>
                            <br><button type="button" class="btn btn-outline-primary btn-sm float-left" data-toggle="modal" data-target="#editInfoModal">Éditer</button>
                        <?php } ?>
                </div>

                <?php // Will be used later on with the edit info modal
                $id = $projectId;
                $name = 'Unknown Name';
                $description = 'Unknown Description';
                $visibility = -1;
                ?>

                <div class="card mt-4">
                    <div class="card-body">
                        <?php foreach ($project as $p) {
                            $name = $p['name'];
                            echo '<h5 style="display: inline">Nom : </h5><h6 style="display: inline">' . $name . '</h6><br><br>';
                            $description = $p['description'];
                            echo '<h5 style="display: inline">Description : </h5><br>' . $description . '<br><br>';
                            if ($p['visibility'] == 1) {
                                $visibility = 1;
                                $v = 'Public';
                            } else {
                                $visibility = 0;
                                $v = 'Privé';
                            }
                            echo '<h5 style="display: inline">Visibilité : </h5>' . $v;
                            break;
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- EDIT INFORMATION -->
    <div class="modal fade" id="editInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier les informations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" data-toggle="validator" action="index.php?action=editSelectedProject&projectId=<?php echo $projectId ?>">
                        <div class="form-group">
                            <label for="InputName">Nom</label>
                            <input type="textfield" class="form-control" id="InputName" name="name" value="<?php echo $name ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="InputDescription">Description</label>
                            <textarea type="textarea" class="form-control" id="InputName" name="description" required><?php echo $description ?></textarea>
                        </div>
                        <div class="form-group ml-4">
                            <input class="form-check-input" type="checkbox" id="InputVisiblity" <?php if ($visibility == 1) {
                                                                                                    echo ' checked ';
                                                                                                } ?> name="visibility" value="<?php echo $visibility ?>">
                            <label for="InputVisibility" name="visibility">Public ?</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </body>