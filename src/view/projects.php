<div class="row pt-5">

    <!-- Create and manage projects -->
    <div class="col-sm">
        <div class="card">
            <div class="card-body">

                <div class="clearfix">
                    <h1 class="text-dark card-link">Mes Projets</h1>
                    <a role="button" class="btn btn-primary mb-4 mr-2 confirmNewProjectModalLink" data-target='#NewProjectModal' href='index.php?action=newProject' data-toggle="modal">
                        Créer un projet
                    </a>
                </div>

                <div class="list-group">
                    <?php foreach ($projects as $u) { ?>

                        <div class="list-group-item flex-column align-items-start">
                            <div class="media">

                                <div class="media-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mt-0"><?php echo $u['name'] ?></h5>
                                        <h6 class="text-muted">
                                            <span class="font-weight-bold">
                                                <?php if ($u['role'] == 'master') { ?>
                                                    <em class='fas fa-crown' style="color:#F3E90A"></em>
                                                <?php } ?>
                                            </span>
                                        </h6>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <h6 class="text-muted">
                                            <span class="font-weight-bold">
                                                <?php if ($u['role'] == 'master') { ?>
                                                    <a  data-target='#inviteToProjectModal'  data-toggle="modal" class="inviteToProjectModalLink" data-projectid="<?php echo $u['id']; ?>">
                                                        <em class='fas fa-plus-square' style="color:blue ; cursor:pointer" data-toggle="tooltip" data-placement="top" title="Ajouter des membres"></em>
                                                    </a>
                                                    <a data-target='#deleteProjectModal' href='index.php?action=projectDelete&projectId=<?php echo $u['id']; ?>' data-toggle="modal" class="confirmDeleteProjectModalLink">
                                                        <em class='fas fa-trash' style="color:red; cursor:pointer" data-toggle="tooltip" data-placement="top" title="Supprimer projet"></em>
                                                    </a>
                                                <?php } else { ?>
                                                    <a  href='index.php?action=leaveProject&projectId=<?php echo $u['id']; ?>'>
                                                        <em class='fas fa-arrow-alt-circle-left	 ' style="color:red ; cursor:pointer" data-toggle="tooltip" data-placement="top" title="Quitter le projet"></em>
                                                    </a>
                                                <?php } ?>
                                            </span>
                                        </h6>
                                        <h6>
                                            <span class="font-weight-bold">
                                                <a href='index.php?action=selectedProject&projectId=<?php echo $u['id'];?>'>
                                                    <em class='fas fa-arrow-alt-circle-right	 ' style="color:green ; cursor:pointer" data-toggle="tooltip" data-placement="top" title="Accéder au projet"></em>
                                                </a>
                                            </span>
                                        </h6>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <?php } ?>

                </div>

            </div>
        </div>
    </div>

    <br>

    <!-- Search a project -->
    <div class="col-sm">
        <div class="card">
            <div class="card-body">

                <div class="clearfix">

                    <h1 class="text-dark card-link">Rechercher un projet</h1>
                    <input class="form-control" type="text" placeholder="Rechercher Projet" aria-label="Search" id="myInputSearch">
                    <br>

                    <div class="list-group" id="projectSearchList">
                        <?php foreach ($otherProjects as $u) {
                            $name = $u['name'];
                            if ($u['visibility'] == 1) { ?>
                                <div class="list-group-item flex-column align-items-start" id="oneProject">
                                    <div class="media">

                                        <div class="media-body" id="<?php echo $name; ?>">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="mt-0" id="projectName<?php echo $name; ?>"><?php echo $name; ?></h5>
                                                <h6 class="test-muted">
                                                    <span class="font-weight-bold">Chef du projet : </span>
                                                    <?php echo $u['username']; ?>
                                                </h6>
                                            </div>
                                            <br>
                                            <div class="d-flex justify-content-between" id="test">
                                                <h6 class="text-muted">
                                                    <span class="font-weight-bold" id="buttonJoinSpan">
                                                        <button type="button" role="button" class="btn btn-success mb-4 mr-2 askForInvitationButton" data-target='#JoinProject' href='' data-toggle="modal" id="<?php echo $u[0]; ?>">
                                                            Demander à rejoindre
                                                        </button>
                                                    </span>
                                                </h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    </body>

    </html>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("#myInputSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#projectSearchList #oneProject").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });


        $(document).ready(function() {     
            $(".askForInvitationButton").click(function() {
                console.log($(this).attr('id'));
                var buttonRequest = $(this);
                
                
                $.ajax({
                    type: 'POST',
                    url: 'index.php?action=projects',
                    data: {
                        projectId: buttonRequest.attr('id'),
                        askForInvitation: 'askForInvitation',
                        requesterUserId: <?php echo $id; ?>
                    },
                    success: function(response) {
                        if (response == 1 || response == 0) {
                            console.log(response);
                            alert("la demande est transmise");
                            buttonRequest.html("invitation envoyer");
                            buttonRequest.attr("disabled", true);
                        } else {
                            alert("une erreur est survenu");
                        }
                    },

                });
            });
        });
    </script>