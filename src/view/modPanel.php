<?php include 'modHeader.php' ?>

<a class="h1 text-dark card-link" href="index.php?action=modPanel">Panneau d'administration</a>
<br><br>

<div class="card">
  <div class="card-header">
  <nav>
    <div class="nav nav-pills" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-users-tab" data-toggle="pill" href="#nav-users" role="tab" aria-controls="nav-users" aria-selected="true">Utilisateurs <span class="badge badge-light"><?php echo $users->rowCount(); ?></span></a>
      <a class="nav-item nav-link" id="nav-administrator-tab" data-toggle="pill" href="#nav-administrator" role="tab" aria-controls="nav-administrator" aria-selected="false">Administrateurs <span class="badge badge-light"><?php echo $admins->rowCount(); ?></span></a>
    </div>
  </nav>
  </div>
  <div class="card-body">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
      <table class="table table-hover table-responsive-lg border" id="user_table">
      <thead class="thead-light">
        <tr>
          <th class="text-left">Identifiant</th>
          <th class="text-left">Prénom</th>
          <th class="text-left">Nom</th>
          <th class="text-left">Adresse email</th>
          <th class="text-left">Date d'inscription</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user):?>
        <tr>
          <td class="text-left"><?php echo $user['username']?></td>
          <td class="text-left"><?php echo $user['first_name']?></td>
          <td class="text-left"><?php echo $user['last_name']?></td>
          <td class="text-left"><?php echo $user['email']?></td>
          <td class="text-left"><?php echo date('d/m/Y', strtotime($user['reg_date']))?></td>
          <td class="btn-link">
            <div class="dropdown">
              <button class="btn btn-link dropdown-toggle p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" role="button" aria-controls="collapseExample" aria-expanded="false">Action </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="index.php?action=modPanel&editUser=changerole&role=admin&user=<?php echo $user['username'] ?>">Statut : Administrateur</a>
                <div class="dropdown-divider"></div>
                <button class="btn btn-link text-danger dropdown-item" data-toggle="modal" data-target="#confirmDelUser<?php echo $user['username'] ?>">Supprimer l'utilisateur</button>
              </div>
            </div>
          </td>
        </tr>
        <div class="modal fade" id="confirmDelUser<?php echo $user['username'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmer la suppression</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <p>Cette action supprimera cet utilisateur, continuer ?</p>
            </div>
            <div class="modal-footer">          
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
              <a class="btn btn-danger" href="index.php?action=modPanel&editUser=delete&user=<?php echo $user['username'] ?>" role"button">Confirmer la suppression</a>
            </div>
          </div>
        </div>
        <?php endforeach;?>
      </tbody>
      </table>
      </div>
  
      <div class="tab-pane fade" id="nav-administrator" role="tabpanel" aria-labelledby="nav-administrator-tab">
      <table class="table table-hover table-responsive-lg border" id="admin_table">
      <thead class="thead-light">
        <tr>
          <th class="text-left">Identifiant</th>
          <th class="text-left">Prénom</th>
          <th class="text-left">Nom</th>
          <th class="text-left">Adresse email</th>
          <th class="text-left">Date d'inscription</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($admins as $admin):?>
        <tr>
          <td class="text-left"><?php echo $admin['username']?></td>
          <td class="text-left"><?php echo $admin['first_name']?></td>
          <td class="text-left"><?php echo $admin['last_name']?></td>
          <td class="text-left"><?php echo $admin['email']?></td>
          <td class="text-left"><?php echo date('d/m/Y', strtotime($admin['reg_date']))?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
      </table>
      </div>
      </div>
    </div>
  </div>
</div>


<!-- DataTables -->
<script>
$(document).ready( function () {
    $('#user_table, #admin_table, #report_table').DataTable( {
        "language": {
	        "sProcessing":     "Traitement en cours...",
	        "sSearch":         "Rechercher&nbsp;:",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments par page",
	        "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
	        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
	        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
	        "sInfoPostFix":    "",
	        "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
	        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
	        "oPaginate": {
	        	"sFirst":      "Premier",
	        	"sPrevious":   "Pr&eacute;c&eacute;dent",
	        	"sNext":       "Suivant",
	        	"sLast":       "Dernier"
	        },
	        "oAria": {
	        	"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
	        	"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
	        }
        }
    } );
} );
</script>
<style>table.dataTable{clear:both;margin-top:6px !important;margin-bottom:6px !important;max-width:none !important;border-collapse:collapse !important}table.dataTable td,table.dataTable th{-webkit-box-sizing:content-box;box-sizing:content-box}table.dataTable td.dataTables_empty,table.dataTable th.dataTables_empty{text-align:center}table.dataTable.nowrap th,table.dataTable.nowrap td{white-space:nowrap}div.dataTables_wrapper div.dataTables_length label{font-weight:normal;text-align:left;white-space:nowrap}div.dataTables_wrapper div.dataTables_length select{width:75px;display:inline-block}div.dataTables_wrapper div.dataTables_filter{text-align:right}div.dataTables_wrapper div.dataTables_filter label{font-weight:normal;white-space:nowrap;text-align:left}div.dataTables_wrapper div.dataTables_filter input{margin-left:0.5em;display:inline-block;width:auto}div.dataTables_wrapper div.dataTables_info{padding-top:0.85em;white-space:nowrap}div.dataTables_wrapper div.dataTables_paginate{margin:0;white-space:nowrap;text-align:right}div.dataTables_wrapper div.dataTables_paginate ul.pagination{margin:2px 0;white-space:nowrap;justify-content:flex-end}div.dataTables_wrapper div.dataTables_processing{position:absolute;top:50%;left:50%;width:200px;margin-left:-100px;margin-top:-26px;text-align:center;padding:1em 0}table.dataTable thead>tr>th.sorting_asc,table.dataTable thead>tr>th.sorting_desc,table.dataTable thead>tr>th.sorting,table.dataTable thead>tr>td.sorting_asc,table.dataTable thead>tr>td.sorting_desc,table.dataTable thead>tr>td.sorting{padding-right:30px}table.dataTable thead>tr>th:active,table.dataTable thead>tr>td:active{outline:none}table.dataTable thead .sorting,table.dataTable thead .sorting_asc,table.dataTable thead .sorting_desc,table.dataTable thead .sorting_asc_disabled,table.dataTable thead .sorting_desc_disabled{cursor:pointer;position:relative}table.dataTable thead .sorting:before,table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:before,table.dataTable thead .sorting_desc_disabled:after{position:absolute;bottom:0.9em;display:block;opacity:0.3}table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before{right:1em;content:"\2191"}table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after{right:0.5em;content:"\2193"}table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:after{opacity:1}table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:after{opacity:0}div.dataTables_scrollHead table.dataTable{margin-bottom:0 !important}div.dataTables_scrollBody table{border-top:none;margin-top:0 !important;margin-bottom:0 !important}div.dataTables_scrollBody table thead .sorting:after,div.dataTables_scrollBody table thead .sorting_asc:after,div.dataTables_scrollBody table thead .sorting_desc:after{display:none}div.dataTables_scrollBody table tbody tr:first-child th,div.dataTables_scrollBody table tbody tr:first-child td{border-top:none}div.dataTables_scrollFoot>.dataTables_scrollFootInner{box-sizing:content-box}div.dataTables_scrollFoot>.dataTables_scrollFootInner>table{margin-top:0 !important;border-top:none}@media screen and (max-width: 767px){div.dataTables_wrapper div.dataTables_length,div.dataTables_wrapper div.dataTables_filter,div.dataTables_wrapper div.dataTables_info,div.dataTables_wrapper div.dataTables_paginate{text-align:center}}table.dataTable.table-sm>thead>tr>th{padding-right:20px}table.dataTable.table-sm .sorting:before,table.dataTable.table-sm .sorting_asc:before,table.dataTable.table-sm .sorting_desc:before{top:5px;right:0.85em}table.dataTable.table-sm .sorting:after,table.dataTable.table-sm .sorting_asc:after,table.dataTable.table-sm .sorting_desc:after{top:5px}table.table-bordered.dataTable th,table.table-bordered.dataTable td{border-left-width:0}table.table-bordered.dataTable th:last-child,table.table-bordered.dataTable th:last-child,table.table-bordered.dataTable td:last-child,table.table-bordered.dataTable td:last-child{border-right-width:0}table.table-bordered.dataTable tbody th,table.table-bordered.dataTable tbody td{border-bottom-width:0}div.dataTables_scrollHead table.table-bordered{border-bottom-width:0}div.table-responsive>div.dataTables_wrapper>div.row{margin:0}div.table-responsive>div.dataTables_wrapper>div.row>div[class^="col-"]:first-child{padding-left:0}div.table-responsive>div.dataTables_wrapper>div.row>div[class^="col-"]:last-child{padding-right:0}</style>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

</body>
</html>