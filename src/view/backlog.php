<div class="container mt-3">
  <h4 class="mb-1">Rôles du projet</h4>

  <div class="accordion" id="accordionRole">
    <?php foreach ($roles as $role) : ?>
      <div class="card" id="card<?php echo $role["id"]; ?>">
        <div class="card-header" id="heading<?php echo $role["id"]; ?>">
          <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $role["id"]; ?>" aria-expanded="true" aria-controls="collapse<?php echo $role["id"]; ?>">
              <?php echo $role["name"]; ?>
            </button>
          </h5>
        </div>
        <div id="collapse<?php echo $role["id"]; ?>" class="collapse" aria-labelledby="heading<?php echo $role["id"]; ?>" data-parent="#accordionRole">
          <div class="card-body">
            <?php echo $role["description"]; ?>
          </div>
          <div class="card-footer">
            <button type="button" class="btn btn-danger removeRoleButton" data-roleid="<?php echo $role["id"]; ?>">
              Suppprimer
            </button>
            <button type="button" class="btn btn-primary" data-target='#addOrModifyRoleToProjectModal' data-toggle="modal" class="addOrModifyRoleToProjectLink" data-roleid="<?php echo $role["id"]; ?>" data-rolename="<?php echo $role["name"]; ?>" data-roleDescription="<?php echo $role["description"]; ?>" data-projectid="<?php echo $projectId; ?>"  data-writeEndTo="card<?php echo $role["id"]; ?>">
              Modifier
            </button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="card">
    <div class="card-body" id="divAddRole">
      <button class="btn btn-primary btn-lg btn-block " type="button" data-target='#addOrModifyRoleToProjectModal' data-toggle="modal" class="addOrModifyRoleToProjectLink" data-projectid="<?php echo $projectId; ?>" data-writeEndTo="accordionRole">Ajouter un nouveaux rôle</button>
    </div>
  </div>
</div>
<h1 class="text-center">Team Design Section with Pure CSS Effect</h1>
<!-- User storys-->
<div class="container">
  <div class="row" id="rowUS">
    <?php foreach ($userStories as $userStory) : $roleName = ($userStory["role_id"] != null) ? $rolesID[($userStory["role_id"])] : "pas de role"; ?>
      <!--one US-->

      <div class="col-lg-4 usTop" id="US<?php echo $userStory['id']; ?>">

        <div class="userstory">

          <div class="userstory-front">
            <img src="http://placehold.it/110x110/85D9E8/000?text=<?php echo $userStory['name']; ?>" class="img-fluid" alt=""/>
            <p>effort: <?php echo $userStory['effort']; ?> / Priorité: <?php echo $userStory['priority']; ?> </p>
            <p><?php echo $roleName ?></p>
          </div>

          <div class="userstory-back">
            <div class="row">
              <div class="col">
                <button data-target='#addOrModifyUSToProjectModal' data-toggle="modal" class="btn btn-primary-outline" data-projectid="<?php echo $projectId; ?>" data-userstoryid="<?php echo $userStory['id']; ?>"  data-usname="<?php echo $userStory['name']; ?>"  data-roleid="<?php echo $userStory['role_id']; ?>"  data-done="<?php echo $userStory['done']; ?>" data-effort="<?php echo $userStory['effort']; ?>" data-priority="<?php echo $userStory['priority']; ?>" data-ican="<?php echo $userStory['i_can']; ?>" data-sothat="<?php echo $userStory['so_that']; ?>" data-writeEndTo="US<?php echo $userStory['id']; ?>" type="button">
                <em class='fas fa-pen' style="color:blue" title="Modifier US" ></em>
              </div>
              <div class="col">
                <button class="btn btn-primary-outline float-right removeUsButton" data-userstoryid="<?php echo $userStory['id']; ?>" type="button"><em class='fas fa-times' style="color:red" title="Modifier US"></em>
              </div>
            </div>
            <span>
              <p><strong>En tant que</strong> <?php echo $roleName ?></p>
            </span>
            <span>
              <p><strong>Je peux</strong> <?php echo $userStory['i_can']; ?></p>
            </span>
            <span>
              <p><strong>Afin De </strong><?php echo $userStory['so_that']; ?></p>
            </span>
          </div>

        </div>
      </div>
      <!--one US-->
    <?php endforeach; ?>

    
  </div>
  <div class="col-lg-4 text-center">
      <button type="button" class="btn btn-primary btn-lg" style="height:auto; " data-target='#addOrModifyUSToProjectModal' data-toggle="modal"  data-projectid="<?php echo $projectId; ?>" data-writeEndTo="rowUS">
        <em class='fas fa-plus fa-3x' style="color:white; " title="Modifier US"></em>
      </button>
    </div>
</div>
<link rel="stylesheet" href="backlog.css">
<script>
  $(document).ready(function() {

    $(document).on("click", ".removeRoleButton", function() {
      var r = confirm("Cette action est irréversible confirmez, vous la suppression ?");
      if (r) {
        var roleId = $(this).data('roleid');
        var button = $(this);
        $.ajax({
          type: 'POST',
          url: 'index.php?action=backlog',
          data: {
            projectIdToModifyRole: "exist",
            removeRole: true,
            roleId: roleId

          },
          success: function(response) {
            button.closest('.card').remove();

          }
        })

      }

    })

    $(document).on("click", ".removeUsButton", function() {
      var r = confirm("Cette action est irréversible confirmez, vous la suppression ?");
      if (r) {
        var UsId = $(this).data('userstoryid');
        var button = $(this);
        $.ajax({
          type: 'POST',
          url: 'index.php?action=backlog',
          data: {
            projectIdToModifyUS: "exist",
            removeUSId: UsId,

          },
          success: function(response) {
            button.closest('.usTop').remove();

          }
        })

      }

    })



  })
</script>