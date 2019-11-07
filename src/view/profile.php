<a class="h1 text-dark card-link" href="index.php?action=profile">Profil</a>
<br><br>

<div class="row">

  <div class="col-sm-3 mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><?php echo $infoUser['first_name'] ?> <?php echo $infoUser['last_name'] ?></h5>
        <h6 class="card-subtitle mb-2 text-muted"><?php echo $infoUser['email'] ?></h6>
        </br>
        <div class="clearfix">
          <button type="button" class="btn btn-outline-primary btn-sm float-left" data-toggle="modal" data-target="#editInfoModal">Modifier</button>
          <a class="btn btn-outline-danger btn-sm float-right" href="index.php?action=deleteAccount" role="button">Fermer le compte</a>
        </div>
      </div>
    </div>
    </br>
    <div class="card">
      <div class="card-body p-3">
        <h6><?php $_SESSION['role'] == "admin" ? print 'Administrateur' : print 'Utilisateur' ?></h6>
        <p class="card-text">Inscrit le <?php $date = date("j/m/Y", strtotime($infoUser['reg_date']));
                                        echo $date; ?></p>
      </div>
    </div>
    </br>
  </div>

  <div class="col-sm-9 mx-auto">
    <div class="card">
      <div class="card-header">Projet</div>
      <div class="card-body">
        <div class="form-group">
          <label for="exampleFormControlInput1">Nombre de projets où je participe</label>
          <div required class="form-control bg-secondary" name="title" type="text" readonly>
            <p class="text-white" id="nbProject"><?php echo $userNumberOfProject[0] ?></p>
          </div>
        </div>
      </div>
    </div>
    </br>

    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">Invitations en attentes</div>
          <div class="card-body">
            <?php foreach ($userInvitations as $value) : ?>
              <div class="card mt-4 invitationOrRequestCard">
                <div class="card-header">
                  <h6><?php echo $value['name'] ?></h6>
                </div>
                <div class="card-body">
                  <div class="justify-content-between row">
                    <div class="col-md">
                      <button class="btn btn-success btn-default btn-block acceptInvitation" id="<?php echo ($value['project_id']); ?>">Accepter</button>
                    </div>
                    <div class="col-md">
                      <button class="btn btn-danger btn-default btn-block cancelRequestOrInvitation" id="<?php echo ($value['project_id']); ?>">Refuser</button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      </br>
      <div class="col">
        <div class="card">
          <div class="card-header">Requête en attentes</div>
          <div class="card-body">
            <?php foreach ($userRequests as $value) : ?>
              <div class="card mt-4 invitationOrRequestCard">
                <div class="card-body">
                  <div class="justify-content-between row">
                    <div class="col-sm">
                      <h6><?php echo $value['name'] ?></h6>
                    </div>
                    <div class="col-sm my-auto">
                      <button class="btn btn-danger float-right py-1 cancelRequestOrInvitation" type="button" id="<?php echo ($value['project_id']); ?>">Annuler la requête</button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
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
          <form method="POST" data-toggle="validator" action="index.php?action=profile&editInfo=1">
            <div class="form-group">
              <label for="InputLogin1">Identifiant</label>
              <input type="textfield" class="form-control" id="InputLogin1" name="username" value="<?php echo $infoUser['username'] ?>" required>
            </div>
            <div class="form-group form-row">
              <div class="col">
                <label for="InputPassword1">Prénom</label>
                <input type="textfield" class="form-control" id="InputFirstname" name="firstname" value="<?php echo $infoUser['first_name'] ?>" required>
              </div>
              <div class="col">
                <label for="InputPassword1">Nom</label>
                <input type="textfield" class="form-control" id="InputLastname" name="lastname" value="<?php echo $infoUser['last_name'] ?>" required>
              </div>

            </div>
            <div class="form-group form-row">
              <div class="col">
                <label for="InputPassword1">Email</label>
                <input type="email" class="form-control" id="InputEmail" name="email" value="<?php echo $infoUser['email'] ?>" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Modifier</button>
            <a class="btn btn-link" href="index.php?action=resetPassword&enterMailResetPassword=1" role="button">Réinitialiser le mot de passe</a>
          </form>
        </div>
      </div>
    </div>
  </div>

  </body>

  </html>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script>
        $(document).ready(function() {     
            $(".cancelRequestOrInvitation").click(function() {
                var clickedButton = $(this);
                
                $.ajax({
                    type: 'POST',
                    url: 'index.php?action=profile',
                    data: {
                        projectId: clickedButton.attr('id'),
                        cancelRequestOrInvitation: 'cancelRequestOrInvitation'
                    },
                    success: function(response) {
                        if (response == 1) {
                            clickedButton.closest(".invitationOrRequestCard").remove();
                        }
                    },
                });
            });
        });

        $(document).ready(function() {     
            $(".acceptInvitation").click(function() {
                var clickedButton = $(this);
                
                $.ajax({
                    type: 'POST',
                    url: 'index.php?action=profile',
                    data: {
                        projectId: clickedButton.attr('id'),
                        acceptInvitation: 'acceptInvitation'
                    },
                    success: function(response) {
                        if (response == 1) {
                          $("#nbProject").html(parseInt($("#nbProject").html())+1)
                            clickedButton.closest(".invitationOrRequestCard").remove();
                        }
                    },
                });
            });
        });
    </script>